<?php

namespace Lab1353\Monkyz\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends MonkyzController
{

    public function __construct()
    {
    	$this->storeViewShare();
    }

    public function getIndex()
    {
    	return view('monkyz::dashboard.index');
    }
}
