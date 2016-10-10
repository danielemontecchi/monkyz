<?php
namespace Lab1353\Monkyz\Controllers;

use Input;
use File;
use Storage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Lab1353\Monkyz\Models\DynamicModel;
use Lab1353\Monkyz\Helpers\TablesHelper as HTables;
use Lab1353\Monkyz\Helpers\FileHelper as HFile;

class DynamicController extends MonkyzController
{
	public function __construct() {
		$this->init();

		$fields = [];
		$route = request()->route();
		$section = $route->getParameter('section');
		if (\Schema::hasTable($section)) {
			$fields = $this->htables->getColumns($section);
			$table = $this->htables->getTable($section);

			view()->share(compact('table', 'fields', 'section'));
		} else {
			abort(404);
		}
	}

	public function getList($section)
	{
		$model = new DynamicModel($section);
		$records = $model->get()->toArray();

		// datatables
		$dt = '
		$(document).ready(function(){
			$(".table").DataTable( {';

		if(\App::getLocale()=='it') {
			$dt.='
	            "pagingType": "full_numbers",
	            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
	            responsive: true,
				"language": {
					"url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Italian.json"
				},';
		}
		$i = 0;
		$dt_order = '';
		$dt .= '"columns": [ ';
		foreach ($this->htables->getColumns($section) as $column=>$params) {
			if ($params['in_list']) {
				if (in_array($params['input'], ['checkbox','color','file','image'])) {
					$dt .= '{"orderable": false}, ';
				} else {
					$dt .= '{"orderable": true}, ';
				}
				if ($params['input']=='text' && empty($dt_order)) {
					$dt_order .= '
						"order": [[ '.$i.', "asc" ]],
					';
				}
				$i++;
			}
		}
		$dt .= '{"orderable": false} ],
			'.$dt_order;

		$dt .= '
			});
		});
		';

		$scripts['datatables'] = $dt;

		$table_params = $this->htables->getTable($section);
		$page_title = '<i class="'.$table_params['icon'].'"></i>'.ucfirst($section).' <small>list</small>';


		return view('monkyz::dynamic.list')->with(compact('records', 'scripts', 'page_title'));
	}

	public function getEdit($section, $id=0)
	{
		$fields = $this->htables->getColumns($section);
		$is_add_mode = true;
		$last_edit = false;

		$model = new DynamicModel($section);
		if (!empty($id)) {
			$field_key = $this->htables->findKeyFieldName($section);
			$is_add_mode = false;
			$record = $model->find($id);

			foreach ($fields as $field=>$params) {
				if (in_array($params['input'], ['datetime', 'date'])) {
					$dt = new Carbon($record->$field);
					$record->$field = $dt;
				}
			}

			$model = new DynamicModel($section);
			$model = $model->orderBy('id', 'desc')->first();
			$last_edit = ($model->id==$id);
		} else {
			$record = $model;

			foreach ($fields as $field=>$params) {
				if (!empty($params['default'])) {
					$record->$field = $params['default'];
				}
				if (in_array($params['input'], ['datetime', 'date'])) {
					$dt = new Carbon($record->$field);
					$record->$field = $dt;
				}
			}
		}

		$table_params = $this->htables->getTable($section);
		$page_title = '<i class="'.$table_params['icon'].'"></i>'.ucfirst($section).' <small>&gt; '.($id>0 ? 'edit #'.$id : 'create').'</small>';

		return view('monkyz::dynamic.edit')->with(compact('record', 'fields', 'is_add_mode', 'page_title', 'last_edit'));
	}

