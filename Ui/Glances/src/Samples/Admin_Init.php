<?php

declare(strict_types=1);
namespace TallAndSassy\Ui\Glances\Samples;
use TallAndSassy\Ui\Glances\Samples\Modals\SampleButtonModal_LivewireController;

class Admin_Init {
    public static function Init(): void {
        if (config('tassy.ui-glances.DoSamples')) {
            TabSample1__Page::Init();

            TechBase\Status__Page::Init();

            SampleButtonModal_LivewireController::SelfRegister(); // We can't, for some reason, init this from the blade itself

        }
    }
}
