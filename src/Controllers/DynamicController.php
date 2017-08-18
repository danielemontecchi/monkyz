<?php
namespace Lab1353\Monkyz\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Lab1353\Monkyz\Helpers\FieldsHelper;
use Lab1353\Monkyz\Helpers\FileHelper as HFile;
use Lab1353\Monkyz\Helpers\TablesHelper as HTables;
use Lab1353\Monkyz\Models\DynamicModel;

class DynamicController extends MonkyzController
{
	protected $fields;
	protected $ajax_list;

	public function __construct() {
		$this->init();

		$route = request()->route();
		$section = $route->getParameter('section');
		if (\Schema::hasTable($section)) {
			$fields = $this->fields = $this->htables->getColumns($section);
			$table = $this->htables->getTable($section);
			$this->ajax_list = (!empty($table['ajax_list'])) ? true : false;

			view()->share(compact('table', 'fields', 'section'));
		} else {
			abort(404, 'Table '.$section.' not found!');
		}
	}

	public function getList($section)
	{
		$records = [];
		if (!$this->ajax_list) {
			$model = new DynamicModel($section);
			$records = $model->get()->toArray();
		}

		// datatables
		$dt = '
		$(document).ready(function(){
			$(".table").DataTable( {';

		$dt.='
			"pagingType": "full_numbers",
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		';
		if ($this->ajax_list) {
			$dt.='
				"processing": true,
				"serverSide": true,
			';
		}
		$dt.='
			"ajax": "'.route('monkyz.dynamic.page', compact('section')).'",
			responsive: true,';

		switch (strtolower(\App::getLocale())) {
			case 'it':	$language = 'Italian'; break;
			case 'es':	$language = 'Spanish'; break;
			case 'fr':	$language = 'French'; break;
			case 'de':	$language = 'Dutch'; break;
			case 'pt':	$language = 'Portuguese'; break;
			case 'ru':	$language = 'Russian'; break;

			case 'en':
			default:
				$language = 'English';
				break;
		}
		$dt.='
			"language": {
				"url": "//cdn.datatables.net/plug-ins/'.config('monkyz.vendors.datatables', '1.10.12').'/i18n/'.$language.'.json"
			},';

		$i = 0;
		$dt_order = '';
		$dt .= '"columns": [ ';
		foreach ($this->fields as $column=>$params) {
			if ($params['in_list']) {
				$dt .= '{"data":"'.$column.'",';
				if (in_array($params['input'], ['checkbox','color','file','image'])) {
					$dt .= '"orderable": false';
				} else {
					$dt .= '"orderable": true';
				}
				$dt .= '}, ';
				if ($params['input']=='text' && empty($dt_order)) {
					$dt_order = '
						"order": [[ '.$i.', "asc" ]],
					';
				}
				if (!empty($params['order'])) {
					$dt_order = '
						"order": [[ '.$i.', "'.$params['order'].'" ]],
					';
				}
				$i++;
			}
		}
		$dt .= '{"data":"actions", "orderable": false} ],
			'.$dt_order;

		$dt .= '
			});
		});
		';

		$scripts_datatables = $dt;

		$table_params = $this->htables->getTable($section);
		$page_title = '<i class="'.$table_params['icon'].'"></i>'.ucfirst($section).' <small>list</small>';
		$ajax_list = $this->ajax_list;
		$key = $this->htables->findKeyFieldName($section);

		return view('monkyz::dynamic.list')->with(compact('scripts_datatables', 'page_title', 'ajax_list', 'records', 'key'));
	}

	public function ajaxPagination(Request $request, $section)
	{
		$fields = array_keys($this->fields);
		$fields_list = $this->htables->getColumnsInList($section);
		$key = $this->htables->findKeyFieldName($section);
		$model = new DynamicModel($section);
		$items = null;
		$recordsTotal = $model->count();
		$recordsFiltered = 0;
		$draw = $request->input('draw', 1);

		if ($this->ajax_list) {
			$order = $request->input('order');
			$start = $request->input('start', 0);
			$length = $request->input('length', 0);
			$search = $request->input('search.value', '');
			// order
			$order_column = $key;
			$order_dir = 'asc';
			if (!empty($order)) {
				$columns = $request->input('columns');
				$col_ind = (int)$order[0]['column'];
				$order_column = $columns[$col_ind]['data'];
				$order_dir = $order[0]['dir'];
			}
			// search
			$search_str = '';
			if (!empty($search)) {
				foreach ($fields as $column => $param) {
					if (!empty($param['in_list'])) {
						if (!empty($search_str)) $search_str .= ' OR ';
						$search_str .= $column." LIKE '%$search%'";
					}
				}
			}
			if (empty($search_str)) $search_str = '1=1';

			$items = $model->select($fields)->whereRaw($search_str)->orderBy($order_column, $order_dir)->skip($start)->take($length)->get()->toArray();
			$recordsFiltered = ($search_str == '1=1') ? $recordsTotal : count($items);
		} else {
			$items = $model->select($fields)->get()->toArray();
			$recordsFiltered = $recordsTotal;
		}
		$return = [];
		$records = [];
		foreach ($items as $k=>$item) {
			$new = $item;
			foreach ($fields as $field) {
				if (in_array($field, $fields_list)) {
					$new[$field] = FieldsHelper::renderInList($this->fields[$field], $new[$field], true);
				} else {
					unset($new[$field]);
				}
			}
			$new['actions'] = '
				<a href="'.route('monkyz.dynamic.edit', [ 'id'=>$item[$key], 'section'=>$section ]).'" class="btn btn-sm btn-fill btn-primary"><i class="fa fa-pencil"></i>Edit</a>
				<a href="'.route('monkyz.dynamic.delete', [ 'id'=>$item[$key], 'section'=>$section ]).'" class="btn btn-sm btn-fill btn-danger btn-delete-record"><i class="fa fa-trash"></i>Delete</a>
			';
			$records[] = (object)$new;
		}
		$return['data'] = $records;
		$return["draw"] = $draw;
		$return["recordsTotal"] = $recordsTotal;
		$return["recordsFiltered"] = $recordsFiltered;

		return $return;
	}

