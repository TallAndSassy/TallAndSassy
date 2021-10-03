<?php

namespace TallAndSassy\Tenancy;
use Illuminate\Support\ServiceProvider;

class TenancyServiceProvider extends ServiceProvider
{

    public function boot()
    {

//        $d = __DIR__ . '/../resources/views';
//        $this->loadViewsFrom($d, 'tassy');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations'); //https://laravelpackage.com/08-models-and-migrations.html#migrations
    }

    public function register()
    {

    }

}
