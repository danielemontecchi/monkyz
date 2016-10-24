<?php
namespace Lab1353\Monkyz\Helpers;

use Illuminate\Support\Facades\Cache;
use Lab1353\Monkyz\Helpers\TablesHelper as HTables;

class SettingsHelper
{
	protected $cache_key_settings = 'monkyz-settings';
	public $cache_key_counters = 'monkyz-widgets-counters';
	protected $settings_key_counters = 'counters';


	/*******
	 * GET *
	 *******/

	public function getAll()
	{
		$cache_key = $this->cache_key_settings;
		$settings = [ $this->settings_key_counters=>[] ];
		if (Cache::has($cache_key)) {
			$settings = Cache::get($cache_key);
		} else {
			$this->saveAll($settings);
		}

		return $settings;
	}

	public function getCounters()
	{
		$settings = $this->getAll();

		return $settings[$this->settings_key_counters];
	}


	/********
	 * SAVE *
	 ********/

	public function saveCounters($counters)
	{
		$this->save($this->settings_key_counters, $counters);
		Cache::forget($this->cache_key_counters);
	}

	private function save($key, $values)
	{
		$settings = $this->getAll();
		$settings[$key] = $values;

		$this->saveAll($settings);
	}

	private function saveAll($settings)
	{
		Cache::forever($this->cache_key_settings, $settings);
	}
}