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

interface CliChoicer {
    # private static function singleLetterToEnum(string $singleLetter);
    public static function getCliChoice(Command $cmdContext): self;
}


enum EnumControllerType implements CliChoicer
{
    case CLASSIC_CONTROLLER;
    case LIVEWIRE_CONTROLLER;

    public static function getCliChoice(Command $cmdContext): self
    {
        $singleLetterChoice = $cmdContext->choice('How do you want to store the page info', ['c' => 'app/Http/Controllers', 'l' => 'app/Http/Livewire'], 'l');
        $enumSelf = match ($singleLetterChoice) {
            'c' => self::CLASSIC_CONTROLLER,
            'l' => self::LIVEWIRE_CONTROLLER,
        };
        return $enumSelf;
    }

    public function getController_Destination_filepath(string $groupName, EnumInnerPageType $enumInnerPageType, string $shortNodeName): string
    {
        // Where to put the controller?
        $ReplaceableControllerName = $enumInnerPageType->getReplaceableControllerName($shortNodeName);
        if ($this == EnumControllerType::CLASSIC_CONTROLLER) {
            $path = 'app/Http/Controllers';
            $path .= (!empty($groupName)) ? "/$groupName" : '';
            $path .= "/{$ReplaceableControllerName}.php";
            $controller_Destination_filepath = base_path($path);

        } elseif ($this == EnumControllerType::LIVEWIRE_CONTROLLER) {
            $path = 'app/Http/Livewire';
            $path .= (!empty($groupName)) ? "/$groupName" : '';
            $path .= "/{$ReplaceableControllerName}.php";
            $controller_Destination_filepath = base_path($path);
        } else {
            assert(0, 'logic');
        }
        return $controller_Destination_filepath;
    }

    public function getReplaceableNamespace(string $groupName): string
    {

        if ($this == self::CLASSIC_CONTROLLER) {
            $ReplaceableNamespace = 'App\Http\Controllers';


        } elseif ($this == self::LIVEWIRE_CONTROLLER){
            $ReplaceableNamespace = 'App\Http\Livewire\\' . str_replace('/', '\\', $groupName);
            $ReplaceableNamespace = trim($ReplaceableNamespace, '/\\');

        }
        return $ReplaceableNamespace;
    }
}


enum EnumGroupingScheme implements CliChoicer {
    case GLOBAL;
    case GROUPING;

    public static function getCliChoice(Command $cmdContext): self {
        $singleLetterChoice =$cmdContext->choice('You can group this into a logical directory, keeping the files geographically close to each other. Or, you can keep everything global, like default laravel. Grouping is like a lightweight package', ['g' => 'Group it', 'd' => 'Default Global behavior'], 'g');
        $enumSelf = match ($singleLetterChoice) {
            'd'=>self::GLOBAL,
            'g'=>self::GROUPING,
        };
        return $enumSelf;
    }

    public function getCliGroupName(Command $cmd, EnumControllerType $enumHoming_ControllersLivewire, string $shortNodeName): array {
        $existingGroups_plusNew = ['n'=>'New Group (Chose this to create a new grouping)', ...TassyDomainListCommand::GetDomainNames($enumHoming_ControllersLivewire)];
        $defaultToLastTouchedDomain = (count($existingGroups_plusNew) == 1 ? array_key_last($existingGroups_plusNew) : array_key_first(TassyDomainListCommand::GetDomainNames($enumHoming_ControllersLivewire, enumSort_alpha_age: 'age')));
        $groupName_c = $cmd->choice('These are the existing groups', $existingGroups_plusNew, $defaultToLastTouchedDomain);
        $boolShopLocal = false;
        if ($groupName_c == 'n') {
            $groupName_input = $cmd->ask("Type the name of your new grouping, like 'Admin/Tasks', or 'Stuff' ", $shortNodeName);
            $groupName = Str::ucfirst( Str::camel($groupName_input));
            $_arrGroupNames = explode('/', $groupName);
            foreach ($_arrGroupNames as $groupNamePart) {
                if (!preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $groupNamePart)) {
                    assert(0, "Please make sure each group name part ($groupNamePart)  is a php compatible variable name.");
                }
            }
            if ($groupName != $groupName_input) {
                $cmd->info("FYI: We munged your input from '$groupName_input' to '$groupName'");
            }

            if ($this != EnumGroupingScheme::GLOBAL) {
                $_fyiResourcesPath  = TassyDomainListCommand::GetDomainResourceAbsolutePath( $enumHoming_ControllersLivewire, $groupName, shopLocal:true);

                                $boolShopLocal = match($cmd->choice("You have a group, you can choose to also shop locally so the your view files site right there. If local, it will set up a new local 'resources/views' directory for your blade files.\n($_fyiResourcesPath)\n", ['l' => 'Shop Local', 'g' => 'Default Global behavior'], 'l')) {
                                    'l'=>true,
                                    'g'=>false,
                                };
            }
            //TassyDomainListCommand::InitializeGroup($enumHoming_ControllersLivewire, $groupName, $boolShopLocal);
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
        return [$groupName, $boolShopLocal];
    }
}

