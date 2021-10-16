<?php
/* FYI: This is registered via
    PageGuide/page-guide-admin/src/PageGuideAdminServiceProvider.php
    if ($this->app->runningInConsole()) {
            $this->commands([
                \TallAndSassy\PageGuideAdmin\Commands\TassyMenuCommands::class,
*/
declare(strict_types=1);
namespace TallAndSassy\Cms\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use JetBrains\PhpStorm\Pure;
use TallAndSassy\Console\ConsoleUtils;
use function PHPUnit\Framework\directoryExists;
use function PHPUnit\Framework\throwException;


class TassyCmsCommands extends Command
{

    protected $signature = 'tassy-cms:install
            ';
    protected $description = 'Run once to make cms features work';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // NPM Packages...
        ConsoleUtils::UpdateNodePackages(callback: function ($packages) {
            return [
                "@ckeditor/ckeditor5-alignment" => "^27.1.0",
        "@ckeditor/ckeditor5-basic-styles" => "^27.1.0",
        "@ckeditor/ckeditor5-cloud-services" => "^27.1.0",
        "@ckeditor/ckeditor5-dev-utils" => "^25.2.1",
        "@ckeditor/ckeditor5-easy-image" => "^27.1.0",
        "@ckeditor/ckeditor5-editor-classic" => "^27.1.0",
        "@ckeditor/ckeditor5-essentials" => "^27.1.0",
        "@ckeditor/ckeditor5-font" => "^27.1.0",
        "@ckeditor/ckeditor5-heading" => "^27.1.0",
        "@ckeditor/ckeditor5-highlight" => "^27.1.0",
        "@ckeditor/ckeditor5-horizontal-line" => "^27.1.0",
        "@ckeditor/ckeditor5-image" => "^27.1.0",
        "@ckeditor/ckeditor5-indent" => "^27.1.0",
        "@ckeditor/ckeditor5-link" => "^27.1.0",
        "@ckeditor/ckeditor5-list" => "^27.1.0",
        "@ckeditor/ckeditor5-media-embed" => "^27.1.0",
        "@ckeditor/ckeditor5-paragraph" => "^27.1.0",
        "@ckeditor/ckeditor5-remove-format" => "^27.1.0",
        "@ckeditor/ckeditor5-table" => "^27.1.0",
        "@ckeditor/ckeditor5-theme-lark" => "^27.1.0"

                ] + $packages;
        }, enum_dev_prod: 'prod');



        print "\npackage.json was updated for Tassy-Cms. Please run 'npm install' and 'run run watch' -or- 'npm run prod'\n";


    }


}
