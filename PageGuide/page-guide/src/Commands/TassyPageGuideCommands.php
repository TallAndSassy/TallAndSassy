<?php
/* FYI: This is registered via
    PageGuide/page-guide-admin/src/PageGuideAdminServiceProvider.php
    if ($this->app->runningInConsole()) {
            $this->commands([
                \TallAndSassy\PageGuideAdmin\Commands\TassyMenuCommands::class,
*/
declare(strict_types=1);
namespace TallAndSassy\PageGuide\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use JetBrains\PhpStorm\Pure;
use function PHPUnit\Framework\directoryExists;
use function PHPUnit\Framework\throwException;


class TassyPageGuideCommands extends Command
{

    protected $signature = 'tassy-page-guide:install
            ';
    protected $description = 'Run once to make cms features work';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
//        // NPM Packages...
//        $this->updateNodePackages(function ($packages) {
//            return [
//               "@ryangjchandler/spruce"=> "github:ryangjchandler/spruce",// probably OBE if you start using slapine 3.0
//                ] + $packages;
//        });
//
//        print "\npackage.json was updated for Tassy-Page-Guide. Please run 'npm install' and 'run run watch' -or- 'npm run prod'\n";
    }


}
