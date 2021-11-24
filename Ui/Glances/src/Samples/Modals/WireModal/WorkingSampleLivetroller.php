<?php

namespace TallAndSassy\Ui\Glances\Samples\Modals\WireModal;

use LivewireUI\Modal\ModalComponent;


class WorkingSampleLivetroller extends ModalComponent
{

    public int $counter = 1;
    public function render()
    {

        return view('tassy-ui::samples.Modals.WireModal.working_inner_modal'); // vendor/tallandsassy/tallandsassy/Ui/Glances/resources/views/samples/Modals/WireModal/working_inner_modal.blade.php
    }

    public function doIncrement() {
        $this->counter++;
    }

    /*  FYI: Since this is in a package, we need to manually register ourselves.
   So, in
       vendor/tallandsassy/tallandsassy/Ui/Glances/src/UiGlances_ServiceProvider.php
   we added  within `public function boot()` something like:
        \TallAndSassy\Ui\Glances\Samples\Modals\WireModal\WorkingSampleLivetroller::SelfRegister();
   You won't normally need do that, unless you too are making a package.
   Feel free to delete this SelfRegister stuff if just doing normal
   */
    CONST COMPONENT_ATTRIBUTE_URI = 'tassy-ui::samples.WireModal.HelloWorld';
    public static function SelfRegister(): void {
        \Livewire\Livewire::component(static::COMPONENT_ATTRIBUTE_URI,  self::class);
    }

}
