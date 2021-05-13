<?php

namespace TallAndSassy\Ui\Glances\Components;

use Livewire\Component;

class ModalLivewire extends Component
{
    public  $showModal = false;
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
        return view('tassy-ui::samples.Modals.sample-button_and_modal-livewire');
    }
}
