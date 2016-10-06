<?php

namespace Lab1353\Monkyz\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SettingsController extends MonkyzController
{

    public function __construct()
    {
    	$this->init();
    }

    public function getDashboard()
    {
        $tables = $this->htables->getTables();
    	
        return view('monkyz::settings.dashboard')->with(compact('tables'));
    }
}
