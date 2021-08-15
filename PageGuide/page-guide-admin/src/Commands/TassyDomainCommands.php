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
use JetBrains\PhpStorm\Pure;
use function PHPUnit\Framework\directoryExists;
use function PHPUnit\Framework\throwException;


class TassyDomainCommands extends Command
{

    protected $signature = 'tassy-group:list
            { --subdomain=* : "(Admin|Me|Front)"  }';
    protected $description = 'List logical domains. These are ways to consolidate logical functions with minimal impact to the global namespace and, more importantly to consolidate files closer to each other.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $subdomain = '';
        if ($this->option('subdomain')) {
            $subdomain = $this->option('subdomain')[0];
        }
        print "These are the domains found in ".static::GetOffsetPathToDomain($subdomain)."\n";
        $dir = base_path(static::GetDomainDir_offsetFromBasePath().DIRECTORY_SEPARATOR.$subdomain);
        if (! is_dir($dir)) {
            print "\n The dir does not exist.  Zero group here: $dir \n";
            return 0;
        }

        foreach (static::GetDomainNames($subdomain) as $name) {
            print $name;
            print "\n";
        }

    }

    public static function InitializeGroup(string $groupName, bool $shopLocal): void {
        $gfp = static::GetAbsolutePathToDomain($groupName);
        if (file_exists($gfp)) {
//            print "\n The group($groupName) seems to already exist. ".static::GetOffsetPathToDomain($groupName)."\n\n (at: $gfp)";
//            die(-1);
        } else {
            mkdir($gfp);
        }

        if ($shopLocal) {
            $gfp = $gfp . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views';
            if (file_exists($gfp)) {
//            print "\n The group($groupName) seems to already exist. ".static::GetOffsetPathToDomain($groupName)."\n\n (at: $gfp)";
//            die(-1);
            } else {
                mkdir($gfp, recursive: true);
            }
        }

    }

//    private static function GetGroupFilePath_byGroupName(string $groupName): string {
//        $_basedomainsuffix = ($groupName ? $groupName.DIRECTORY_SEPARATOR : '');
//        $_baseDir = static::GetDomainDir_offsetFromBasePath().DIRECTORY_SEPARATOR.$_basedomainsuffix;
//        return base_path($_baseDir);
//    }

    private static function GetAbsolutePathToDomain(?string $_baseGroup = null): string {
        return base_path(static::GetOffsetPathToDomain($_baseGroup));
    }

    #[Pure]
    private static function GetOffsetPathToDomain(?string $_baseGroup = null): string {
        $_baseGroupPrefix = ($_baseGroup ? $_baseGroup.DIRECTORY_SEPARATOR : '');
        #print "\n_baseGroupPrefix($_baseGroupPrefix)\n";
        $_baseDir = static::GetDomainDir_offsetFromBasePath().DIRECTORY_SEPARATOR.$_baseGroupPrefix;
        return $_baseDir;
    }

    private static function GetDomainDir_offsetFromBasePath(): string {
        return 'app/Http/Livewire';
    }


//    JJ - you have two sets of domains livewire and classic
    /* You can pass a subdomain, like 'Admin' */
    public static function GetDomainNames(?string $_baseGroup = null, array $groupNames_soFar = [] ): array {
        $_baseGroupOffsetFromBase = static::GetOffsetPathToDomain($_baseGroup);
        $_baseGroupAbsolutePath = static::GetAbsolutePathToDomain($_baseGroup);

        foreach (scandir($_baseGroupAbsolutePath) as $h) {
            $filepath_to_file_orMaybeDir = $_baseGroupAbsolutePath.DIRECTORY_SEPARATOR.$h;
            if (is_dir($filepath_to_file_orMaybeDir) and ! in_array($h, ['.','..','resources'])) {
                $newGroupName = $_baseGroup ? "$_baseGroup/$h" : $h;
                $groupNames_soFar[] = $newGroupName;
                $groupNames_soFar = static::GetDomainNames($newGroupName, $groupNames_soFar);
            }
        }
        return $groupNames_soFar;
    }
}
