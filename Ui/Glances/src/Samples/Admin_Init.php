<?php

declare(strict_types=1);
namespace TallAndSassy\Ui\Glances\Samples;
use TallAndSassy\PageGuide\MenuTree;

class Admin_Init {
    public static function Init(): void {
        if (config('tassy.ui-glances.DoSamples')) {
            TabSample1__Page::Init();

            TechBase\Status__Page::Init();

        }
    }
}
