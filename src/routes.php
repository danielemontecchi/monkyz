<?php
//dd(config('lab1353.monkyz.main'));

Route::group(['prefix' => config('lab1353.monkyz.main.prefix')], function () {
	Route::get('/', [ 'as'=>'monkyz.dashboard', 'uses'=>'Lab1353\Monkyz\Controllers\DashboardController@getIndex' ]);

	// dynamic
	Route::get('/{section}/list', [ 'as'=>'monkyz.dynamic.list', 'uses'=>'Lab1353\Monkyz\Controllers\DynamicController@getList' ]);
	Route::get('/{section}/add', [ 'as'=>'monkyz.dynamic.edit', 'uses'=>'Lab1353\Monkyz\Controllers\DynamicController@getAdd' ]);
	Route::get('/{section}/edit/{id}', [ 'as'=>'monkyz.dynamic.edit', 'uses'=>'Lab1353\Monkyz\Controllers\DynamicController@getEdit' ]);
});