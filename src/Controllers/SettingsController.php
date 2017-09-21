<?php

namespace Lab1353\Monkyz\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Lab1353\Monkyz\Helpers\SettingsHelper as HSettings;

class SettingsController extends MonkyzController
{
	protected $hsettings;

	public function __construct()
	{
		$this->init();
		$this->hsettings = new HSettings();
	}

	public function getIndex()
	{
		$page_title = '<i class="fa fa-cog"></i>Settings';

		$tables = $this->htables->getTables();

		$settings = $this->hsettings->getAll();

		return view('monkyz::settings.index')->with(compact('tables', 'page_title', 'settings'));
	}

	public function postSave(Request $request)
	{
		$inputs = $request->all();
		unset($inputs['_token']);

		$settings = $this->hsettings->getDefault();
		foreach ($inputs as $input => $value) {
			$value = ($value=='1' || $value=='0') ? (bool)$value : (string)$value;
			$settings[$input] = $value;
		}
		$this->hsettings->saveAll($settings);
		Cache::forget('monkyz-widgets-counters');

        return back()->with('success', 'Settings saved!');
	}

	public function getDefault()
	{
		$this->hsettings->resetDefault();
		Cache::forget('monkyz-widgets-counters');
		
        return back()->with('success', 'Default settings reset!');
	}
}
