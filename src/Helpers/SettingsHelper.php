<?php
namespace Lab1353\Monkyz\Helpers;

use Illuminate\Support\Facades\Cache;
use Lab1353\Monkyz\Helpers\TablesHelper as HTables;

class SettingsHelper
{
	protected $cache_key_settings = 'monkyz-settings';
	public $cache_key_counters = 'monkyz-widgets-counters';
	protected $settings_key_counters = 'counters';
	protected $settings_key_dashboard = 'dashboard';

	public function resetDefault()
	{
		$settings = $this->getDefault();
		$this->saveAll($settings);
	}

	/*******
	 * GET *
	 *******/

	public function getDefault()
	{
		return [
			$this->settings_key_dashboard=>[
				'screenshot'	=> true,
				'serverinfo'	=> true,
				'counters'	=> true,
			],
			$this->settings_key_counters=>[],
		];
	}

	public function getAll()
	{
		$cache_key = $this->cache_key_settings;
		
		if (!Cache::has($cache_key)) {
			$this->resetDefault();
		}

		return Cache::get($cache_key);
	}

	public function getCounters()
	{
		$settings = $this->getAll();

		return $settings[$this->settings_key_counters];
	}

	public function getDashboard()
	{
		$settings = $this->getAll();

		return $settings[$this->settings_key_dashboard];
	}


	/********
	 * SAVE *
	 ********/

	public function saveAll($settings)
	{
		Cache::forever($this->cache_key_settings, $settings);

		Cache::forget($this->cache_key_counters);
	}
}