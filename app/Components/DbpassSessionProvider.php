<?php

namespace App\Components;

use App\Components\DbpassSessionHandler;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Connection;
use Session;
use Config;

class DbpassSessionProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(Connection $connection)
    {
        Session::extend('dbpass', function($app) use ($connection) {
            $table   = Config::get('session.table');
            $minutes = Config::get('session.lifetime');
            return new DbpassSessionHandler($connection, $table, $minutes);
        });
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->session->extend('dbpass.database', function ($app) {
            $connectionName     = $this->app->config->get('session.connection');
            $databaseConnection = $app->app->db->connection($connectionName);

            $table = $databaseConnection->getTablePrefix() . $app['config']['session.table'];

            return new DbpassSessionHandler($databaseConnection, $table);
        });
    }
}