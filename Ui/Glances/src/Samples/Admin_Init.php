<?php

declare(strict_types=1);
namespace TallAndSassy\Ui\Glances\Samples;
use TallAndSassy\Ui\Glances\Samples\Modals\SampleModalLivewire_ModalBody_Livetroller;

class Admin_Init {
    public static function Init(): void {
        if (config('tassy.ui-glances.DoSamples')) {
            TabSample1__Page::Init();

            TechBase\Status__Page::Init();

            SampleModalLivewire_ModalBody_Livetroller::SelfRegister(); // We can't, for some reason, init this from the blade itself
            \TallAndSassy\Ui\Glances\Samples\Modals\WireModal\WorkingSampleLivetroller::SelfRegister();


        }
    }
}