	public function postSave(Request $request, $section)
	{
		$data = $request->all();

		if (!empty($data)) {
			$fields = $this->htables->getColumns($section);

			$model = new DynamicModel($section);
			$field_key = $model->getKeyName();

			$fields_dates = [];
			$config_input_from_type = config('monkyz-tables.input_from_type');
			if (!empty($config_input_from_type['date'])) $fields_dates = array_merge($fields_dates, $config_input_from_type['date']);
			if (!empty($config_input_from_type['datetime'])) $fields_dates = array_merge($fields_dates, $config_input_from_type['datetime']);
			$id = $data[$field_key];

			$files_upload = [];
			$record = (!empty($id)) ? $model->find($id) : $model;
			foreach ($fields as $field=>$params) {
				if ($params['in_edit']) {
					$value = $data[$field];
					switch ($params['input']) {
						case 'checkbox':
							$record->$field = (!empty($value)) ? true : false;
							break;
						
						case 'date':
						case 'datetime':
							$dt = new Carbon($value);
							$record->$field = $dt;
							break;

						case 'hidden':
							// is hide...
							break;

						case 'file':
						case 'image':
							$files_upload[$field] = $params;
							break;
						
						case 'password':
							if (!empty($value)) {
								$record->$field = bcrypt($value);
							}
							break;
							
						default:
							if (in_array($params['input'], $fields_dates)) {
								$value = new Carbon($value);
							} elseif ($params['input']=='password') {
								$value = bcrypt($value);
							}
							$record->$field = $value;
							break;
					}
				}
			}

			if ($record->save()) {
				//TODO: delete file if checked "delete image"
				// save file
				if (!empty($files_upload)) {
					$path_temp = config('monkyz.path_public_temp');
					foreach ($files_upload as $field=>$params) {
						if (Input::file($field)->isValid()) {
							// get file name
							$file_ext = strtolower($request->file($field)->getClientOriginalExtension());
							$file_name = strtolower($request->file($field)->getClientOriginalName());
							$file_name = str_replace('.'.$file_ext, '', $file_name);
							$file_name = str_slug($file_name);
							if (!empty($file_ext)) $file_name .= '.'.$file_ext;

							if (!empty($file_name)) {
								$file_upload = true;

								// get disk
								$disk = 'local';
								if (!empty($params[$params['input']]['disk'])) $disk = $params[$params['input']]['disk'];

								// get correct path
								$file_path = '';
								if (!empty($params[$params['input']]['path'])) $file_path = $params[$params['input']]['path'];
								$file_path = str_finish($file_path, '/');
								if (!Storage::exists($file_path)) Storage::makeDirectory($file_path);

								// put file upload in monkyz temp file
								$temp_file = time().'_'.$file_name;
								$temp_path = str_finish(public_path($path_temp), '/');
								if (!File::exists($temp_path)) File::makeDirectory($temp_path, 0775, true);

								// upload file
								if (!Storage::disk($disk)->has($file_path.$file_name) || $params['file']['overwrite']) {
									$request->file($field)->move($temp_path, $temp_file);
									if ($params['input']=='image' && $params['file']['resize']) {
										$h = $params['file']['resize_height_px'];
										$w = $params['file']['resize_width_px'];
										$img = Image::make($temp_path.$temp_file);
										$img->resize($w, $h);
										//TODO: resize dpi
										$file_content = $img->stream();
									} else {
										$file_content = File::get($temp_path.$temp_file);
									}
									Storage::disk($disk)->put($file_path.$file_name, $file_content);
									File::delete($temp_path.$temp_file);
								}

								// save in model
								$record->$field = $file_name;
							}
						}
					}
					$record->save();
				}

				$redirect = redirect()
						->route('monkyz.dynamic.list', compact('section'))
						->with('success', 'You have successfully Saved!')
					;
				$mode = 'close';
				if (!empty($request->input('submitContinue'))) $mode = 'continue';
				if (!empty($request->input('submitNext'))) $mode = 'next';

				if ($mode!='close') {
					$id = $record->id;
					if ($mode!='continue') {
						// go to next record?
						$next = new DynamicModel($section);
						$next = $next->where($field_key, '>', $id)->orderBy('id')->first();
						$id = $next->id;
					}

					$redirect = redirect()->route('monkyz.dynamic.edit', compact('section','id'))
						->with('success', 'You have successfully Saved!')
					;
				}

				return $redirect;
			} else {
				return redirect()
					->back()
					->with('error', 'There were errors in saving!')
				;
			}
		} else {
			return redirect()
				->back()
				->with('error', 'No data received!')
			;
		}
	}

	public function getDelete($section, $id)
	{
		$model = new DynamicModel($section);

		$fields = $this->htables->getColumns($section);
		$field_key = $this->htables->findKeyFieldName($section);
		$files = [];
		$useSoftDelete = false;
		foreach ($fields as $field=>$params) {
			if (in_array($params['input'], ['file', 'image'])) {
				$files[$field] = '';
			}
			if ($field=='deleted_at') {
				$useSoftDelete = true;
			}
		}

		$record = $model->where($field_key, $id)->first();
		foreach ($files as $field=>$file) {
			$files[$field] = $record->$file;
		}
		if ($record->delete()) {

			// delete files
			if (!$useSoftDelete && !empty($files)) {
				foreach ($files as $field=>$file) {
					$field_params = $params['fields'][$field]['file'];

					$hfile = new HFile($disk);
					$hfile->delete($field_params, $file);
				}
			}

			return redirect()
				->route('monkyz.dynamic.list', compact('section'))
				->with('success', 'You have successfully Deleted the record #'.$id.'!')
			;
		} else {
			return redirect()
				->back()
				->with('error', 'It was an error in the deleting!')
			;
		}
	}
}
