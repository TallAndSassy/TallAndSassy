<?php

namespace TallAndSassy\PageGuide\Commands;

use Illuminate\Console\Command;

/* This original file is a template.  Feel free to copy and rename, as needed.
For each 'Command' in this directory, there should be a corresponding
entry in src/PageGuideServiceProvider.php/boot/this->commands([...


*/

class PageGuideCommand extends Command
{
    public $signature = 'tassy:somecommand'; # Hint: The ':' groups the command under a similiar heading.

    public $description = 'Default description for TallAndSassy/PageGuide command';

    public $help = <<<EOD
    Sample: Your extendended instructions goes here.
    These instructions should be more thurough than the description.
    EOD;
    
    public function handle()
    {
        $this->comment('TallAndSassy/PageGuide/hw/tbd');
    }
}
