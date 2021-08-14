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
        print "These are the groups found in ".static::GetGroupDir_offsetFromBasePath($subgroup)."\n";
        $dir = base_path(static::GetGroupDir_offsetFromBasePath().DIRECTORY_SEPARATOR.$subgroup);
        if (! is_dir($dir)) {
            print "\n The dir does not exist.  Zero group here: $dir \n";
            return 0;
        }

        foreach (static::getGroupNames($subgroup) as $name) {
            print $name;
            print "\n";
        }

    }

    public static function GetGroupDir_offsetFromBasePath(): string {
        return 'app/Http/Livewire';
    }

    /* You can pass a subgroup, like 'Admin' */
    public function getGroupNames(?string $_baseGroup = null, array $groupNames_soFar = [] ): array {
        $_baseGroupPrefix = ($_baseGroup ? $_baseGroup.DIRECTORY_SEPARATOR : '');
        #print "\n_baseGroupPrefix($_baseGroupPrefix)\n";
        $_baseDir = static::GetGroupDir_offsetFromBasePath().DIRECTORY_SEPARATOR.$_baseGroupPrefix;

        foreach (scandir(base_path($_baseDir)) as $h) {
            $filepath_to_file_orMaybeDir = base_path($_baseDir).DIRECTORY_SEPARATOR.$h;
            if (is_dir($filepath_to_file_orMaybeDir) and ! in_array($h, ['.','..','resources'])) {
                $newGroupName = ($_baseGroupPrefix ? $_baseGroupPrefix : '').$h;
                $groupNames_soFar[] = $newGroupName;
                #print "\n added $newGroupName";
                $nextDeeperDir_offsetFromBasePath =$newGroupName;
                #print "\n--- About to explore nextDeeperDir_offsetFromBasePath($nextDeeperDir_offsetFromBasePath)";
                $groupNames_soFar = static::getGroupNames($nextDeeperDir_offsetFromBasePath, $groupNames_soFar);
            }
        }
        return $groupNames_soFar;
    }
}
