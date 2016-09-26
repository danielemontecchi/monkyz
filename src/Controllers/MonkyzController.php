<?php

namespace Lab1353\Monkyz\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Lab1353\Monkyz\Helpers\TablesHelper as HTables;

class MonkyzController extends Controller
{
	protected $htables;

    public function __construct()
    {
    	// assets
    	$monkyz_assets = str_replace(['http:','https:'], '', str_finish(url('/vendor/lab1353/monkyz/'), '/'));

    	// sections
    	$this->htables = new HTables();
		$tables = $this->htables->getTables();

    	view()->share(compact('monkyz_assets', 'tables'));
    }
}
