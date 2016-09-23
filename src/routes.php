<?php
//dd(config('lab1353.monkyz.main'));

Route::group(['prefix' => config('lab1353.monkyz.main.prefix')], function () {
	Route::get('/', [ 'as'=>'monkyz.dashboard', 'uses'=>'Lab1353\Monkyz\Controllers\DashboardController@getIndex' ]);
});