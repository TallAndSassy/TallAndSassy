<?php

namespace TallAndSassy\Cms;
use Illuminate\Support\ServiceProvider;
use TallAndSassy\PageGuideAdmin\Commands\TassyDomainListCommand;

class CmsServiceProvider extends ServiceProvider
{

    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->commands([
                \TallAndSassy\Cms\Commands\TassyCmsCommands::class
            ]);
            // Publish assets
            $this->publishes([
                __DIR__.'/../resources/js' => resource_path('js'),
            ], 'assets');

        }



        #$d = __DIR__ . '/../resources/views';
        #$this->loadViewsFrom($d, 'tassy');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations'); //https://laravelpackage.com/08-models-and-migrations.html#migrations
    }




    public function register()
    {

    }

}
