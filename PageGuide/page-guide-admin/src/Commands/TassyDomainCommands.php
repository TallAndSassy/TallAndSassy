<?php
/* FYI: This is registered via
    PageGuide/page-guide-admin/src/PageGuideAdminServiceProvider.php
    if ($this->app->runningInConsole()) {
            $this->commands([
                \TallAndSassy\PageGuideAdmin\Commands\TassyMenuCommands::class,
*/
declare(strict_types=1);
namespace TallAndSassy\PageGuideAdmin\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use JetBrains\PhpStorm\Pure;
use function PHPUnit\Framework\directoryExists;
use function PHPUnit\Framework\throwException;


class TassyDomainCommands extends Command
{

    protected $signature = 'tassy-domain:list
            { --subdomain=* : "(Admin|Me|Front)"  },
            { --homing=* : "(Controllers|Livewire)"  }
            ';
    protected $description = 'List logical domains. These are ways to consolidate logical functions with minimal impact to the global namespace and, more importantly to consolidate files closer to each other.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $arrHoming_ControllersLivewire = ['Controllers', 'Livewire'];
        $enumHoming_ControllersLivewire = '';
        if ($this->option('homing')) {
            $enumHoming_ControllersLivewire = [$this->option('homing')[0]];
            assert(in_array($enumHoming_ControllersLivewire, $arrHoming_ControllersLivewire));
        }
        //        if (! in_array($enumHoming_ControllersLivewire,['Controllers', 'Livewire']) ) {
        //            $enumHoming_ControllersLivewire = [match (
        //            $this->choice('How do you want to store the page info', ['c' => 'app/Http/Controllers', 'l' => 'app/Http/Livewire'], 'l')
        //            ) {
        //                'c' => 'Controllers',
        //                'l' => 'Livewire',
        //            }];
        //        }


        foreach ($arrHoming_ControllersLivewire as $enumHoming_ControllersLivewire) {
            print "\n-------- $enumHoming_ControllersLivewire -----------\n";
            $subdomain = '';
            if ($this->option('subdomain')) {
                $subdomain = $this->option('subdomain')[0];
            }
            print "These are the domains found in " . static::GetOffsetPathToDomain($enumHoming_ControllersLivewire, $subdomain) . "\n";
            $dir = base_path(static::GetDomainDir_offsetFromBasePath($enumHoming_ControllersLivewire) . DIRECTORY_SEPARATOR . $subdomain);
            if (!is_dir($dir)) {
                print "\n The dir does not exist.  Zero group here: $dir \n";
                return 0;
            }

            foreach (static::GetDomainNames($enumHoming_ControllersLivewire, $subdomain) as $name) {
                print $name;
                print "\n";
            }
        }

    }

    public static function IsAlreadyShoppingLocal(string $enumHoming_ControllersLivewire, string $groupName): bool {
        $gfp = static::GetDomainResourceAbsolutePath( $enumHoming_ControllersLivewire, $groupName, true);
        return file_exists($gfp);
    }
    public static function GetDomainResourceAbsolutePath(string $enumHoming_ControllersLivewire, string $groupName, bool $shopLocal) : string{
        $gfp = static::GetAbsolutePathToDomain( $enumHoming_ControllersLivewire, $groupName);
        if ($shopLocal) {
            $gfp = $gfp . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views';
        } else {
            $gfp = base_path('resources' . DIRECTORY_SEPARATOR . 'views');
        }
        $gfp .= (empty($groupName)) ? '' : DIRECTORY_SEPARATOR.$groupName;
        return $gfp;
    }

    public static function InitializeGroup(string $enumHoming_ControllersLivewire, string $groupName, bool $shopLocal): void {
        $gfp = static::GetAbsolutePathToDomain( $enumHoming_ControllersLivewire, $groupName);

        // Homing
        if (file_exists($gfp)) {
            print "\n The group($groupName) homing dir seems to already exist (at: $gfp)\n";
//            die(-1);
        } else {
            mkdir($gfp, recursive: true);
            assert(file_exists($gfp),$gfp);
            print "\nMade Directory: $gfp\n";
            #dd("this is there($gfp)");
        }

        //                if ($shopLocal) {
        //                    $gfp = $gfp . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views';
        //                } else {
        //                    $gfp = base_path('resources' . DIRECTORY_SEPARATOR . 'views');
        //                }
        //                $gfp .= (empty($groupName)) ? '' : DIRECTORY_SEPARATOR.$groupName;
        $gfp  = static::GetDomainResourceAbsolutePath( $enumHoming_ControllersLivewire, $groupName, $shopLocal);
        if (file_exists($gfp)) {
            print "\n The group($groupName) resources seems to already exist (at: $gfp)\n";
            //            print "\n The group($groupName) seems to already exist. ".static::GetOffsetPathToDomain($groupName)."\n\n (at: $gfp)";
            //            die(-1);
        } else {
            mkdir($gfp, recursive: true);
            print "\nMade Directory: $gfp\n";
            assert(file_exists($gfp),$gfp);
        }



    }


    public static function InitializeAssets( string $groupName, string $pageName, bool $shopLocal): void
    {

        if (!$shopLocal) {

            return;
        }

        // images
        $gfp = static::GetAbsolutePathToAssetDir($groupName, $pageName, $shopLocal);
//        dd(__FILE__,__LINE__,$shopLocal,$groupName, $gfp);
        if (! file_exists($gfp)) {
            mkdir($gfp, recursive: true);
            print "\nMade Directory: $gfp\n";
            assert(file_exists($gfp),$gfp);
        }
    }
