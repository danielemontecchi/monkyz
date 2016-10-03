<?php

Route::group(['prefix' => config('monkyz.prefix')], function () {
	Route::get('/', [ 'as'=>'monkyz.dashboard', 'uses'=>'Lab1353\Monkyz\Controllers\DashboardController@getIndex' ]);

	// dynamic
	Route::get('/{section}/list', [ 'as'=>'monkyz.dynamic.list', 'uses'=>'Lab1353\Monkyz\Controllers\DynamicController@getList' ]);
	Route::get('/{section}/add', [ 'as'=>'monkyz.dynamic.add', 'uses'=>'Lab1353\Monkyz\Controllers\DynamicController@getEdit' ]);
	Route::get('/{section}/edit/{id}', [ 'as'=>'monkyz.dynamic.edit', 'uses'=>'Lab1353\Monkyz\Controllers\DynamicController@getEdit' ]);
	Route::post('/{section}/save', [ 'as'=>'monkyz.dynamic.save', 'uses'=>'Lab1353\Monkyz\Controllers\DynamicController@postSave' ]);
});