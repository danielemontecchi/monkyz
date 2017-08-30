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

		// counters
		$cache_key = 'monkyz-widgets-counters';
		$counters = [];
		if (!empty($settings['dashboard_counters'])) {
			if (Cache::has($cache_key)) {
				$counters = Cache::get($cache_key);
			} else {
				$tables = $this->htables->getTables();
				$config_tables = array_keys(config('monkyz-tables.tables'));
				foreach ($tables as $table => $params) {
					if (in_array($table, $config_tables)) {
						if (!empty($settings['counters_'.$table])) {
							$m = new DynamicModel($table);
							$c = $m->count();

							$counters[$table] = [
								'count' => $c,
								'icon'  => $params['icon'],
							];
						}
					}
				}
				Cache::put($cache_key, $counters, (int)config('monkyz.cache_minutes', 60));
			}
		}

		// serverinfo
		$serverinfo = [];
		if (!empty($settings['dashboard_serverinfo'])) {
			$serverinfo = [
				'url'	=> config('app.url'),
				'php version'   => request()->server('PHP_VERSION'),
				'server ip'   => request()->server('SERVER_ADDR'),
				'web server'   => request()->server('SERVER_SOFTWARE'),
			];
		}

		// analytics
		$analytics = [];
		if (!empty($settings['dashboard_analytics'])) {
			$cache_key = 'monkyz-widgets-analytics';
			if (Cache::has($cache_key)) {
				$analytics = Cache::get($cache_key);
			} else {
				$viewId = $settings['analytics_viewid'];
				if (!empty($viewId)) {
					$config = config('laravel-analytics');
					$client = \Spatie\Analytics\AnalyticsClientFactory::createForConfig($config);
					$classAnalytics = new \Spatie\Analytics\Analytics($client, $viewId);
					$analytics['TotalVisitorsAndPageViews'] = $classAnalytics->fetchTotalVisitorsAndPageViews(\Spatie\Analytics\Period::days(14));
					Cache::put($cache_key, $analytics, (int)config('monkyz.cache_minutes', 60));
				} else {
					$analytics = 'Set parameter viewId in <a href="'.route('monkyz.settings').'" style="color:#FFF">Settings page</a>';
				}
			}
		}

		return view('monkyz::panel.dashboard')->with(compact('counters','serverinfo','settings','analytics'));
	}

	public function getInfo()
	{
		$path = dirname(dirname(__DIR__));

		// CHANGELOG
		$content = File::get(str_finish($path, '/').'CHANGELOG.md');
		$content = substr($content, strpos($content, '#development)')+13);
		$content = substr($content, strpos($content, '[')+1);
		$version = substr($content, 0, strpos($content, ' '));

		// PAGE TITLE
		$page_title = '<i class="fa fa-info"></i>Monkyz <small>'.$version.'</small>';

		// README
		$content = File::get(str_finish($path, '/').'README.md');
		$content = substr($content, strpos($content, '### Links'));
		$content = substr($content, 0, strpos($content, "\n## "));
		$content = str_replace("\n", '', $content);

		$md_links = substr($content, strpos($content, '### Links')+9);
		$md_links = substr($md_links, 0, strpos($md_links, '### Vendors'));
		$md_vendors = substr($content, strpos($content, '### Vendors')+11);
		$md_vendors = substr($md_vendors, strpos($md_vendors, ':')+1);
		$md_vendors = substr($md_vendors, 0, strpos($md_vendors, '### Tools'));
		$md_tools = substr($content, strpos($content, '### Tools')+9);

		$urls = [
			'links' => $this->convertMDListToArray($md_links),
			'vendors' => $this->convertMDListToArray($md_vendors),
			'tools' => $this->convertMDListToArray($md_tools),
		];

		return view('monkyz::panel.info')->with(compact('page_title', 'urls'));
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
