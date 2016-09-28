<?php

namespace Lab1353\Monkyz\Controllers;

use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Lab1353\Monkyz\Models\DynamicModel;
use Lab1353\Monkyz\Helpers\TablesHelper as HTables;

class DynamicController extends MonkyzController
{
	public function __construct() {
    	$this->storeViewShare();

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
		$model = new DynamicModel;
		$model->setTable($section);
		$records = $model->get()->toArray();

		// datatables
		$dt = '
		$(document).ready(function(){
			$(".table").DataTable( {';

		if(\App::getLocale()=='it') {
			$dt.='
				"language": {
					"url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Italian.json"
				},';
		}
		$i = 0;
		$dt_order = '';
		$dt .= '"columns": [ ';
		foreach ($this->htables->getColumns($section) as $column=>$params) {
			if ($params['in_list']) {
				$dt .= '{"orderable": true}, ';
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
		})
		.on("page.dt", reloadLazyLoad())
		.on("stateLoaded.dt", reloadLazyLoad())
		.on("column-reorder", reloadLazyLoad())
		.on("row-reordered", reloadLazyLoad())
		.on("draw.dt", reloadLazyLoad())
		;';
		//TODO: check the correctly call of LazyLoad

		$scripts['datatables'] = $dt;


		return view('monkyz::dynamic.list')->with(compact('records', 'scripts'));
	}

	public function getEdit($section, $id=0)
	{
		$fields = $this->htables->getColumns($section);

		$model = new DynamicModel;
		$model->setTable($section);
		if ($id>0) {
			$record = $model->find($id);
		} else {
			$record = $model;

			foreach ($fields as $field=>$params) {
				if (!empty($params['default'])) {
					$record->$field = $params['default'];
				}
			}
		}

		return view('monkyz::dynamic.edit')->with(compact('record', 'fields'));
	}

	public function postSave(Request $request, $section)
	{
		$data = $request->all();

		if (!empty($data)) {
			$fields = $this->htables->getColumns($section);
			$field_key = 'id';
			foreach ($fields as $field=>$params) {
				if ($params['type']=='key') {
					$field_key = $field;
					break;
				}
			}

			$model = new DynamicModel;
			$model->setTable($section);

			$record = (!empty($data[$field_key])) ? $model->find($data[$field_key]) : $model;
			foreach ($fields as $field=>$params) {
				if ($params['in_edit']) {
					if (in_array($params['input'], ['date','datetime'])) {
						$dt = new Carbon($data[$field]);
						$record->$field = $dt;
					} else {
						$record->$field = $data[$field];
					}
				}
			}

			if ($record->save()) {
				return redirect()
					->route('monkyz.dynamic.list', compact('section'))
					->with('success', 'You have successfully Saved!')
				;
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
}
