<?php
/* FYI: This is registered via
    PageGuide/page-guide-admin/src/PageGuideAdminServiceProvider.php
    if ($this->app->runningInConsole()) {
            $this->commands([
                \TallAndSassy\PageGuideAdmin\Commands\TassyMenuCommands::class,
*/

namespace TallAndSassy\PageGuideAdmin\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;


class TassyMenuCommands extends Command
{

    protected $signature = 'tassy-page:add
     { --location=* : "(upper|lower)"  }
     { --suburl=* : "a relative url"  }
     { --label=* : "A quoted label for the menu item."  }';
    protected $description = 'Add an admin menu. usage: php artisan tassy-menu:add (upper|lower) --label="People Stuff"';

    // Future: Add --blade="" optino
    public function __construct()
    {
        parent::__construct();
    }



    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $replacementMap = [];

        // ReplaceableDomain
        $defaultJunk = 'E_' . uniqid();
        $ReplaceableDomain = $defaultJunk;
        $replacementMap['ReplaceableDomain'] = $ReplaceableDomain;




        // Gather all the data....
        $enumAdminMeFront = match (
        $this->choice('You want to add a page, great! Where will it live?', ['f' => 'front', 'a' => 'admin', 'm' => 'me'], 'a')
        ) {
            'f' => 'front',
            'a' => 'admin',
            'm' => 'me'
        };
        assert($enumAdminMeFront == 'admin', "Me and Front are not yet implemented. Try 'Admin'");
        $replacementMap['enumAdminMeFront'] = $enumAdminMeFront;

        // Sub Url
        $ReplaceableSubUrl = $this->ask('What is the relative path? Probably something like "/admin/help"', '/admin/' . $defaultJunk);//https://github.com/laracademy/interactive-make/blob/master/src/Commands/MakeCommand.php
        $replacementMap['ReplaceableSubUrl'] = $ReplaceableSubUrl;


        if ($enumAdminMeFront == 'admin') {
            $enumAccessScheme = match (
            $this->choice('How will this page be accessed?', ['m' => 'menu', 't' => 'tab', 'd' => 'direct link'], 'm')
            ) {
                'm' => 'menu',
                't' => 'tab',
                'd' => 'direct'
            };
            assert($enumAccessScheme == 'menu', "Not yet implemented, try 'menu'");
            $replacementMap['enumAccessScheme'] = $enumAccessScheme;

            if ($enumAccessScheme == 'tab') {
                assert(0, 'tbd');
            } elseif ($enumAccessScheme == 'direct') {
                assert(0, 'tbd');
            } elseif ($enumAccessScheme == 'menu') {
                $enumUpperLower = match (
                $this->choice('Where should this menu go? ', ['u' => 'Upper Menu', 'l' => 'Lower Menu'], 'u')
                ) {
                    'u' => 'upper',
                    'l' => 'lower',
                };
                // OUTPUT: $enumUpperLower
                $replacementMap['enumUpperLower'] = $enumUpperLower;

                // Label
                if (!$this->option('label')) {
                    $ReplaceableLabel = $this->ask('What is the menu text?', $defaultJunk);//https://github.com/laracademy/interactive-make/blob/master/src/Commands/MakeCommand.php
                } else {
                    $ReplaceableLabel = $this->option('label')[0];
                }
                // output: $ReplaceableLabel
                $replacementMap['ReplaceableLabel'] = $ReplaceableLabel;


            } else {
                assert(0, 'logic');
            }
        }

        $ReplaceableNamespace = 'App\Http\Controllers';
        $replacementMap['ReplaceableNamespace'] = $ReplaceableNamespace;

        $ReplaceableHtml = $this->ask("Give me starting html. Leave blank for lorem ipsem", "Fill with whatever you want. ($defaultJunk)");
        $replacementMap['ReplaceableHtml'] = $ReplaceableHtml;

        // Make the link show something useful
        $enumOutputScheme = $this->choice('How should the page be generated ', ['b' => 'Embedded Blade w/ controller', 'c' => 'straight html via controller'], 'c');//https://github.com/laracademy/interactive-make/blob/master/src/Commands/MakeCommand.php
        $replacementMap['enumOutputScheme'] = $enumOutputScheme;