enum EnumSitePageType implements CliChoicer
{
    case FRONT;
    case ADMIN;
    case ME;

    public static function getCliChoice(Command $cmdContext): self
    {
        $singleLetterChoice = $cmdContext->choice('You want to add a page, great! Where will it live?', ['f' => '/ (user facing)', 'a' => '/admin', 'm' => '/me'], 'a');
        $enumSelf = match ($singleLetterChoice) {
            'f' => static::FRONT,
            'a' => static::ADMIN,
            'm' => static::ME,
        };
        return $enumSelf;
    }

    public function getUrlPrefix(string $groupName): string {
        if($this == self::ADMIN ) {
            if (!str_starts_with($groupName, 'admin')) {
                $_urlPrefix = 'admin';
            }

        } elseif  ($this == EnumSitePageType::ME){
            if (!str_starts_with($groupName, 'me')) {
                $_urlPrefix = 'me';
            }
        } elseif ($this == EnumSitePageType::FRONT){
            $_urlPrefix = '';
        } else {
            assert(0, );
        }
        return $_urlPrefix;
    }


    public function getReplaceable_inheritsFrom(): string
    {
        // what does it inherit from?
        if ($this == EnumSitePageType::ADMIN) {
            $Replaceable_inheritsFrom = '\TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideAdminController_Base';
        } elseif ($this == EnumSitePageType::FRONT) {
            $Replaceable_inheritsFrom = '\TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideFrontController_Base';
        } elseif ($this == EnumSitePageType::ME) {
            $Replaceable_inheritsFrom = '\TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideMeController_Base';
        } else {
            assert(0, 'logic error');
        }
        return $Replaceable_inheritsFrom;
    }
    public function get_web_x_routes_filepath(): string
    {

        if ($this == EnumSitePageType::ADMIN) {
            $web_x_routes_filepath = base_path('routes/web-admin--routes.php');
        } elseif ($this == EnumSitePageType::FRONT) {
            $web_x_routes_filepath = base_path('routes/web-front--routes.php');
        } elseif ($this == EnumSitePageType::ME) {
            $web_x_routes_filepath = base_path('routes/web-me--routes.php');
        } else {
            assert(0, 'logic');
        }
        return $web_x_routes_filepath;
    }
    public function get_route_SnippetSource_filepath_rel(): string
    {

        if ($this == EnumSitePageType::ADMIN) {
            $route_SnippetSource_filepath_rel = __DIR__ . '/../stubs/route_snippets/route-web-admin-xxx.php.stub';
        } elseif ($this == EnumSitePageType::FRONT) {
            $route_SnippetSource_filepath_rel = __DIR__ . '/../stubs/route_snippets/route-web-front-xxx.php.stub';
        } elseif ($this == EnumSitePageType::ME) {
            $route_SnippetSource_filepath_rel = __DIR__ . '/../stubs/route_snippets/route-web-me-xxx.php.stub';
        } else {
            assert(0, 'logic');
        }
        return $route_SnippetSource_filepath_rel;
    }

}
enum EnumInnerPageType implements CliChoicer {
    case MONOLITHIC_PAGE;
    case TABBED_PAGE;
    case SINGLE_INNER_TAB;
    case WIRE_MODAL;

