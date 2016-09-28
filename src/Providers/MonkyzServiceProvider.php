<?php

namespace Lab1353\Monkyz\Providers;

use Illuminate\Support\ServiceProvider;

class MonkyzServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    	$path_pkg = str_finish(dirname(dirname(dirname(__FILE__))), '/');
    	$path_src = $path_pkg.'src/';

		// load views
        $this->loadViewsFrom($path_src.'Views', 'monkyz');
        // publish
		$this->publishes([
			$path_src.'Views' => resource_path('views/vendor/lab1353/monkyz'),
			$path_pkg.'config' => config_path('lab1353/monkyz'),
			$path_pkg.'assets' => public_path('vendor/lab1353/monkyz'),
		]);

        // package
        $this->app->make('Lab1353\Monkyz\Controllers\MonkyzController');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    	$path_pkg = str_finish(dirname(dirname(dirname(__FILE__))), '/');
    	$path_src = $path_pkg.'src/';

		// routes
        include $path_src.'routes.php';
        // config
        $this->mergeConfigFrom($path_pkg.'config/main.php', 'lab1353/monkyz/main');
    }
}
