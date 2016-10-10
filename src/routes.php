<?php

Route::group(['prefix' => config('monkyz.prefix'), 'middleware'=>['web'] ], function () {
	// dashboard
	Route::get('/', [ 'as'=>'monkyz.dashboard', 'uses'=>'Lab1353\Monkyz\Controllers\DashboardController@getIndex' ]);

	// dynamic
	Route::get('/{section}/list', [ 'as'=>'monkyz.dynamic.list', 'uses'=>'Lab1353\Monkyz\Controllers\DynamicController@getList' ]);
	Route::get('/{section}/add', [ 'as'=>'monkyz.dynamic.add', 'uses'=>'Lab1353\Monkyz\Controllers\DynamicController@getEdit' ]);
	Route::get('/{section}/edit/{id}', [ 'as'=>'monkyz.dynamic.edit', 'uses'=>'Lab1353\Monkyz\Controllers\DynamicController@getEdit' ]);
	Route::post('/{section}/save', [ 'as'=>'monkyz.dynamic.save', 'uses'=>'Lab1353\Monkyz\Controllers\DynamicController@postSave' ]);
	Route::get('/{section}/delete/{id}', [ 'as'=>'monkyz.dynamic.delete', 'uses'=>'Lab1353\Monkyz\Controllers\DynamicController@getDelete' ]);

	// settings
	Route::get('/settings/dashboard', [ 'as'=>'monkyz.settings.dashboard', 'uses'=>'Lab1353\Monkyz\Controllers\SettingsController@getDashboard' ]);

	// users
	Route::get('/users/login', [ 'as'=>'monkyz.users.login', 'uses'=>'Lab1353\Monkyz\Controllers\UsersController@getLogin' ]);
	Route::post('/users/login', [ 'as'=>'monkyz.users.login', 'uses'=>'Lab1353\Monkyz\Controllers\UsersController@postLogin' ]);
	Route::get('/users/logout', [ 'as'=>'monkyz.users.logout', 'uses'=>'Lab1353\Monkyz\Controllers\UsersController@getLogout' ]);
});