    public static function getCliChoice(Command $cmdContext): self {
        $singleLetterChoice =$cmdContext->choice('Is page a single top-level page, or a tabbed paged.', ['p' => 'Monolithic Page', 't' => 'Page with tabs', 's'=>'Single Tab (within a page with tabs)', 'm'=>'Modal (Wire-Modal Based)']);
        $enumSelf = match ($singleLetterChoice) {
            'p'=>static::MONOLITHIC_PAGE,
            't'=>static::TABBED_PAGE,
            's'=>static::SINGLE_INNER_TAB,
            'm'=>static::WIRE_MODAL
        };
        return $enumSelf;
    }

    public function canHaveSideMenuEntry(): bool {
        return in_array($this,[self::MONOLITHIC_PAGE, self::TABBED_PAGE]);
    }

    public function doesHaveInvokerStub(): bool {
        return in_array($this,[self::SINGLE_INNER_TAB, self::WIRE_MODAL]);
    }

    public function getReplaceableSubUrl(Command $cmd, EnumSitePageType $enumAdminMeFront, string $groupName, string $shortNodeName): string {
        if ($this->hasRoute()) {
            $_urlPrefix = $enumAdminMeFront->getUrlPrefix($groupName);
            $_a = [$_urlPrefix,$groupName,$shortNodeName];
            $_a = array_filter($_a);//https://stackoverflow.com/questions/3654295/remove-empty-array-elements
            $ReplaceableSubUrl = $cmd->ask('What is the relative url? Probably something like "/admin/help"', '/' . implode('/', $_a));//https://github.com/laracademy/interactive-make/blob/master/src/Commands/MakeCommand.php
        } else {
            $ReplaceableSubUrl = 'urlIsNotRelevantForThisPageType';
        }
        return $ReplaceableSubUrl;
    }

    public function getPathAndInstructionToInvokerStub(): array {
        if ($this == self::SINGLE_INNER_TAB) {
            $full_path = __DIR__ . '/../stubs/singletab_tab.blade.php.stub';
            $cli_instructions = " Please make the tab work by inserting something like this into your existing tabbed page.";
        } elseif ($this == self::WIRE_MODAL)  {
            $full_path = __DIR__ . '/../../../../Ui/Glances/src/stubs/WireModalButton.blade.php.stub';
            $cli_instructions = " Please insert this button (or something similar) into an existing page.";

        } else {
            assert(0);
        }
        return [$full_path, $cli_instructions];
    }
    public function getReplaceableControllerName(string $shortNodeName): string {
        if ($this == EnumInnerPageType::TABBED_PAGE) {
            $ReplaceableControllerName = $shortNodeName . 'TabbedPageController';


        } elseif ($this == EnumInnerPageType::MONOLITHIC_PAGE) {
            $ReplaceableControllerName = $shortNodeName . 'Controller';

        }elseif ($this == EnumInnerPageType::SINGLE_INNER_TAB) {
            //yuck -  need to  do <livewire:horns.f-i1636769441-livetroller :tabName="'Temp'" :tabSlug="'temp'"/>. But at least it is explicit
            $ReplaceableControllerName = $shortNodeName . 'Livetroller';

        }elseif ($this == EnumInnerPageType::WIRE_MODAL) {
            $ReplaceableControllerName = $shortNodeName . 'Livemodtroller';

        } else {
            assert(0,'enum logic');
        }
        return $ReplaceableControllerName;
    }

    public function getController_StubSource_filepath(): string {
        if ($this == EnumInnerPageType::TABBED_PAGE) {
            $controller_StubSource_filepath = __DIR__ . '/../stubs/TabbedPageController.php.stub';

        } elseif ($this == EnumInnerPageType::MONOLITHIC_PAGE) {
            $controller_StubSource_filepath = __DIR__ . '/../stubs/Controller.php.stub';

        }elseif ($this == EnumInnerPageType::SINGLE_INNER_TAB) {
            $controller_StubSource_filepath = __DIR__ . '/../stubs/singletab_Livetroller.php.stub';

        }elseif ($this == EnumInnerPageType::WIRE_MODAL) {
            $controller_StubSource_filepath = __DIR__ . '/../../../../Ui/Glances/src/stubs/WireModalLivetroller.php.stub';


        } else {
            assert(0,'enum logic');
        }
        return $controller_StubSource_filepath;
    }

