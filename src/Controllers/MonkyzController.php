<?php

namespace Lab1353\Monkyz\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MonkyzController extends Controller
{
    public function __construct()
    {
    	$dir_monkyz_assets = str_replace(['http:','https:'], '', str_finish(url('/vendor/lab1353/monkyz/'), '/'));
    	view()->share('monkyz_assets', $dir_monkyz_assets);
    }
}