        if ($enumOutputScheme == 'c') {
            // Controller
            $ReplaceableControllerName = $defaultJunk . 'Controller';
            $replacementMap['ReplaceableControllerName'] = $ReplaceableControllerName;

            $controller_StubSource_filepath = __DIR__ . '/../stubs/Controller.php.stub';
            $controller_Destination_filepath = base_path("app/Http/Controllers/$ReplaceableControllerName.php");
            static::LoadModifyPut($controller_StubSource_filepath, function (string $stub) use ($replacementMap) {
                return static::HydrateStub($stub, $replacementMap);
            }, $controller_Destination_filepath);


            // Route
            $web_admin_routes_filepath = base_path('routes/web-admin--routes.php');
            static::LoadBackupModifyUpdate($web_admin_routes_filepath, function (string $route_web) use ($replacementMap) {
                $route_SnippetSource_filepath_rel = __DIR__ . '/../stubs/route-web-admin-xxx.php.stub';
                $route_SnippetSource_filepath = $route_SnippetSource_filepath_rel;
                $routeSnippet_hydrated = static::HydrateStub( file_get_contents($route_SnippetSource_filepath), $replacementMap);
                return $route_web.$routeSnippet_hydrated;
            });

            // Put the view into place
            $blade_StubSource_filepath = __DIR__ . '/../stubs/page.blade.php.stub';
            $ReplaceableBladePath = 'views/admin/'.$ReplaceableDomain.'.blade.php';
            $blade_Destination_filepath_full = resource_path($ReplaceableBladePath);
            $replacementMap['ReplaceableBladePath'] = $ReplaceableBladePath;
            static::LoadModifyPut($blade_StubSource_filepath, function (string $stub) use ($replacementMap) {
                return static::HydrateStub($stub, $replacementMap);
            }, $blade_Destination_filepath_full);

            // Make the routes visible
            Artisan::call('optimize');

        } elseif ($enumOutputScheme == 'b') {
            assert(0, 'have not yet implemented blade mode');
        }

        // Menu Blade
        if ($enumAccessScheme == 'menu') {
            static::LoadBackupModifyUpdate(
                base_path(static::getMenuBladeFileName($enumUpperLower)),
                function ($existingMenuFile) use ($replacementMap) {
                    $menuSnippet_withEnclosedVars = file_get_contents(__DIR__ . '/../stubs/menu-side-treerootleaf.blade.php.stub');
                    $menuSnippet_hydrated = static::HydrateStub($menuSnippet_withEnclosedVars, $replacementMap);
                    $existingMenuFile .= $menuSnippet_hydrated;
                    return $existingMenuFile;
                }
            );
        }

    }

    private static function HydrateStub(string $stub, array $keysValuePairs): string
    {
        foreach ($keysValuePairs as $key => $value) {
            $stub = str_replace($key, $value, $stub);
        }
        return $stub;
    }

    private static function LoadBackupModifyUpdate(string $full_filepathWithContentWeWillPervert, \Closure $modifyingClosure_gettingContent): void
    {
        // make a backup of the file
        $filepathWithContentWeWillPervert = $full_filepathWithContentWeWillPervert;
        assert(file_exists($filepathWithContentWeWillPervert), $filepathWithContentWeWillPervert);
        $filenameTimestampStub = date('Y_d_m G:i:s');//.YYY_dd_mm HH:mm.php
        $virginalFileNameBackup = $filepathWithContentWeWillPervert . " origAsOf $filenameTimestampStub";
        assert(! file_exists($virginalFileNameBackup));

        $ret = copy($filepathWithContentWeWillPervert, $virginalFileNameBackup);
        assert($ret);

        // Load the File
        assert(file_exists($filepathWithContentWeWillPervert));
        $stub_withEnclosedVars = file_get_contents($filepathWithContentWeWillPervert);

        // Pervert the file
        $hydrated_content = $modifyingClosure_gettingContent($stub_withEnclosedVars);//static::HydrateStub($stub_withEnclosedVars, $replacementMap);

        // Update the file
        $ret = file_put_contents($filepathWithContentWeWillPervert, $hydrated_content);
        assert($ret);
        unset($stub_withEnclosedVars);

        #$this->info("Made backup of '$web_admin_routes_filepath' and wrote to '$virginalFileNameBackup'");
    }

    private static function LoadModifyBackupPut(string $filepathWithContentWeWillPervert_offOfRoot, \Closure $modifyingClosure_gettingContent): void
    {

    }

    private static function LoadModifyPut(string $full_filepathOfStub, \Closure $modifyingClosure_gettingContent, string $full_filepath_newFile_forHydratedStub): void
    {
        // make a backup of the file
        $filepathWithContentWeWillPervert =$full_filepathOfStub;

        // Load the File
        assert(file_exists($filepathWithContentWeWillPervert), $filepathWithContentWeWillPervert);
        $stub_withEnclosedVars = file_get_contents($filepathWithContentWeWillPervert);

        // Pervert the file
        $hydrated_content = $modifyingClosure_gettingContent($stub_withEnclosedVars);//static::HydrateStub($stub_withEnclosedVars, $replacementMap);

        // write the file to new location
        $filepathWithContent_mustNotExist = $full_filepath_newFile_forHydratedStub;
        assert(! file_exists($filepathWithContent_mustNotExist));
        $ret = file_put_contents($filepathWithContent_mustNotExist, $hydrated_content);
        assert($ret);
        unset($stub_withEnclosedVars);
    }

    private static function getMenuBladeFileName(string $enumUpperLower): string
    {
        if ($enumUpperLower == 'upper') {
            $filename = 'resources/views/vendor/tassy/admin/menu-side-upper-above.blade.php';
        } elseif ($enumUpperLower == 'lower') {
            $filename = 'resources/views/vendor/tassy/admin/menu-side-lower-above.blade.php';
        } else {
            assert(0);
        }
        return $filename;
    }
}
