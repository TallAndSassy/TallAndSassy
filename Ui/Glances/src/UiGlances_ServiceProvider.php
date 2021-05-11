<?php

namespace TallAndSassy\Ui\Glances;

use App\Http\Livewire\RemergeTab_ComponentBase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideAdminController_Base;
use TallAndSassy\PageGuideAdmin\Http\Controllers\Bob_outputByBlade_Controller;
use TallAndSassy\Ui\Glances\Samples\Admin_Init;
use TallAndSassy\Ui\Glances\Samples\TabSample1__Page;
use TallAndSassy\Ui\Glances\Samples\TabSamples;

#use TallAndSassy\PageGuideAdm
class UiGlances_ServiceProvider extends ServiceProvider
{
    public static string $blade_prefix = "tassy"; #tassy is a template term

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            // TODO-Before 1.0: publish give useful config stubs
            // TODO-Before 1.0: publish give useful migrations stuff
            // TODO-Before 1.0: publish resources and resources
            // TODO-Before 1.0: publish translation files
            // TODO-Before 1.0: show available commands, if any
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'tassy-ui');

        Route::macro(
            'tassy-ui',
            function (string $prefix) {
                Route::prefix($prefix)->group(
                    function () {
                        // Prefix Route Samples -BEGIN- // Sample routes that only show while developing...
                        if (App::environment(['local', 'testing'])) {
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
        Route::tassy('tassy-ui'); // This works. http://test-jet.test/tassy/TallAndSassy/PageGuideAdmin/string
        // They are addatiive, so in your own routes/web.php file, do Route::tassy('staff'); to
        // make http://test-jet.test/staff/TallAndSassy/PageGuideAdmin/string work

        // TODO: Register your livewire components that live in this package here:
        #\Livewire\Livewire::component('tassy-ui::livewire.tab',  RemergeTab_ComponentBase::;
        #\Livewire\Livewire::component('tassy-ui::tab',  \TallAndSassy\GrokLivewireJet\Components\DemoUiChunks\AANothing::class);


        // Samples
        Admin_Init::Init();


    }

    public function register()
    {
        // Configs
        $this->mergeConfigFrom(__DIR__ . '/../config/tassy/ui-glances.php', 'tassy.ui-glances');
        #$this->mergeConfigFrom(__DIR__ . '/../config/tassy/app-versioning.php', 'tassy.app-versioning');
    }

}
