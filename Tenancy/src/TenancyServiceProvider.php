<?php

namespace TallAndSassy\Tenancy;
use Illuminate\Support\ServiceProvider;

class TenancyServiceProvider extends ServiceProvider
{

    public function boot()
    {

        $d = __DIR__ . '/../resources/views';
        $this->loadViewsFrom($d, 'tassy');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations'); //https://laravelpackage.com/08-models-and-migrations.html#migrations
        $this->publishResources();
    }

    public function register()
    {

    }

    protected function publishResources()
    {
//        $this->publishes([
//            __DIR__ . '/../config/randomable.php' => config_path('randomable.php'),
//        ], 'randomable-config');

//        $this->publishes([
//            __DIR__ . '/../database/migrations/create_randomables_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_randomables_table.php'),
//        ], 'randomable-migrations');

        $this->publishes([
            __DIR__ . '/database/seeders/Stubs/TassyTenantSeeder.php' => database_path('seeders/TassyTenantSeeder.php'),
        ], ['tassy', 'tassy-tenancy', 'tassy-seeders']);
    }

}
