<?php

namespace App\Components;

use Illuminate\Support\Facades\Auth;
// use App\Components\DbpassUserProvider;
// use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class DbpassServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Auth::provider('dbpass', function($app, array $config) {
            return new DbpassUserProvider($config['model']);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