    public function hasRoute(): bool {
        return ($this == self::MONOLITHIC_PAGE || $this == self::TABBED_PAGE);
    }




    public function get_blade_StubSource_filepath(EnumSitePageType $enumAdminMeFront): string
    {

        // Do $enumTopPageScheme
        if ($enumAdminMeFront == EnumSitePageType::ADMIN) {
            if ($this == EnumInnerPageType::MONOLITHIC_PAGE) {
                $blade_StubSource_filepath = __DIR__ . '/../stubs/admin_page.blade.php.stub';
            } elseif ($this == EnumInnerPageType::TABBED_PAGE) {
                $blade_StubSource_filepath = __DIR__ . '/../stubs/admin_pageThatIsTabbed.blade.php.stub';
            } elseif ($this == EnumInnerPageType::SINGLE_INNER_TAB) {
                $blade_StubSource_filepath = __DIR__ . '/../stubs/singletab_body.blade.php.stub';
            } elseif ($this == EnumInnerPageType::WIRE_MODAL) {
                $blade_StubSource_filepath = __DIR__ . '/../../../../Ui/Glances/src/stubs/WireModalInnerModal.blade.php.stub';
            } else {
                assert(0);
            }
        } elseif ($enumAdminMeFront == EnumSitePageType::FRONT) {
            if ($this == EnumInnerPageType::MONOLITHIC_PAGE) {
                $blade_StubSource_filepath = __DIR__ . '/../stubs/front_page.blade.php.stub';
            } elseif ($this == EnumInnerPageType::TABBED_PAGE) {
                $blade_StubSource_filepath = __DIR__ . '/../stubs/front_pageThatIsTabbed.blade.php.stub';
            } elseif ($this == EnumInnerPageType::SINGLE_INNER_TAB) {
                $blade_StubSource_filepath = __DIR__ . '/../stubs/singletab_body.blade.php.stub';
            } elseif ($this == EnumInnerPageType::WIRE_MODAL) {
                $blade_StubSource_filepath = __DIR__ . '/../../../../Ui/Glances/src/stubs/WireModalInnerModal.blade.php.stub';

            } else {
                assert(0);
            }
        } elseif ($enumAdminMeFront == EnumSitePageType::ME) {
            if ($this == EnumInnerPageType::MONOLITHIC_PAGE) {
                $blade_StubSource_filepath = __DIR__ . '/../stubs/me_page.blade.php.stub';
            } elseif ($this == EnumInnerPageType::TABBED_PAGE) {
                $blade_StubSource_filepath = __DIR__ . '/../stubs/me_pageThatIsTabbed.blade.php.stub';
            } elseif ($this == EnumInnerPageType::SINGLE_INNER_TAB) {
                $blade_StubSource_filepath = __DIR__ . '/../stubs/singletab_body.blade.php.stub';
            } elseif ($this == EnumInnerPageType::WIRE_MODAL) {
                $blade_StubSource_filepath = __DIR__ . '/../../../../Ui/Glances/src/stubs/WireModalInnerModal.blade.php.stub';

            } else {
                assert(0);
            }
        } else {
            assert(0, 'logic error');
        }
        return $blade_StubSource_filepath;

    }



}

enum EnumUpperLowerMenu implements CliChoicer {
    case UPPER_MENU;
    case LOWER_MENU;