//    private static function GetGroupFilePath_byGroupName(string $groupName): string {
//        $_basedomainsuffix = ($groupName ? $groupName.DIRECTORY_SEPARATOR : '');
//        $_baseDir = static::GetDomainDir_offsetFromBasePath().DIRECTORY_SEPARATOR.$_basedomainsuffix;
//        return base_path($_baseDir);
//    }

    private static function GetAbsolutePathToDomain(string $enumHoming_ControllersLivewire, ?string $_baseGroup = null): string {
        return base_path(static::GetOffsetPathToDomain($enumHoming_ControllersLivewire, $_baseGroup));
    }

    private static function GetAbsolutePathToAssetDir( string $groupName, string $pageName, bool $shopLocal): string {
        return base_path(static::GetDirOffsetToAssetDir($groupName, $pageName, $shopLocal));
    }
    //    private static function GetUrlToAssetDir( string $groupName, string $pageName, bool $shopLocal): string {
    //        assert(0, 'call from within the blade asset(TassyDomainCommands::GetOffsetUrlToAssetDir() instead cuz issues when called from command line');
    //        return asset(static::GetOffsetPathToAssetDir($groupName, $pageName, $shopLocal));
    //    }
    #[Pure]
    public static function GetDirOffsetToAssetDir(string $groupName, string $pageName, bool $shopLocal): string {
        if (!$shopLocal) {
            return 'public';
        }
        $_baseGroupPrefix = ($groupName ? $groupName.DIRECTORY_SEPARATOR : '');
        return "public/$_baseGroupPrefix/$pageName";
    }
    #[Pure]
    public static function GetUrlOffsetToAssetDir(string $groupName, string $pageName, bool $shopLocal): string {
        if (!$shopLocal) {
            return '';
        }
        $_baseGroupPrefix = ($groupName ? $groupName.DIRECTORY_SEPARATOR : '');
        return "$_baseGroupPrefix/$pageName";
    }

    #[Pure]
    private static function GetOffsetPathToDomain(string $enumHoming_ControllersLivewire, ?string $_baseGroup = null): string {
        $_baseGroupPrefix = ($_baseGroup ? $_baseGroup.DIRECTORY_SEPARATOR : '');
        #print "\n_baseGroupPrefix($_baseGroupPrefix)\n";
        $_baseDir = static::GetDomainDir_offsetFromBasePath($enumHoming_ControllersLivewire).DIRECTORY_SEPARATOR.$_baseGroupPrefix;
        return $_baseDir;
    }

    private static function GetDomainDir_offsetFromBasePath(string $enumHoming_ControllersLivewire): string {
        if ($enumHoming_ControllersLivewire == 'Livewire') {
            return 'app/Http/Livewire';
        } elseif($enumHoming_ControllersLivewire == 'Controllers') {
            return 'app/Http/Controllers';
        } else {
            assert(0, "enumHoming_ControllersLivewire($enumHoming_ControllersLivewire)");
            return '';
        }
    }


//    JJ - you have two sets of domains livewire and classic
    /* You can pass a subdomain, like 'Admin' */
    public static function GetDomainNames(string $enumHoming_ControllersLivewire, ?string $_baseGroup = null, array $groupNames_soFar = [], bool $doMakeDirsIfNotThere = true): array {
        $_baseGroupOffsetFromBase = static::GetOffsetPathToDomain($enumHoming_ControllersLivewire, $_baseGroup);
        $_baseGroupAbsolutePath = static::GetAbsolutePathToDomain($enumHoming_ControllersLivewire, $_baseGroup);

        FileUtils::makeDirIfNotAlreadyThere($_baseGroupAbsolutePath);

        foreach (scandir($_baseGroupAbsolutePath) as $h) {
            $filepath_to_file_orMaybeDir = $_baseGroupAbsolutePath.DIRECTORY_SEPARATOR.$h;
            if (is_dir($filepath_to_file_orMaybeDir) and ! in_array($h, ['.','..','resources'])) {
                $newGroupName = $_baseGroup ? "$_baseGroup/$h" : $h;
                $groupNames_soFar[] = $newGroupName;
                $groupNames_soFar = static::GetDomainNames($enumHoming_ControllersLivewire, $newGroupName, $groupNames_soFar);
            }
        }
        return $groupNames_soFar;
    }
}
