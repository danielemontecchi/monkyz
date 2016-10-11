<?php

namespace Lab1353\Monkyz\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Lab1353\Monkyz\Helpers\TablesHelper as HTables;
use Lab1353\Monkyz\Helpers\UserHelper as HUser;
use Illuminate\Support\Facades\Route;

class MonkyzController extends Controller
{
	protected $htables;

	public function init()
	{
		if(!\DB::connection()->getDatabaseName())
		{
			abort(404, 'Database connection refused!');
		}
		$this->middleware('Lab1353\Monkyz\Middleware\ForceSchema');
		if (config('monkyz.use_auth')) $this->middleware('Lab1353\Monkyz\Middleware\AdminAccess')->except(['getLogin','postLogin']);
		$this->storeViewShare();
	}

    public function storeViewShare()
    {
    	// assets
    	$monkyz_assets = str_finish(asset('vendor/monkyz/'), '/');

    	// sections
    	$this->htables = new HTables();
		$tables = $this->htables->getTables();

		// route name
		$route_name = \Request::route()->getName();
		$route_name = str_replace('monkyz.', '', $route_name);
		$section_name = \Request::path();
		$section_name = str_replace(config('monkyz.prefix').'/', '', $section_name);
		while (strpos($section_name, '/')!==false) {
			$section_name = dirname($section_name);
		}
		$page_title = '<i class="fa fa-dashboard"></i>'.request()->server('HTTP_HOST');

		// user
		$user = [];
		if (Auth::check()) {
			$user = Auth::user()->toArray();
			if (empty($user['image'])) $user['image'] = HUser::gravatar($user['email'], 48);
		}

    	view()->share(compact('monkyz_assets', 'tables', 'section_name', 'route_name', 'page_title', 'user'));
    }
}