	public function getEdit($section, $id=0)
	{
		$fields = $this->fields;
		$is_add_mode = true;
		$last_edit = false;

		$model = new DynamicModel($section);
		if (!empty($id)) {
			$is_add_mode = false;
			$record = $model->find($id);

			// check if is the last record in table
			$model = new DynamicModel($section);
			$model = $model->orderBy('id', 'desc')->first();
			$last_edit = ($model->id==$id);
		} else {
			$record = $model;
		}

		foreach ($fields as $field=>$params) {
			if ($is_add_mode && !empty($params['default'])) {
				$record->$field = $params['default'];
			}
			if (in_array($params['input'], ['datetime', 'date'])) {
				$dt = new Carbon($record->$field);
				$record->$field = $dt;
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
			$fields = $this->fields;

			$model = new DynamicModel($section);
			$field_key = $model->getKeyName();	// $this->htables->findKeyFieldName($section)

			$fields_dates = [];
			$config_input_from_type = config('monkyz-tables.input_from_type');
			if (!empty($config_input_from_type['date'])) $fields_dates = array_merge($fields_dates, $config_input_from_type['date']);
			if (!empty($config_input_from_type['datetime'])) $fields_dates = array_merge($fields_dates, $config_input_from_type['datetime']);
			$id = $data[$field_key];

			$files_upload = [];
			$record = (!empty($id)) ? $model->find($id) : $model;
			foreach ($fields as $field=>$params) {
				if ($params['in_edit']) {
					$value = (!empty($data[$field])) ? $data[$field] : '';
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
							if (!empty($value)) $files_upload[$field] = $params;
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
					foreach ($files_upload as $field=>$params) {
						$filename = $this->saveFile($request, $field, $params);
						if (!empty($filename)) {
							// save in model
							$record->$field = $filename;
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
						->with('success', 'You have successfully saved #'.$id.'!')
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

	private function saveFile($request, $field, $params)
	{
		$file_name = '';
		if (!empty(Input::file($field)) && Input::file($field)->isValid()) {
			$path_temp = config('monkyz.path_public_temp');

			// get file name
			$file_ext = strtolower($request->file($field)->getClientOriginalExtension());
			$file_name = strtolower($request->file($field)->getClientOriginalName());
			$file_name = str_replace('.'.$file_ext, '', $file_name);
			$file_name = str_slug($file_name);
			$file_name .= '.'.$file_ext;

			if (!empty($file_name)) {
				// get disk
				$disk = 'local';
				if (!empty($params['file']['disk'])) $disk = $params['file']['disk'];

				// get correct path
				$file_path = '';
				if (!empty($params['file']['path'])) $file_path = $params['file']['path'];
				$file_path = str_finish($file_path, '/');
				if (substr($file_path, 0, 1) != '/') $file_path = '/'.$file_path;
				if (!Storage::disk($disk)->exists($file_path)) Storage::disk($disk)->makeDirectory($file_path);

				// put file upload in monkyz temp file
				$temp_file = time().'_'.$file_name;
				$temp_path = str_finish(public_path($path_temp), '/');
				if (!File::exists($temp_path)) File::makeDirectory($temp_path, 0775, true);

				// upload file
				if (!Storage::disk($disk)->has($file_path.$file_name) || $params['file']['overwrite']) {
					$request->file($field)->move($temp_path, $temp_file);
					if ($params['file']['resize']) {
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

			}
		}

		return $file_name;
	}

	public function getDelete($section, $id)
	{
		$model = new DynamicModel($section);

		$fields = $this->fields;
		$field_key = $this->htables->findKeyFieldName($section);
		$files = [];
		$useSoftDelete = false;
		$record = $model->where($field_key, $id)->first();

		if (!empty($record->id)) {
			foreach ($fields as $field=>$params) {
				if (in_array($params['input'], ['file', 'image'])) {
					$files[$field] = $record->$field;
				}
				if ($field=='deleted_at') {
					$useSoftDelete = true;
				}
			}

			if ($record->delete()) {

				// delete files
				if (!$useSoftDelete && !empty($files)) {
					foreach ($files as $field=>$file) {
						$field_params = $fields['fields'][$field]['file'];
						$disk = $field_params['disk'];

						if (!empty($disk)) {
							$hfile = new HFile($disk);
							$hfile->delete($field_params, $file);
						}
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
		} else {
			return redirect()
				->back()
				->with('error', 'Record #'.$id.' not found!')
			;
		}
	}
}
