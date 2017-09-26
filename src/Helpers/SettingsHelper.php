<?php
namespace Lab1353\Monkyz\Helpers;

use Setting;
use Lab1353\Monkyz\Helpers\TablesHelper as HTables;

class SettingsHelper
{
	public function resetDefault()
	{
		$settings = $this->getDefault();
		$this->saveAll($settings);
	}

	/***********
	 * DEFAULT *
	 ***********/

	private function merge($old, $new)
	{
		$merge = [];

		foreach ($old as $k => $v) {
			$merge[$k] = (array_key_exists($k, $new))  ? $new[$k] : $v;
		}

		return $merge;
	}

	public function getDefault()
	{
		$default = [
			'dashboard_screenshot'	=> true,
			'dashboard_serverinfo'	=> true,
			'dashboard_counters'	=> true,
			'dashboard_analytics'	=> false,
			'analytics_viewid'	=> '',
		];

		$htables = new HTables();
		$tables = $htables->getTables();
		foreach ($tables as $table=>$params) {
			if (!empty($params['visible'])) $default['counters_'.$table] = $params['visible'];
		}

		return $default;
	}

	/*******
	 * GET *
	 *******/

	public function getAll()
	{
		$default = $this->getDefault();
		$settings = $this->merge($default, Setting::all());

		return $settings;
	}


	/********
	 * SAVE *
	 ********/

	public function saveAll($new)
	{
		$old = $this->getAll();
		$settings = $this->merge($old, $new);

		foreach ($settings as $k=>$v) {
			Setting::set($k, $v);
		}
		Setting::save();
	}

}