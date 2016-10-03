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
    	$path_src = str_finish(dirname(__DIR__), '/');
    	$path_pkg = str_replace('src/', '', $path_src);

		// load views
        $this->loadViewsFrom($path_src.'Views', 'monkyz');
        // publish
		$this->publishes([
			$path_src.'Views' => resource_path('views/vendor/monkyz'),
			$path_pkg.'config' => config_path(),
			$path_pkg.'assets' => public_path('vendor/monkyz'),
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
    	$path_src = str_finish(dirname(__DIR__), '/');
    	$path_pkg = str_replace('src/', '', $path_src);

		// routes
        include $path_src.'routes.php';

        // config
        $this->mergeConfigFrom($path_pkg.'config/monkyz.php', 'monkyz');

        // commands
        $this->commands([
			\Lab1353\Monkyz\Commands\MonkyzGenerateDb::class
		]);
    }
}
