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
use Illuminate\Support\Str;
use TallAndSassy\Strings\TsStringConvert;


class TassyPageAddCommand extends Command
{

    protected $signature = 'tassy-page:add';
    //     { --location=* : "(upper|lower)"  }
    //     { --suburl=* : "a relative url"  }
    //     { --label=* : "A quoted label for the menu item."  }';
    protected $description = 'Interactively Add an admin menu with a corresponding page. usage: php artisan tassy-menu:add (upper|lower) --label="People Stuff"';

    
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Group = AKA Domains
     * Key = Our current focus.
     * Admin/Planning = Domain
     * HomePage = Key
     * enumHoming_ControllersLivewire
     *
     * @return int
     */
    public function handle()
    {
        $replacementMap = [];

        // ReplaceableDomain
        $defaultJunk = 'Experiment' . time();
        #$ReplaceableDomain = $defaultJunk;
        # $replacementMap['ReplaceableDomain'] = $ReplaceableDomain;


        // Gather all the data....
        $shortNodeName_input = $this->ask("Give a camel cased name for what you are make, like 'Page', or 'Home', 'or 'EnrichmentCalendar'.", $defaultJunk);
        // Let's ensure it if very legal
        $shortNodeName = Str::ucfirst( Str::camel($shortNodeName_input));
        if (! preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/',$shortNodeName)) {
            assert(0, "Please make it a php compatible variable name.");
        }
        if ($shortNodeName != $shortNodeName_input) {
            $this->info("FYI: We munged your input from '$shortNodeName_input' to '$shortNodeName'");
        }
        $replacementMap['ReplaceableString_shortNodeName'] =$shortNodeName;
        $this->info('Note: Storing in Livewire doesnt make your admin page a livewire component, cuz it still needs the basic page swap functionality. But it can be useful to store everything either in Livewire, or in Controllers');
        $enumHoming_ControllersLivewire = match (
        $this->choice('How do you want to store the page info',['c' => 'app/Http/Controllers', 'l' => 'app/Http/Livewire'], 'l')
        ) {
            'c' => 'Controllers',
            'l' => 'Livewire',
        };


        $enumAdminMeFront = match (
        $this->choice('You want to add a page, great! Where will it live?', ['f' => '/ (user facing)', 'a' => '/admin', 'm' => '/me'], 'a')
        ) {
            'f' => 'front',
            'a' => 'admin',
            'm' => 'me'
        };
        //assert($enumAdminMeFront == 'admin', "Me and Front are not yet implemented. Try 'admin'");
        $replacementMap['enumAdminMeFront'] = $enumAdminMeFront;



        // Grouping?
        $enumGroupScheme  = match (
        $this->choice('You can group this into a logical directory, keeping the files geographically close to each other. Or, you can keep everything global, like default laravel. Grouping is like a lightweight package', ['g' => 'Group it', 'd' => 'Default Global behavior'], 'g')
        ) {
            'g' => 'group',
            'd' => 'global',

        };
        $boolShopLocal = false;
        $replacementMap['ReplaceableString_enumGroupScheme'] = $enumGroupScheme;
        if ($enumGroupScheme == 'global') {
            $groupName = '';
        } else {
            $existingGroups_plusNew = ['n'=>'New Group (Chose this to create a new grouping)', ...TassyDomainListCommand::GetDomainNames($enumHoming_ControllersLivewire)];
            $defaultToLastTouchedDomain = (count($existingGroups_plusNew) == 1 ? array_key_last($existingGroups_plusNew) : array_key_first(TassyDomainListCommand::GetDomainNames($enumHoming_ControllersLivewire, enumSort_alpha_age: 'age')));
            $groupName_c = $this->choice('These are the existing groups', $existingGroups_plusNew, $defaultToLastTouchedDomain);
            if ($groupName_c == 'n') {
                $groupName = $this->ask("Type the name of your new grouping, like 'Admin/Tasks', or 'Stuff' ", $shortNodeName);
                if ($enumGroupScheme != 'global') {
                    $_fyiResourcesPath  = TassyDomainListCommand::GetDomainResourceAbsolutePath( $enumHoming_ControllersLivewire, $groupName, shopLocal:true);

                    $boolShopLocal = match($this->choice("You have a group, you can choose to also shop locally so the your view files site right there. If local, it will set up a new local 'resources/views' directory for your blade files.\n($_fyiResourcesPath)\n", ['l' => 'Shop Local', 'g' => 'Default Global behavior'], 'l')) {
                        'l'=>true,
                        'g'=>false,
                    };
                }
                TassyDomainListCommand::InitializeGroup($enumHoming_ControllersLivewire, $groupName, $boolShopLocal);
                #TassyDomainCommands::InitializeAssets($groupName, $boolShopLocal);

            } else {
                $groupName = TassyDomainListCommand::GetDomainNames($enumHoming_ControllersLivewire)[$groupName_c];

                $isAlreadyShoppingLocal = TassyDomainListCommand::IsAlreadyShoppingLocal($enumHoming_ControllersLivewire, $groupName);
                if ($isAlreadyShoppingLocal) {
                    $boolShopLocal = true;

                } else {
                    $_fyiResourcesPath  = TassyDomainListCommand::GetDomainResourceAbsolutePath( $enumHoming_ControllersLivewire, $groupName, shopLocal:true);
                    $boolShopLocal = match($this->choice("You have an existing group, but it is not yet set up for local shopping. You can start using local shopping.  You can choose to also shop locally so the your view files sit right there. If local, it will set up a new local 'resources/views' directory for your blade files. \n($_fyiResourcesPath)\n", ['l' => 'Shop Local', 'g' => 'Default Global behavior'], 'l')) {
                        'l'=>true,
                        'g'=>false,
                    };
                    if ($boolShopLocal) {
                        TassyDomainListCommand::InitializeGroup($enumHoming_ControllersLivewire, $groupName, $boolShopLocal);
                        #TassyDomainCommands::InitializeAssets( $groupName, $boolShopLocal);
                    }
                }
            }

        }

        $replacementMap['ReplaceableBool_IsShoppingLocal'] = $boolShopLocal ? 1 : 0 ;
        TassyDomainListCommand::InitializeAssets(groupName: $groupName, pageName: $shortNodeName, shopLocal: $boolShopLocal);
        $replacementMap['ReplaceableString_PathOffsetToAsset'] = TassyDomainListCommand::GetDirOffsetToAssetDir(groupName: $groupName, pageName: $shortNodeName, shopLocal: $boolShopLocal);
        $replacementMap['ReplaceableString_UrlOffsetToAsset'] = TassyDomainListCommand::GetUrlOffsetToAssetDir(groupName: $groupName, pageName: $shortNodeName, shopLocal: $boolShopLocal);

        // Sub Url
        $_urlPrefix = '';
//                if ($enumAdminMeFront == 'admin' && !str_starts_with($groupName, 'admin')) {
//                    $_urlPrefix = 'admin';
//                } elseif ($enumAdminMeFront == 'me' && !str_starts_with($groupName, 'me')) {
//                    $_urlPrefix = 'me';
//                } elseif ($enumAdminMeFront == 'front' && !( str_starts_with($groupName, '/') || empty($groupName) )) {
//                    $_urlPrefix = '';
//                } else {
//                    assert(0,$enumAdminMeFront, $groupName, $_urlPrefix);
//                }
        if ($enumAdminMeFront == 'admin' ) {
            if (!str_starts_with($groupName, 'admin')) {
                $_urlPrefix = 'admin';
            }
        } elseif ($enumAdminMeFront == 'me') {
            if (!str_starts_with($groupName, 'me')) {
                $_urlPrefix = 'me';

            }
        } elseif ($enumAdminMeFront == 'front') {
            $_urlPrefix = '';
        } else {
            assert(0,$enumAdminMeFront, $groupName, $_urlPrefix);
        }
        $_a = [$_urlPrefix,$groupName,$shortNodeName];
        $_a = array_filter($_a);//https://stackoverflow.com/questions/3654295/remove-empty-array-elements

        $ReplaceableSubUrl = $this->ask('What is the relative url? Probably something like "/admin/help"', '/'.implode('/', $_a) );//https://github.com/laracademy/interactive-make/blob/master/src/Commands/MakeCommand.php
        $replacementMap['ReplaceableSubUrl'] = $ReplaceableSubUrl;







//        // where is this menu?
//        $existingRoots_plusNew = ['n'=>'New TreeRootLeaf', ...static::GetMenuTreeRoots($enumAdminMeFront)];
//        $menuPlacement_c = $this->choice('Is this a new root menu item, or will it go under another menu', $existingGroups_plusNew, array_key_first($existingGroups_plusNew));
//        if ($menuPlacement_c == 'n') {
//            $groupName = $this->ask("Type the name of your new grouping, like 'Admin/Tasks', or 'Stuff' ", $shortNodeName);
//            if ($enumGroupScheme != 'global') {
//                $_fyiResourcesPath  = TassyDomainCommands::GetDomainResourceAbsolutePath( $enumHoming_ControllersLivewire, $groupName, shopLocal:true);
//
//                $boolShopLocal = match($this->choice("You have a group, you can choose to also shop locally so the your view files site right there. If local, it will set up a new local 'resources/views' directory for your blade files.\n($_fyiResourcesPath)\n", ['l' => 'Shop Local', 'g' => 'Default Global behavior'], 'l')) {
//                    'l'=>true,
//                    'g'=>false,
//                };
//            }
//            TassyDomainCommands::InitializeGroup($enumHoming_ControllersLivewire, $groupName, $boolShopLocal);
//        } else {
//            $groupName = TassyDomainCommands::GetDomainNames($enumHoming_ControllersLivewire)[$groupName_c];
//
//            $isAlreadyShoppingLocal = TassyDomainCommands::IsAlreadyShoppingLocal($enumHoming_ControllersLivewire, $groupName);
//            if ($isAlreadyShoppingLocal) {
//                $boolShopLocal = true;
//            } else {
//                $_fyiResourcesPath  = TassyDomainCommands::GetDomainResourceAbsolutePath( $enumHoming_ControllersLivewire, $groupName, shopLocal:true);
//                $boolShopLocal = match($this->choice("You have an existing group, but it is not yet set up for local shopping. You can start using local shopping.  You can choose to also shop locally so the your view files sit right there. If local, it will set up a new local 'resources/views' directory for your blade files. \n($_fyiResourcesPath)\n", ['l' => 'Shop Local', 'g' => 'Default Global behavior'], 'l')) {
//                    'l'=>true,
//                    'g'=>false,
//                };
//                if ($boolShopLocal) {
//                    TassyDomainCommands::InitializeGroup($enumHoming_ControllersLivewire, $groupName, $boolShopLocal);
//                }
//            }
//        }
//        $isTreeRootLeaf = true;



        // Namespace ReplaceableNamespace
        if ($enumHoming_ControllersLivewire == 'Controllers') {
            $ReplaceableNamespace = 'App\Http\Controllers';
            $replacementMap['ReplaceableNamespace'] = $ReplaceableNamespace;

        } elseif ($enumHoming_ControllersLivewire == 'Livewire') {
            $ReplaceableNamespace = 'App\Http\Livewire\\'.str_replace('/','\\',$groupName);
            $ReplaceableNamespace = trim($ReplaceableNamespace,'/\\');
            $replacementMap['ReplaceableNamespace'] = $ReplaceableNamespace;
        }

        // Which Page Controller - Single, or Tabbed

        // Is Page controller a tabbed page?
        $enumTopPageScheme_tab_page_tabbed = match($this->choice('Is page a single top-level page, or a tabbed paged.', ['m' => 'Monolithic Page', 't' => 'Tabbed Page', 's'=>'Single Tab'], 's')) {
            'p'=>'monopage',
            't'=>'tabbedpage',
            's'=>'singletab'

        };//https://github.com/laracademy/interactive-make/blob/master/src/Commands/MakeCommand.php
        $replacementMap['enumTopPageScheme'] = $enumTopPageScheme_tab_page_tabbed;

        if ($enumTopPageScheme_tab_page_tabbed == 'tabbedpage') {
            $ReplaceableControllerName = $shortNodeName . 'TabbedPageController';
            $controller_StubSource_filepath = __DIR__ . '/../stubs/TabbedPageController.php.stub';

        } elseif ($enumTopPageScheme_tab_page_tabbed == 'monopage') {
            $ReplaceableControllerName = $shortNodeName . 'Controller';
            $controller_StubSource_filepath = __DIR__ . '/../stubs/Controller.php.stub';
        }elseif ($enumTopPageScheme_tab_page_tabbed == 'singletab') {
            //yuck -  need to  do <livewire:horns.f-i1636769441-livetroller :tabName="'Temp'" :tabSlug="'temp'"/>. But at least it is explicit
            $ReplaceableControllerName = $shortNodeName . 'Livetroller';

            $controller_StubSource_filepath = __DIR__ . '/../stubs/singletab_Livetroller.php.stub';
        } else {
            assert(0,'enum logic');
        }
        $replacementMap['ReplaceableControllerName'] = $ReplaceableControllerName;


        /* Rule: Name groups are shunted into Livewire to avoid infinite file scattering
        */

        if ($enumAdminMeFront == 'admin' && $enumTopPageScheme_tab_page_tabbed != 'singletab') {
            $enumUpperLower = match (
            $this->choice('Where should this menu go? ', ['u' => 'Upper Menu', 'l' => 'Lower Menu'], 'u')
            ) {
                'u' => 'upper',
                'l' => 'lower',
            };
            // OUTPUT: $enumUpperLower
            $replacementMap['enumUpperLower'] = $enumUpperLower;

            // Label
            $ReplaceableLabel = $this->ask('What is the menu text?', $shortNodeName);//https://github.com/laracademy/interactive-make/blob/master/src/Commands/MakeCommand.php
            $replacementMap['ReplaceableLabel'] = $ReplaceableLabel;
        }


        // what does it inherit from?
        if ($enumAdminMeFront == 'admin') {
            $Replaceable_inheritsFrom = '\TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideAdminController_Base';
        } elseif ($enumAdminMeFront == 'front') {
            $Replaceable_inheritsFrom = '\TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideFrontController_Base';
        } elseif ($enumAdminMeFront == 'me') {
            $Replaceable_inheritsFrom = '\TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideMeController_Base';
        } else {
            assert(0,'logic error');
        }
        $replacementMap['Replaceable_inheritsFrom'] = $Replaceable_inheritsFrom;

        // Where to put the controller?
        if ($enumHoming_ControllersLivewire == 'Controllers') {
            $path = 'app/Http/Controllers';
            $path .= (! empty($groupName)) ? "/$groupName" : '';
            $path .=  "/{$ReplaceableControllerName}.php";
//            dd(__FILE__,__LINE__,$path);
            $controller_Destination_filepath = base_path($path);

        } elseif ($enumHoming_ControllersLivewire == 'Livewire') {
            $path = 'app/Http/Livewire';
            $path .= (! empty($groupName)) ? "/$groupName" : '';
            $path .=  "/{$ReplaceableControllerName}.php";
            $controller_Destination_filepath = base_path($path);
        }
        $replacementMap['ReplaceableString_controller_filepath'] = $controller_Destination_filepath;


        // Default HTML
        $ReplaceableHtml = $this->ask("Give me starting html. Leave blank for lorem ipsem", "Fill with whatever you want. ($groupName $shortNodeName)");
        $replacementMap['ReplaceableHtml'] = $ReplaceableHtml;


        // Populate the path the blade via view ref
        // FunFact: GroupName and veiwRef will be the same
        $ReplaceableViewRef = $groupName.DIRECTORY_SEPARATOR.$shortNodeName;
        $replacementMap['ReplaceableViewRef'] = trim($ReplaceableViewRef,'/\\');

        // Title of the page (please make smarter)
        $replacementMap['ReplaceableTitle'] = "ReplaceableTitle for $shortNodeName";


        // Do Route
        if ($enumAdminMeFront == 'admin') {
            $web_x_routes_filepath = base_path('routes/web-admin--routes.php');
            $route_SnippetSource_filepath_rel = __DIR__ . '/../stubs/route_snippets/route-web-admin-xxx.php.stub';
        } elseif  ($enumAdminMeFront == 'front') {
            $web_x_routes_filepath = base_path('routes/web-front--routes.php');
            $route_SnippetSource_filepath_rel = __DIR__ . '/../stubs/route_snippets/route-web-front-xxx.php.stub';
        }elseif  ($enumAdminMeFront == 'me') {
            $web_x_routes_filepath = base_path('routes/web-me--routes.php');
            $route_SnippetSource_filepath_rel = __DIR__ . '/../stubs/route_snippets/route-web-me-xxx.php.stub';
        } else {
            assert(0,'logic');
        }
        static::LoadBackupModifyUpdate($web_x_routes_filepath, function (string $route_web, string $ReplaceableTimestamp) use ($replacementMap, $route_SnippetSource_filepath_rel) {
            $route_SnippetSource_filepath = $route_SnippetSource_filepath_rel;
            $replacementMap['ReplaceableTimestamp'] = $ReplaceableTimestamp;
            $routeSnippet_hydrated = static::HydrateStub(file_get_contents($route_SnippetSource_filepath), $replacementMap);
            return $route_web . $routeSnippet_hydrated;
        });


        // Do Controller
        static::LoadModifyPut($controller_StubSource_filepath, function (string $stub) use ($replacementMap) {
            return static::HydrateStub($stub, $replacementMap);
        }, $controller_Destination_filepath);


        // Do $enumTopPageScheme
        if ($enumAdminMeFront == 'admin') {
            if ($enumTopPageScheme_tab_page_tabbed == 'monopage') {
                $blade_StubSource_filepath = __DIR__ . '/../stubs/admin_page.blade.php.stub';
            } elseif ($enumTopPageScheme_tab_page_tabbed == 'tabbedpage') {
                $blade_StubSource_filepath = __DIR__ . '/../stubs/admin_pageThatIsTabbed.blade.php.stub';
            } elseif ($enumTopPageScheme_tab_page_tabbed == 'singletab') {
                $blade_StubSource_filepath = __DIR__ . '/../stubs/admin_pageThatIsSingleTab.blade.php.stub';
            } else {
                assert(0);
            }
        } elseif  ($enumAdminMeFront == 'front') {
            if ($enumTopPageScheme_tab_page_tabbed == 'monopage') {
                $blade_StubSource_filepath = __DIR__ . '/../stubs/front_page.blade.php.stub';
            } elseif ($enumTopPageScheme_tab_page_tabbed == 'tabbedpage') {
                $blade_StubSource_filepath = __DIR__ . '/../stubs/front_pageThatIsTabbed.blade.php.stub';
            } elseif ($enumTopPageScheme_tab_page_tabbed == 'singletab') {
                $blade_StubSource_filepath = __DIR__ . '/../stubs/front_pageThatIsSingleTab.blade.php.stub';
            } else {
                assert(0);
            }
        }elseif  ($enumAdminMeFront == 'me') {
            if ($enumTopPageScheme_tab_page_tabbed == 'monopage') {
                $blade_StubSource_filepath = __DIR__ . '/../stubs/me_page.blade.php.stub';
            } elseif ($enumTopPageScheme_tab_page_tabbed == 'tabbedpage') {
                $blade_StubSource_filepath = __DIR__ . '/../stubs/me_pageThatIsTabbed.blade.php.stub';
            } elseif ($enumTopPageScheme_tab_page_tabbed == 'singletab') {
                $blade_StubSource_filepath = __DIR__ . '/../stubs/me_pageThatIsSingleTab.blade.php.stub';
            } else {
                assert(0);
            }
        } else {
            assert(0,'logic error');
        }
        $ReplaceableBladePath_offsetFromResource = 'views/' . $ReplaceableViewRef . '.blade.php';
        $blade_Destination_filepath_full = TassyDomainListCommand::GetDomainResourceAbsolutePath($enumHoming_ControllersLivewire, $groupName, $boolShopLocal).DIRECTORY_SEPARATOR.$shortNodeName.'.blade.php';;//resource_path($ReplaceableBladePath_offsetFromResource);
        #dd($blade_Destination_filepath_full);
        $replacementMap['ReplaceableString_BladePath_ResourceOffset'] = $ReplaceableBladePath_offsetFromResource;
        $replacementMap['ReplaceableString_BladePath_Abs'] = $blade_Destination_filepath_full;

        static::LoadModifyPut($blade_StubSource_filepath, function (string $stub) use ($replacementMap) {
            return static::HydrateStub($stub, $replacementMap);
        }, $blade_Destination_filepath_full);


        //        turn view ref into html attribute friendly format
        //        from: horns/E1636768049Love to horns.e1636768049-love or horns.e1636768049-livetroller
        //          If it is a livewire thingy, then the reference is to the controller, not to the view.  Hmm, is it ever to the view?  Maybe not.
        //$replacementMap['ReplaceableView_htmlAttributeCompatible'] =  TsStringConvert::viewPath2htmlAttribute_playsWithLivewire($replacementMap['ReplaceableViewRef']);
        $viewLikePathToController = $groupName.'/'.$replacementMap['ReplaceableControllerName'];// so, like just the offset, not ' App\Http\Livewire\horns\E1636768049Love', just 'horns/E1636768049Love';
        $replacementMap['ReplaceableView_htmlAttributeCompatible'] =  TsStringConvert::viewPath2htmlAttribute_playsWithLivewire($viewLikePathToController);

        // Do Menu Blade
        if ($enumAdminMeFront == 'admin') {
            if ($enumTopPageScheme_tab_page_tabbed == 'monopage' || $enumTopPageScheme_tab_page_tabbed == 'tabbedpage') {
                $isTreeRootLeaf = true;
                $this->info("\nPutting as a Root-Leaf menu item. You can move menu items manually, or use the `php artisan tassy-page:edit-menu` (coming soon-ish)");
                if ($isTreeRootLeaf) {
                    static::LoadBackupModifyUpdate(
                        base_path(static::getMenuBladeFileName($enumUpperLower)),
                        function ($existingMenuFile, $ReplaceableTimestamp) use ($replacementMap) {
                            $menuSnippet_withEnclosedVars = file_get_contents(__DIR__ . '/../stubs/menu-side-treerootleaf.blade.php.stub');
                            $replacementMap['ReplaceableTimestamp'] = $ReplaceableTimestamp;
                            $menuSnippet_hydrated = static::HydrateStub($menuSnippet_withEnclosedVars, $replacementMap);
                            $existingMenuFile .= $menuSnippet_hydrated;
                            return $existingMenuFile;
                        }
                    );
                }
            } elseif ($enumTopPageScheme_tab_page_tabbed == 'singletab') {
                $htmlSnippet = file_get_contents(__DIR__ . '/../stubs/singletab_tab.blade.php.stub');
                $htmlSnippet = static::HydrateStub($htmlSnippet, $replacementMap);
                $this->info( "\n--- Please make the tab work by inserting something like this into your existing tabbed page.");
                $this->alert( "\n$htmlSnippet");

            } else {
                assert(0, 'enum error');
            }
        }


        // Make the routes visible
        Artisan::call('optimize');


    }

