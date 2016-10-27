<?php

namespace Lab1353\Monkyz\Controllers;

use File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Lab1353\Monkyz\Models\DynamicModel;
use Lab1353\Monkyz\Helpers\SettingsHelper as HSettings;

class PanelController extends MonkyzController
{

	public function __construct()
	{
		$this->init();
	}

	public function getDashboard()
	{
		// settings
		$hsettings = new HSettings();
		$settings = $hsettings->getAll();
		$c_counters = $hsettings->getCounters();

		// counters
		$cache_key = $hsettings->cache_key_counters;
		$counters = [];

		if (!empty($settings['dashboard']['counters'])) {
			if (Cache::has($cache_key)) {
				$counters = Cache::get($cache_key);
			} else {
				$tables = $this->htables->getTables();
				foreach ($tables as $table => $params) {
					if ($params['visible'] && !empty($c_counters[$table])) {
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
		}

		$server = [
			'url'	=> config('app.url'),
			'php version'   => request()->server('PHP_VERSION'),
			'server ip'   => request()->server('SERVER_ADDR'),
			'web server'   => request()->server('SERVER_SOFTWARE'),
		];

		return view('monkyz::panel.dashboard')->with(compact('counters','server', 'settings'));
	}

	public function getInfo()
	{
		$path = dirname(dirname(__DIR__));

		// CHANGELOG
		$file = str_finish($path, '/').'CHANGELOG.md';
		$content = File::get($file);
		$content = substr($content, strpos($content, '#development)')+13);
		$content = substr($content, strpos($content, '[')+1);
		$version = substr($content, 0, strpos($content, ' '));

		// README
		$file = str_finish($path, '/').'README.md';
		$content = File::get($file);
		$content = substr($content, strpos($content, '### Links'));
		$content = substr($content, 0, strpos($content, "\n## "));
		$content = str_replace("\n", '', $content);

		$md_links = substr($content, strpos($content, '### Links')+9);
		$md_links = substr($md_links, 0, strpos($md_links, '### Vendors'));
		$md_vendors = substr($content, strpos($content, '### Vendors')+11);
		$md_vendors = substr($md_vendors, strpos($md_vendors, ':')+1);
		$md_vendors = substr($md_vendors, 0, strpos($md_vendors, '### Tools'));
		$md_tools = substr($content, strpos($content, '### Tools')+9);

		$links = $this->convertMDListToArray($md_links);
		$vendors = $this->convertMDListToArray($md_vendors);
		$tools = $this->convertMDListToArray($md_tools);

		// PAGE TITLE		
		$page_title = '<i class="fa fa-info"></i>Monkyz <small>'.$version.'</small>';

		return view('monkyz::panel.info')->with(compact('page_title', 'links', 'vendors', 'tools'));
	}

	private function convertMDListToArray($md)
	{
		$arr = [];
		$t = explode('- ', $md);
		foreach ($t as $v) {
			if (!empty($v)) {
				$name = substr($v, 1, strpos($v, ']')-1);
				$link = substr($v, strpos($v, '(')+1, strpos($v, ')')-strpos($v, '(')-1);
				$arr[$name]	= $link;
			}
		}

		return $arr;
	}
}
