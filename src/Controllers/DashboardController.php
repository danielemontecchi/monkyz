<?php

namespace Lab1353\Monkyz\Controllers;

use Cache;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Lab1353\Monkyz\Models\DynamicModel;

class DashboardController extends MonkyzController
{

    public function __construct()
    {
    	$this->init();
    }

    public function getIndex()
    {
        $cache_key = 'monkyz-counters';
    	$counters = [];

        if (Cache::has($cache_key)) {
            $counters = Cache::get($cache_key);
        } else {
        	$tables = $this->htables->getTables();
        	foreach ($tables as $table => $params) {
        		if ($params['visible']) {
        			$m = new DynamicModel($table);
        			$c = $m->count();

        			$counters[$table] = [
                        'count' => $c,
                        'icon'  => $params['icon'],
                    ];
        		}
        	}
            Cache::put($cache_key, $counters, (int)config('monkyz.cache_minutes', 60));
        }

    	return view('monkyz::dashboard.index')->with(compact('counters'));
    }
}
