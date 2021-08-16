<?php

namespace TallAndSassy\Tenancy;
use Illuminate\Support\ServiceProvider;

class TenancyServiceProvider extends ServiceProvider
{

    public function boot()
    {
        //        if ($this->app->runningInConsole()) {
        //
        //            // Config
        //            $this->publishes(
        //                [
        //                    __DIR__ . '/../config/tassy/tenancy.php' => config_path('tassy/tenancy.php'),
        //                ],
        //                'config'
        //            );
        //        }
        $d = __DIR__ . '/../resources/views';
        $this->loadViewsFrom($d, 'tassy');
    }

    public function register()
    {
        //$this->mergeConfigFrom(__DIR__ . '/../config/tassy/tenancy.php', 'tassy.tenancy');
    }

}
