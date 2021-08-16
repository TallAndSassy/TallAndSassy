<?php

namespace TallAndSassy\Tenancy;
use Illuminate\Support\ServiceProvider;

class TenancyServiceProvider extends ServiceProvider
{

    public function boot()
    {

        $d = __DIR__ . '/../resources/views';
        $this->loadViewsFrom($d, 'tassy');
    }

    public function register()
    {

    }

}