    public static function getCliChoice(Command $cmdContext): self {
        $singleLetterChoice =$cmdContext->choice('Where should this menu go? ', ['u' => 'Upper Menu', 'l' => 'Lower Menu'], 'u');
        $enumSelf = match ($singleLetterChoice) {
            'u'=>static::UPPER_MENU,
            'l'=>static::LOWER_MENU,
        };
        return $enumSelf;
    }
}



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
        $enumHoming_ControllersLivewire = EnumControllerType::getCliChoice($this);
        $enumAdminMeFront = EnumSitePageType::getCliChoice($this);
        $enumGroupScheme = EnumGroupingScheme::getCliChoice($this);


        if ($enumGroupScheme == EnumGroupingScheme::GLOBAL) {
            $groupName = '';
            $boolShopLocal = false;
        } else {
            [$groupName, $boolShopLocal]  = $enumGroupScheme->getCliGroupName(cmd:$this, enumHoming_ControllersLivewire:$enumHoming_ControllersLivewire, shortNodeName:$shortNodeName);

            TassyDomainListCommand::InitializeGroup($enumHoming_ControllersLivewire, $groupName, $boolShopLocal);
        }


        $replacementMap['ReplaceableBool_IsShoppingLocal'] = $boolShopLocal ? 1 : 0 ;
        TassyDomainListCommand::InitializeAssets(groupName: $groupName, pageName: $shortNodeName, shopLocal: $boolShopLocal);
        $replacementMap['ReplaceableString_PathOffsetToAsset'] = TassyDomainListCommand::GetDirOffsetToAssetDir(groupName: $groupName, pageName: $shortNodeName, shopLocal: $boolShopLocal);
        $replacementMap['ReplaceableString_UrlOffsetToAsset'] = TassyDomainListCommand::GetUrlOffsetToAssetDir(groupName: $groupName, pageName: $shortNodeName, shopLocal: $boolShopLocal);

        // Sub Url
        $_urlPrefix = '';


        // Namespace ReplaceableNamespace
        $replacementMap['ReplaceableNamespace'] = $enumHoming_ControllersLivewire->getReplaceableNamespace($groupName);


        // Which Page Controller - Single, or Tabbed

        // Is Page controller a tabbed page?
        $enumTopPageScheme_tab_page_tabbed = EnumInnerPageType::getCliChoice($this);
        $ReplaceableControllerName = $enumTopPageScheme_tab_page_tabbed->getReplaceableControllerName(shortNodeName: $shortNodeName);
        $controller_StubSource_filepath = $enumTopPageScheme_tab_page_tabbed->getController_StubSource_filepath();
        $replacementMap['ReplaceableControllerName'] = $ReplaceableControllerName;
        $replacementMap['ReplaceableFQNControllerName'] = $replacementMap['ReplaceableNamespace'] .'\\'.$ReplaceableControllerName;  // should be in EnumInnerPageType

        /* Rule: Name groups are shunted into Livewire to avoid infinite file scattering
        */

        if ($enumTopPageScheme_tab_page_tabbed->canHaveSideMenuEntry()) {
            $enumUpperLower = EnumUpperLowerMenu::getCliChoice($this);

            // Label
            $ReplaceableLabel = $this->ask('What is the menu text?', $shortNodeName);//https://github.com/laracademy/interactive-make/blob/master/src/Commands/MakeCommand.php
            $replacementMap['ReplaceableLabel'] = $ReplaceableLabel;
        }


        $ReplaceableSubUrl = $enumTopPageScheme_tab_page_tabbed->getReplaceableSubUrl(cmd:$this, enumAdminMeFront:$enumAdminMeFront, groupName:$groupName, shortNodeName:$shortNodeName);
        $replacementMap['ReplaceableSubUrl'] = $ReplaceableSubUrl;

        $Replaceable_inheritsFrom = $enumAdminMeFront->getReplaceable_inheritsFrom();
        $replacementMap['Replaceable_inheritsFrom'] = $Replaceable_inheritsFrom;

        $controller_Destination_filepath = $enumHoming_ControllersLivewire->getController_Destination_filepath(groupName: $groupName,  enumInnerPageType:$enumTopPageScheme_tab_page_tabbed, shortNodeName:$shortNodeName);
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
        if ($enumTopPageScheme_tab_page_tabbed->hasRoute()) {
            $web_x_routes_filepath = $enumAdminMeFront->get_web_x_routes_filepath();
            $route_SnippetSource_filepath_rel = $enumAdminMeFront->get_route_SnippetSource_filepath_rel();

            static::LoadBackupModifyUpdate($web_x_routes_filepath, function (string $route_web, string $ReplaceableTimestamp) use ($replacementMap, $route_SnippetSource_filepath_rel) {
                $route_SnippetSource_filepath = $route_SnippetSource_filepath_rel;
                $replacementMap['ReplaceableTimestamp'] = $ReplaceableTimestamp;
                $routeSnippet_hydrated = static::HydrateStub(file_get_contents($route_SnippetSource_filepath), $replacementMap);
                return $route_web . $routeSnippet_hydrated;
            });
        }


        //        turn view ref into html attribute friendly format
        //        from: horns/E1636768049Love to horns.e1636768049-love or horns.e1636768049-livetroller
        //          If it is a livewire thingy, then the reference is to the controller, not to the view.  Hmm, is it ever to the view?  Maybe not.
        //$replacementMap['ReplaceableView_htmlAttributeCompatible'] =  TsStringConvert::viewPath2htmlAttribute_playsWithLivewire($replacementMap['ReplaceableViewRef']);
        $viewLikePathToController = $groupName.'/'.$replacementMap['ReplaceableControllerName'];// so, like just the offset, not ' App\Http\Livewire\horns\E1636768049Love', just 'horns/E1636768049Love';
        $replacementMap['ReplaceableView_htmlAttributeCompatible'] =  TsStringConvert::viewPath2htmlAttribute_playsWithLivewire($viewLikePathToController);

        // Do Controller
        static::LoadModifyPut($controller_StubSource_filepath, function (string $stub) use ($replacementMap) {
            return static::HydrateStub($stub, $replacementMap);
        }, $controller_Destination_filepath);

        $blade_StubSource_filepath = $enumTopPageScheme_tab_page_tabbed->get_blade_StubSource_filepath($enumAdminMeFront);

        $ReplaceableBladePath_offsetFromResource = 'views/' . $ReplaceableViewRef . '.blade.php';
        $blade_Destination_filepath_full = TassyDomainListCommand::GetDomainResourceAbsolutePath($enumHoming_ControllersLivewire, $groupName, $boolShopLocal).DIRECTORY_SEPARATOR.$shortNodeName.'.blade.php';;//resource_path($ReplaceableBladePath_offsetFromResource);
        #dd($blade_Destination_filepath_full);
        $replacementMap['ReplaceableString_BladePath_ResourceOffset'] = $ReplaceableBladePath_offsetFromResource;
        $replacementMap['ReplaceableString_BladePath_Abs'] = $blade_Destination_filepath_full;

        static::LoadModifyPut($blade_StubSource_filepath, function (string $stub) use ($replacementMap) {
            return static::HydrateStub($stub, $replacementMap);
        }, $blade_Destination_filepath_full);


        // Do Menu Blade
        if ($enumAdminMeFront == EnumSitePageType::ADMIN) {
            if ($enumTopPageScheme_tab_page_tabbed->canHaveSideMenuEntry()) {
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
            }

            if ($enumTopPageScheme_tab_page_tabbed->doesHaveInvokerStub()) {
                [$full_path, $cli_instructions] = $enumTopPageScheme_tab_page_tabbed->getPathAndInstructionToInvokerStub();
                $htmlSnippet = file_get_contents($full_path);
                $htmlSnippet = static::HydrateStub($htmlSnippet, $replacementMap);
                $this->info( "\n--- $cli_instructions");
                $this->alert( "\n$htmlSnippet");

            }
        }

        dd($replacementMap);


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
        $filenameTimestampStub = date('Y_m_d G:i:s');//.YYY_dd_mm HH:mm.php
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

    private static function getMenuBladeFileName(EnumUpperLowerMenu $enumUpperLower): string
    {
        if ($enumUpperLower == EnumUpperLowerMenu::UPPER_MENU) {
            $filename = 'resources/views/vendor/tassy/admin/menu-side-upper-above.blade.php';
        } elseif ($enumUpperLower == EnumUpperLowerMenu::LOWER_MENU) {
            $filename = 'resources/views/vendor/tassy/admin/menu-side-lower-above.blade.php';
        } else {
            assert(0);
        }
        return $filename;
    }

}
