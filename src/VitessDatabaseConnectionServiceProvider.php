<?php

namespace Tjcelaya\Laravel5\Vitess;

use Illuminate\Database\DatabaseManager;
use Illuminate\Support\ServiceProvider;

class VitessDatabaseConnectionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->resolving('db', function (DatabaseManager $db) {
            $db->extend('vitess', function ($config) {

               return new Connection($config);
            });
        });
    }
}
