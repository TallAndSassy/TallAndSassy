<?php

namespace TallAndSassy\Ui\Glances\Samples\Modals;

use Livewire\Component;

class SampleButtonModal_LivewireController extends Component
{
    public  $showModal = false;

    public static function SelfRegister(): void {
        \Livewire\Livewire::component('tassy-ui::Samples.Modals.SampleButtonModal_CustomAlias',  self::class);
    }
    public function handleGoToModal():void {
        $this->showModal = true;
    }
    public function handleCancel():void {
        $this->showModal = false;
    }
    public function handlePrimary():void {
        dd(['do something important']);
    }
    public function render()
    {
        return view('tassy-ui::samples.Modals.sample_modal_livewire_buttonAndModal');
    }
}
