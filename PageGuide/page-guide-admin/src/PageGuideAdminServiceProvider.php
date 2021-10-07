<?php

namespace TallAndSassy\PageGuideAdmin;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
#use LaravelFrontendPresets\Tall\TassyCommand;
//use LaravelFrontendPresets\Tall\TassyMenuCommands;

use TallAndSassy\PageGuideAdmin\Commands\TassyDomainCommands;
use TallAndSassy\PageGuideAdmin\Components\SuperAdmin\SuperAdminTenantDirectory;
use TallAndSassy\PageGuideAdmin\Components\SuperAdmin\TenantCount;
#use TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideAdminController_Base;
use TallAndSassy\PageGuideAdmin\Http\Controllers\Bob_outputByBlade_Controller;

#use TallAndSassy\PageGuideAdmin\Commands\PageGuideAdminCommand;
#use TallAndSassy\PageGuideAdmin\Http\Controllers\PageGuideAdminController;

class PageGuideAdminServiceProvider extends ServiceProvider
{
    public static string $blade_prefix = "tassy"; #tassy is a template term

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \TallAndSassy\PageGuideAdmin\Commands\TassyMenuCommands::class,
                TassyDomainCommands::class
            ]);
            $this->publishes(
                [
                    __DIR__ . '/../config/page-guide-admin.php' => config_path('page-guide-admin.php'),
                ],
                ['config','tassy-config','tassy']
            );

            $this->publishes(
                [
                    __DIR__ . '/../resources/views' => base_path('resources/views/vendor/page-guide-admin'),
                ],
                'views'
            );

            $migrationFileName = 'create_app_theme_base_admin_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes(
                    [
                        __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path(
                            'migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName
                        ),
                    ],
                    'migrations'
                );
            }


            $this->publishes(
                [
                    __DIR__ . '/../resources/public' => public_path('tallandsassy/page-guide-admin'),
                ],
                ['public']
            );

            // Publishing resources.
            /*$this->publishes([
                __DIR__.'/../resources/resources' => public_path('tallandsassy/page-guide-admin'),
            ], 'grok.views');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/tallandsassy/page-guide-admin'),
            ], 'tallandsassy.page-guide-admin');*/


            //            // Registering package commands.
            //            $this->commands(
            //                [
            //                    PageGuideAdminCommand::class,
            //                ]
            //            );
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'tassy');


        Route::macro(
            'tassy',
            function (string $prefix) {
                Route::prefix($prefix)->group(


                    function () {
                        // Prefix Route Samples -BEGIN-
                        // Sample routes that only show while developing...


                        if (App::environment(['local', 'testing'])) {
                            // prefixed url to string
                            Route::get(
                                '/TallAndSassy/PageGuideAdmin/sample_string',
                                // you will absolutely need a prefix in your url
                                function () {
                                    return "Hello PageGuideAdmin string via blade prefix";
                                }
                            );

                            // prefixed path to blade view
                            Route::get(
                                '/TallAndSassy/PageGuideAdmin/sample_blade',
                                function () {
                                    return view('tassy::sample_blade');
                                }
                            );

                            // prefixed url to controller
                            Route::get(
                                '/TallAndSassy/PageGuideAdmin/controller',
                                [Bob_outputByBlade_Controller::class, 'sample']
                            );
                        }
                        // Prefix Route Samples -END-

                        // TODO: Add your own prefixed routes here...
                    }
                );
            }
        );
        Route::tassy('tassy'); // This works. http://test-jet.test/tassy/TallAndSassy/PageGuideAdmin/string
        // They are addatiive, so in your own routes/web.php file, do Route::tassy('staff'); to
        // make http://test-jet.test/staff/TallAndSassy/PageGuideAdmin/string work


        //        // global url samples -BEGIN-
        //        if (App::environment(['local', 'testing'])) {
        //            // global url to string
        //            Route::get(
        //                '/grok/TallAndSassy/PageGuideAdmin/sample_string',
        //                function () {
        //                    return "Hello PageGuideAdmin string via global url.";
        //                }
        //            );
        //
        //            // global url to blade view
        //            Route::get(
        //                '/grok/TallAndSassy/PageGuideAdmin/sample_blade',
        //                function () {
        //                    return view('tassy::sample_blade');
        //                }
        //            );
        //
        //            // global url to controller
        //            Route::get(
        //                '/grok/TallAndSassy/PageGuideAdmin/controller',
        //                [PageGuideAdminController::class, 'sample']
        //            );
        //        }
        // global url samples -END-

        // TODO: Add your own global routes here...

//        // GROK
//        if (App::environment(['local', 'testing'])) {
//            \ElegantTechnologies\Grok\GrokWrangler::grokMe(
//                static::class,
//                'TallAndSassy',
//                'page-guide-admin',
//                'resources/views/grok',
//                'tassy'
//            );//tassy gets macro'd out
//            Route::get('/grok/TallAndSassy/PageGuideAdmin', fn () => view('tassy::grok/index'));
//        }

        // TODO: Register your livewire components that live in this package here:
        # \Livewire\Livewire::component('tassygroklivewirejet::a-a-nothing',  \TallAndSassy\GrokLivewireJet\Components\DemoUiChunks\AANothing::class);
        \Livewire\Livewire::component('tassy:super-admin.tenant-directory',  SuperAdminTenantDirectory::class); // usage: <livewire:tassy:super-admin.tenant-directory :tabName="'SuperAdminTenantDirectory'"/>
        \Livewire\Livewire::component('tassy:super-admin.tenant-count',  TenantCount::class);
        // TODO: Add your own other boot related stuff here...

        // Add Top Admin Menus
        PageGuide_AdminMenuPrep::RegisterAdminMenus();

          }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/tassy/admin.php', 'tassy.admin');
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }
}
