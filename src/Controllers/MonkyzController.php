<?php

namespace Lab1353\Monkyz\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Lab1353\Monkyz\Helpers\TablesHelper as HTables;
use Illuminate\Support\Facades\Route;

class MonkyzController extends Controller
{
	protected $htables;

	public function init()
	{
		if(!\DB::connection()->getDatabaseName())
		{
			abort(404, 'Database connection refused!');
		}
		$this->middleware('Lab1353\Monkyz\Middleware\ForceSchema');
		$this->storeViewShare();
	}

    public function storeViewShare()
    {
    	// assets
    	//$monkyz_assets = str_replace(['http:','https:'], '', str_finish(url('/vendor/monkyz/'), '/'));
    	$monkyz_assets = '/vendor/monkyz/';

    	// sections
    	$this->htables = new HTables();
		$tables = $this->htables->getTables();

		// route name
		$section_name = \Request::path();
		$section_name = str_replace(config('monkyz.prefix').'/', '', $section_name);
		while (strpos($section_name, '/')!==false) {
			$section_name = dirname($section_name);
		}
		$page_title = 'Monkyz <small>for '.$_SERVER['HTTP_HOST'].'</small>';

    	view()->share(compact('monkyz_assets', 'tables', 'section_name', 'page_title'));
    }
}
