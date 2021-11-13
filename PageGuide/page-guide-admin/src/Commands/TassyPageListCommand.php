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


class TassyPageListCommand extends Command
{

    protected $signature = 'tassy-page:list
                            { --subdomain=* : "(Admin|Me|Front)"  },
                            { --homing=* : "(Controllers|Livewire)"  }';
    protected $description = 'List the tabs on various pages';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {


        $asrRichPageStructure = TassyPageListCommand::GetRichStructure();
        dd($asrRichPageStructure);
        // print out the structure and get
    }

    public function GetRichStructure(): array {
        $asr = [];


        foreach (TassyDomainListCommand::$arrAllowedHoming_ControllersLivewire as $enumHoming_ControllersLivewire) {
            //print "\napp/Http/$enumHoming_ControllersLivewire";
            $subdomain = '';
            if ($this->option('subdomain')) {
                $subdomain = $this->option('subdomain')[0];
            }
            //print "These are the domains found in " . static::GetOffsetPathToDomain($enumHoming_ControllersLivewire, $subdomain) . "\n";
            $dir = base_path(TassyDomainListCommand::GetDomainDir_offsetFromBasePath($enumHoming_ControllersLivewire) . DIRECTORY_SEPARATOR . $subdomain);

            //            if (!is_dir($dir)) {
            //                print "\n The dir does not exist.  Zero group here: $dir \n";
            //                return 0;
            //            }

            foreach (TassyDomainListCommand::GetDomainNames($enumHoming_ControllersLivewire, $subdomain) as $name) {
              //  print "\n  $name";
                $asr[] = [
                    'enumHome' => $enumHoming_ControllersLivewire,
                    'name' => $name

                ];
            }
        }
        return $asr;
    }
}
