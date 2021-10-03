<?php

namespace TallAndSassy\RolesAndPermissions;
use Illuminate\Support\ServiceProvider;

class RolesServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../RolesAndPermissions/src/database/migrations'); //https://laravelpackage.com/08-models-and-migrations.html#migrations
    }

    public function register()
    {

    }

}
