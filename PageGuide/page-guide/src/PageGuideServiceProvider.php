<?php

namespace TallAndSassy\PageGuide;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use TallAndSassy\PageGuide\Commands\PageGuideCommand;
#use TallAndSassy\PageGuide\Components\Bobby;
use TallAndSassy\PageGuide\Components\Lowernav;
use TallAndSassy\PageGuide\Components\Sidenav;
use TallAndSassy\PageGuide\Http\Controllers\PageGuideController;
use TallAndSassy\PageGuide\Components\Lepage;
use TallAndSassy\PageGuide\Components\LeSwappableChunk;
use TallAndSassy\PageGuide\Http\Livewire\DoModal;
use TallAndSassy\PageGuide\Http\Livewire\TheModalBox;

class PageGuideServiceProvider extends ServiceProvider
{
    public static string $blade_prefix = "tassy"; #tassy is a template term

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [   // todo: add the stub
                    __DIR__ . '/../config/tassy/app-branding.stub.php' => config_path('/tassy/app-branding.php'),
                ],
                'config'
            );

            $this->publishes(
                [ // todo: make friendlier?
                    __DIR__ . '/../resources/views' => base_path('resources/views/vendor/page-guide'),
                ],
                'views'
            );

            $migrationFileName = 'create_page_guide_table.php';
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

            $this->publishes([
                 __DIR__ . '/../resources/public' => public_path('tallandsassy'),
                ], ['public']);



            // Publishing resources.
            /*$this->publishes([
                __DIR__.'/../resources/resources' => public_path('tallandsassy/page-guide'),
            ], 'grok.views');*/

            // Publishing the translation files.
            $this->publishes([
                __DIR__ . '/../resources/lang' => resource_path('lang/tassy/page-guide'),
            ], 'grok.views');



            // Registering package commands.
            $this->commands(
                [
                    PageGuideCommand::class,
                ]
            );
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'tassy');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'tassy');



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
                                '/TallAndSassy/PageGuide/sample_string', // you will absolutely need a prefix in your url
                                function () {
                                    return "Hello PageGuide string via blade prefix";
                                }
                            );

                            // prefixed url to blade view
                            Route::get(
                                '/TallAndSassy/PageGuide/sample_blade',
                                function () {
                                    return view('tassy::sample_blade');
                                }
                            );

                            // prefixed url to controller
                            Route::get(
                                '/TallAndSassy/PageGuide/controller',
                                [PageGuideController::class, 'sample']
                            );
                        }
                        // Prefix Route Samples -END-

                        // TODO: Add your own prefixed routes here...
                    }
                );
            }
        );
        Route::tassy('tassy'); // This works. http://test-jet.test/tassy/TallAndSassy/PageGuide/string
        // They are addatiive, so in your own routes/web.php file, do Route::tassy('staff'); to
        // make http://test-jet.test/staff/TallAndSassy/PageGuide/string work


        // global url samples -BEGIN-
        if (App::environment(['local', 'testing'])) {
            // global url to string
            Route::get(
                '/grok/TallAndSassy/PageGuide/sample_string',
                function () {
                    return "Hello PageGuide string via global url.";
                }
            );

            // global url to blade view
            Route::get(
                '/grok/TallAndSassy/PageGuide/sample_blade',
                function () {
                    return view('tassy::sample_blade');
                }
            );

            // global url to controller
            Route::get('/grok/TallAndSassy/PageGuide/controller', [PageGuideController::class, 'sample']);
        }
        // global url samples -END-

        // TODO: Add your own global routes here...

        // GROK
        if (App::environment(['local', 'testing'])) {
            #\ElegantTechnologies\Grok\GrokWrangler::grokMe(static::class, 'TallAndSassy', 'page-guide', 'resources/views/grok', 'tassy');//tassy gets macro'd out
            Route::get('/grok/TallAndSassy/PageGuide', fn () => view('tassy::grok/index'));
        }

        // TODO: Register your livewire components that live in this package here:
        # \Livewire\Livewire::component('tassygroklivewirejet::a-a-nothing',  \TallAndSassy\GrokLivewireJet\Components\DemoUiChunks\AANothing::class);
        // TODO: Add your own other boot related stuff here...
        \Livewire\Livewire::component('tassy::livewire.sidenav',  Sidenav::class);

        \Livewire\Livewire::component('tassy::livewire.lowernav', Lowernav::class);

        \Livewire\Livewire::component('tassy::livewire.lepage',   Lepage::class);
        \Livewire\Livewire::component('tassy::livewire.le-swappable-chunk', LeSwappableChunk::class);
        \Livewire\Livewire::component('tassy::livewire.bobby',  Bobby::class);

        \Livewire\Livewire::component('tassy::livewire.do-modal',  DoModal::class);
        \Livewire\Livewire::component('tassy::livewire.the-modal-box',  TheModalBox::class);
//        \TallAndSassy\PageGuide\MenuTree::singleton('upper')->pushTop(
//            'admin.bob',
//            'Bob',
//            null,
//            'heroicon-o-question-mark-circle',
//            '/admin/bob'
//        );
//        \TallAndSassy\PageGuide\MenuTree::singleton('upper')->pushTop(
//            'admin.bobby',
//            'Bobby',
//            null,
//            'heroicon-o-question-mark-circle',
//            '/admin/bobby'
//        );
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/tassy/app-versioning.php', 'tassy.app-versioning');
        $this->mergeConfigFrom(__DIR__ . '/../config/tassy/page-guide.php', 'tassy.page-guide');
        $this->mergeConfigFrom(__DIR__ . '/../config/tassy/app-branding.php', 'tassy.app-branding');
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
