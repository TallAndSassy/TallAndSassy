<?php
/* FYI: This is registered via
    PageGuide/page-guide-admin/src/PageGuideAdminServiceProvider.php
    if ($this->app->runningInConsole()) {
            $this->commands([
                \TallAndSassy\PageGuideAdmin\Commands\TassyMenuCommands::class,
*/

namespace TallAndSassy\PageGuideAdmin\Commands;

use Illuminate\Console\Command;


class TassyMenuCommands extends Command
{

    protected $signature = 'tassy-menu:add
     { --location=* : "(upper|lower)"  }
     { --suburl=* : "a relative url"  }
     { --label=* : "A quoted label for the menu item."  }';
    protected $description = 'Add an admin menu. usage: php artisan tassy-menu:add (upper|lower) --label="People Stuff"';

    // Future: Add --blade="" optino
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Location
        if ($this->option('location')) {
            $enumUpperLower_untrusted = $this->option('location')[0];
        } else {
            $enumUpperLower_c = $this->choice('Where should this menu go? ', ['u' => 'Upper Menu', 'l' => 'Lower Menu'], 'u');//https://github.com/laracademy/interactive-make/blob/master/src/Commands/MakeCommand.php
            $enumUpperLower_untrusted = $enumUpperLower_c == 'u' ? 'upper' : 'lower';
            unset($enumUpperLower_c);
        }

        if (!in_array($enumUpperLower_untrusted,['upper','lower'])) {
            $this->error("Your first argument ($enumUpperLower_untrusted) must be 'upper' or 'lower'. Nothing else.");
            return;
        }
        $enumUpperLower = $enumUpperLower_untrusted;
        unset($enumUpperLower_untrusted);
        // OUTPUT: $enumUpperLower

        // Label
        if (! $this->option('label')) {
            $label = $this->ask('What is the menu text?');//https://github.com/laracademy/interactive-make/blob/master/src/Commands/MakeCommand.php
        } else {
            $label = $this->option('label')[0];
        }
        // output: $label

        // Sub Url
        if (! $this->option('suburl')) {
            $suburl = $this->ask('What is the relative path? Probably something like "/admin/help"');//https://github.com/laracademy/interactive-make/blob/master/src/Commands/MakeCommand.php
        } else {
            $suburl = $this->option('suburl')[0];
        }
        // output: $suburl

        // Find the file
        $bladeFileName = static::getMenuBladeFileName($enumUpperLower);
        if (! file_exists($bladeFileName)) {
            $this->error("Hmm. I'm expecting $bladeFileName to exist.");
            return;
        }


        // make a backup of the file
        $filenameTimestampStub = date('Y_d_m G:i:s');//.YYY_dd_mm HH:mm.php
        $bladeFileNameBackup = $bladeFileName." origAsOf $filenameTimestampStub";
        assert(! file_exists($bladeFileNameBackup));// Backup file with this name already exists. Try again in one minute.

        $ret = copy($bladeFileName,$bladeFileNameBackup);
        assert($ret);
        $this->info("Made backup of '$bladeFileName' and wrote to '$bladeFileNameBackup'");



        // Load the file, so we can muck with it
        $html = file_get_contents($bladeFileName);


        // muck with the file

        // Make new menu
        $newMenuHtml_withEnclosedVars = file_get_contents(__DIR__.'/../stubs/menu-side-treerootleaf.blade.php.stub');
        $newMenuHtml = str_replace(['{label}','{suburl}'],[$label, $suburl],$newMenuHtml_withEnclosedVars);
        unset($newMenuHtml_withEnclosedVars);

    //        $newMenuHtml =<<<EOD
    //        {{--    New menu $label created on $filenameTimestampStub -BEGIN --}}
    //        <x-tassy::menu-side-treerootleaf suburl="$suburl">
    //            <div class="mr-1.5 text-gray-400">
    //                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
    //            </div>
    //            $label
    //        </x-tassy::menu-side-treerootleaf>
    //        {{--    New menu $label created on $filenameTimestampStub -END --}}
    //        EOD;

        // put it in the right spot
        $html .= $newMenuHtml;


        // update/write the file back to where you found it
        $ret = file_put_contents($bladeFileName, $html);
        assert($ret);


        // give feedback to the user
        $this->info("The file '$bladeFileName' was updated to have a new menu. Take a look at it now - tweak as needed.");


        // Make the page go somewhere

    }

    private static function getMenuBladeFileName(string $enumUpperLower): string {
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