    private static function HydrateStub(string $stub, array $keysValuePairs): string
    {
        foreach ($keysValuePairs as $key => $value) {
            $stub = str_replace($key, $value, $stub);
        }
        return $stub;
    }

    private static function LoadBackupModifyUpdate(string $full_filepathWithContentWeWillPervert, \Closure $modifyingClosure_gettingContent_stringTimestamp): void
    {
        // make a backup of the file
        $filepathWithContentWeWillPervert = $full_filepathWithContentWeWillPervert;
        assert(file_exists($filepathWithContentWeWillPervert), $filepathWithContentWeWillPervert);
        $filenameTimestampStub = date('Y_d_m G:i:s');//.YYY_dd_mm HH:mm.php
        $virginalFileNameBackup = $filepathWithContentWeWillPervert . " origAsOf $filenameTimestampStub";
        assert(!file_exists($virginalFileNameBackup));

        $ret = copy($filepathWithContentWeWillPervert, $virginalFileNameBackup);
        assert($ret);

        // Load the File
        assert(file_exists($filepathWithContentWeWillPervert));
        $stub_withEnclosedVars = file_get_contents($filepathWithContentWeWillPervert);

        // Pervert the file
        $hydrated_content = $modifyingClosure_gettingContent_stringTimestamp($stub_withEnclosedVars, $filenameTimestampStub);//static::HydrateStub($stub_withEnclosedVars, $replacementMap);

        // Update the file
        $ret = file_put_contents($filepathWithContentWeWillPervert, $hydrated_content);
        assert($ret);
        unset($stub_withEnclosedVars);

        #$this->info("Made backup of '$web_x_routes_filepath' and wrote to '$virginalFileNameBackup'");
    }

