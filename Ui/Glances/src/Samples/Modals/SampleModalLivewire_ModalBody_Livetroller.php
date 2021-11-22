<?php

namespace TallAndSassy\Ui\Glances\Samples\Modals;

use Livewire\Component;

class SampleModalLivewire_ModalBody_Livetroller extends Component
{
    public  $showModal = false;

    public static function SelfRegister(): void {
        \Livewire\Livewire::component('tassy-ui::Samples.Modals.SampleModalLivewire_ModalBody_Livetroller',  self::class);
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
        return view('tassy-ui::samples.Modals.SampleModalLivewire_ModalBody');
    }
}
