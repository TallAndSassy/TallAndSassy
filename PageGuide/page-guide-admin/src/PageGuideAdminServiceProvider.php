<?php

namespace TallAndSassy\PageGuideAdmin;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
#use TallAndSassy\PageGuideAdmin\Commands\PageGuideAdminCommand;
use TallAndSassy\PageGuideAdmin\Http\Controllers\PageGuideAdminController;

class PageGuideAdminServiceProvider extends ServiceProvider
{
    public static string $blade_prefix = "tassy"; #tassy is a template term

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    __DIR__ . '/../config/page-guide-admin.php' => config_path('page-guide-admin.php'),
                ],
                'config'
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

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('tallandsassy/page-guide-admin'),
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

                            // prefixed url to blade view
                            Route::get(
                                '/TallAndSassy/PageGuideAdmin/sample_blade',
                                function () {
                                    return view('tassy::sample_blade');
                                }
                            );

                            // prefixed url to controller
                            Route::get(
                                '/TallAndSassy/PageGuideAdmin/controller',
                                [PageGuideAdminController::class, 'sample']
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
        // TODO: Add your own other boot related stuff here...

        // Add Top Admin Menus


        if (config('tassy.admin.DoDashboard')) {
            \TallAndSassy\PageGuide\MenuTree::singleton('upper')->pushTop(
                'admin.dashboard',
                'Dashboard',
                null,
                'heroicon-o-home',
                '/admin/dashboard'
            );
        }

        if (config('tassy.admin.DoLibrary')) {
            \TallAndSassy\PageGuide\MenuTree::singleton('upper')->pushTop(
                'admin.libary',
                'Library',
                null,
                'heroicon-o-pencil',
                null
            )
                ->pushLink('admin.media', 'Media', '/admin/media');
        }

        if (config('tassy.admin.DoSamples')) {
            \TallAndSassy\PageGuide\MenuTree::singleton('upper')->pushTop(
                'admin.Cafe',
                'Cafe',
                null,
                'heroicon-o-question-mark-circle',
                null
            )
                ->pushLink('admin.salad.fruit' . uniqid(), 'Fruit Salad', '/admin/fruit')
                ->pushLink('admin.salad.leaf' . uniqid(), 'Lettuce Salad', '/admin/leaf')
                ->pushLink('admin.salad.potato' . uniqid(), 'Yucky Salad', '/admin/potato')
                ->pushGroup('condiments' . uniqid(), 'Condiments')
                ->pushLink(
                    'admin.condiments.mustard' . uniqid(),
                    'Hymans Brand Mustard',
                    '/admin/condiment/mustard'
                )
                ->pushLink('admin.condiments.catsup' . uniqid(), 'Ketchup', '/admin/condiment/catsup')
                ->pushGroup('condiments2' . uniqid(), 'Condiments2')
                ->pushLink(
                    'admin.condiments.mustard2' . uniqid(),
                    'Hymans Brand Mustar2d',
                    '/admin/condiment/mustard'
                )
                ->pushLink('admin.condiments.catsup2' . uniqid(), 'Ketchup2', '/admin/condiment/catsup')
                ->pushTop(
                    'admin.postsalaasdf' . uniqid(),
                    'Cafeteria',
                    null,
                    'zondicon-location-food',
                    '/admin/cafeteria'
                )
                ->pushTop('admin.postsala2dfgd' . uniqid(), 'Justice', null, 'heroicon-o-scale', null)
                ->pushLink('admin.condiments.catsup442' . uniqid(), 'Ketchup2', '/admin/condiment/catsup2')
                ->pushLink('admin.condiments.catsup443' . uniqid(), 'Ketchup3', '/admin/condiment/catsup3')
                ->pushLink('admin.condiments.catsup444' . uniqid(), 'Ketchup4', '/admin/condiment/catsup4')
                ->pushTop('admin.postsala444' . uniqid(), 'Trials', null, 'heroicon-o-scale', null)
                ->pushTop(
                    'admin.postsala444' . uniqid(),
                    'Liberty',
                    null,
                    'heroicon-o-scale',
                    '/admin/condiment/postsala444'
                );

            \TallAndSassy\PageGuide\MenuTree::singleton('upper')->pushTop(
                'admin.bob',
                'Bob',
                null,
                'heroicon-o-question-mark-circle',
                '/admin/bob'
            );
            \TallAndSassy\PageGuide\MenuTree::singleton('upper')->pushTop(
                'admin.bobby',
                'Bobby',
                null,
                'heroicon-o-question-mark-circle',
                '/admin/bobby'
            );
        }
        if (config('tassy.admin.DoHelp')) {
            \TallAndSassy\PageGuide\MenuTree::singleton('upper')->pushTop(
                'admin.help',
                'Help',
                null,
                'heroicon-o-question-mark-circle',
                '/admin/help'
            );
        }

        // ------- Default lower menus items
        if (config('tassy.admin.DoConfig')) {
            \TallAndSassy\PageGuide\MenuTree::singleton('lower')->pushTop(
                'admin.config',
                'Config',
                null,
                'heroicon-o-cog',
                '/admin/config'
            );
        }
        if (config('tassy.admin.DoAbout')) {
            \TallAndSassy\PageGuide\MenuTree::singleton('lower')->pushTop(
                'admin.about',
                'About',
                null,
                'fas-info',
                '/admin/about',
                'w-4 h-5 mx-auto'
            );
        }

        // Temp
        \Livewire\Livewire::component('tassy::livewire.polling-card',  \TallAndSassy\PageGuideAdmin\Components\PollingCard::class);

        // Dashboard
        \Livewire\Livewire::component('tassy::cards.simple-stat',  \TallAndSassy\PageGuideAdmin\Http\Livewire\Cards\SimpleStat::class);
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
