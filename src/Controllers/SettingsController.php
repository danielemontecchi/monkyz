<?php

namespace Lab1353\Monkyz\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
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
		$page_title = '<i class="fa fa-tachometer"></i>Settings <small>dashboard</small>';

		$tables = $this->htables->getTables();

		$settings = $this->hsettings->getAll();

		return view('monkyz::settings.dashboard')->with(compact('tables', 'page_title', 'settings'));
	}

	public function postCounters(Request $request)
	{
		$counters = $request->all();
		unset($counters['_token']);
		$counters = array_keys($counters);
		$this->hsettings->saveCounters($counters);

        return back()->with('success', 'Counters saved!');
	}
}
