<?php

namespace Lab1353\Monkyz\Controllers;

use File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Lab1353\Monkyz\Models\DynamicModel;

class PanelController extends MonkyzController
{

	public function __construct()
	{
		$this->init();
	}

	public function getDashboard()
	{
		// counters
		$cache_key = 'monkyz-counters';
		$counters = [];

		if (Cache::has($cache_key)) {
			$counters = Cache::get($cache_key);
		} else {
			$c_counters = config('monkyz-widgets.counters', []);
			$tables = $this->htables->getTables();
			foreach ($tables as $table => $params) {
				if ($params['visible'] && in_array($table, $c_counters)) {
					$m = new DynamicModel($table);
					$c = $m->count();

					$counters[$table] = [
						'count' => $c,
						'icon'  => $params['icon'],
					];
				}
			}
			Cache::put($cache_key, $counters, (int)config('monkyz.cache_minutes', 60));
		}

		$data = [
			'php'   => request()->server('PHP_VERSION'),
			'server'   => request()->server('SERVER_ADDR'),
			'web'   => request()->server('SERVER_SOFTWARE'),
		];

		return view('monkyz::panel.dashboard')->with(compact('counters','data'));
	}

	public function getInfo()
	{
		$path = dirname(dirname(__DIR__));
		$file = str_finish($path, '/').'CHANGELOG.md';
		$content = File::get($file);
		$content = substr($content, strpos($content, '[')+1);
		$version = substr($content, 0, strpos($content, ' '));
		
		$page_title = '<i class="fa fa-info"></i>Monkyz <small>'.$version.'</small>';

		return view('monkyz::panel.info')->with(compact('version', 'page_title'));
	}
}