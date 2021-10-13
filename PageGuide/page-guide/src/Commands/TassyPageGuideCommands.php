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

    /**
     * Copied from vendor/laravel/jetstream/src/Console/InstallCommand.php
     * Update the "package.json" file.
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }
}