    private static function LoadModifyBackupPut(string $filepathWithContentWeWillPervert_offOfRoot, \Closure $modifyingClosure_gettingContent): void
    {

    }

    private static function LoadModifyPut(string $full_filepathOfStub, \Closure $modifyingClosure_gettingContent, string $full_filepath_newFile_forHydratedStub, bool $doMakeDirsIfNotThere = true): void
    {
        // make a backup of the file
        $filepathWithContentWeWillPervert = $full_filepathOfStub;

        // Load the File
        assert(file_exists($filepathWithContentWeWillPervert), $filepathWithContentWeWillPervert);
        $stub_withEnclosedVars = file_get_contents($filepathWithContentWeWillPervert);
        print "\n$filepathWithContentWeWillPervert";
        print "\n ==> ";

        // Pervert the file
        $hydrated_content = $modifyingClosure_gettingContent($stub_withEnclosedVars);//static::HydrateStub($stub_withEnclosedVars, $replacementMap);

        // write the file to new location
        $filepathWithContent_mustNotExist = $full_filepath_newFile_forHydratedStub;
        print "\n$filepathWithContent_mustNotExist ";
        assert(!file_exists($filepathWithContent_mustNotExist));

        FileUtils::makeDirForFileIfDirNotAlreadyThere($filepathWithContent_mustNotExist);

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
