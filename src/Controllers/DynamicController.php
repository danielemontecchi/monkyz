<?php

namespace Lab1353\Monkyz\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Lab1353\Monkyz\Models\DynamicModel;
use Lab1353\Monkyz\Helpers\TablesHelper as HTables;

class DynamicController extends MonkyzController
{
	public function __construct() {
		parent::__construct();

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

    	return view('monkyz::dynamic.list')->with(compact('records'));
    }

    public function getEdit($section, $id=0)
    {
    	$model = new DynamicModel;
		$model->setTable($section);
		if ($id>0) {
    		$record = $model->find($id);
		} else {
			$record = $model;
		}

    	return view('monkyz::dynamic.edit')->with(compact('record'));
    }
}
