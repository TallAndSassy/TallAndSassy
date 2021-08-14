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
use function PHPUnit\Framework\directoryExists;
use function PHPUnit\Framework\throwException;


class TassyGroupCommands extends Command
{

    protected $signature = 'tassy-group:list
            { --subgroup=* : "(Admin|Me|Front)"  }';
    protected $description = 'List logical groups. These are ways to consolidate logical functions with minimal impact to the global namespace and, more importantly to consolidate files closer to each other.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $subgroup = '';
        if ($this->option('subgroup')) {
            $subgroup = $this->option('subgroup')[0];
        }
        print "These are the groups found in ".static::GetOffsetPathToGroup($subgroup)."\n";
        $dir = base_path(static::GetGroupDir_offsetFromBasePath().DIRECTORY_SEPARATOR.$subgroup);
        if (! is_dir($dir)) {
            print "\n The dir does not exist.  Zero group here: $dir \n";
            return 0;
        }

        foreach (static::GetGroupNames($subgroup) as $name) {
            print $name;
            print "\n";
        }

    }

    public static function InitializeGroup(string $groupName): void {
        $gfp = static::GetAbsolutePathToGroup($groupName);
        if (file_exists($gfp)) {
            print "\n The group($groupName) seems to already exist. ".static::GetOffsetPathToGroup($groupName)."\n\n (at: $gfp)";
            die(-1);
        }
        mkdir($gfp);

    }

//    private static function GetGroupFilePath_byGroupName(string $groupName): string {
//        $_baseGroupSuffix = ($groupName ? $groupName.DIRECTORY_SEPARATOR : '');
//        $_baseDir = static::GetGroupDir_offsetFromBasePath().DIRECTORY_SEPARATOR.$_baseGroupSuffix;
//        return base_path($_baseDir);
//    }

    private static function GetAbsolutePathToGroup(?string $_baseGroup = null): string {
        return base_path(static::GetOffsetPathToGroup($_baseGroup));
    }

    private static function GetOffsetPathToGroup(?string $_baseGroup = null): string {
        $_baseGroupPrefix = ($_baseGroup ? $_baseGroup.DIRECTORY_SEPARATOR : '');
        #print "\n_baseGroupPrefix($_baseGroupPrefix)\n";
        $_baseDir = static::GetGroupDir_offsetFromBasePath().DIRECTORY_SEPARATOR.$_baseGroupPrefix;
        return $_baseDir;
    }

    private static function GetGroupDir_offsetFromBasePath(): string {
        return 'app/Http/Livewire';
    }

    /* You can pass a subgroup, like 'Admin' */
    public static function GetGroupNames(?string $_baseGroup = null, array $groupNames_soFar = [] ): array {
        $_baseGroupOffsetFromBase = static::GetOffsetPathToGroup($_baseGroup);
        $_baseGroupAbsolutePath = static::GetAbsolutePathToGroup($_baseGroup);

        foreach (scandir($_baseGroupAbsolutePath) as $h) {
            $filepath_to_file_orMaybeDir = $_baseGroupAbsolutePath.DIRECTORY_SEPARATOR.$h;
            if (is_dir($filepath_to_file_orMaybeDir) and ! in_array($h, ['.','..','resources'])) {
                $newGroupName = $_baseGroup ? "$_baseGroup/$h" : $h;
                $groupNames_soFar[] = $newGroupName;
                $groupNames_soFar = static::GetGroupNames($newGroupName, $groupNames_soFar);
            }
        }
        return $groupNames_soFar;
    }
}
