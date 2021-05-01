<?php

namespace TallAndSassy\PageGuideAdmin\Components;

use Livewire\Component;

/*
        [ ] Be sure to registrer this compoent in TallAndSassy/PageGuideAdminServiceProvider.php
            Something like this in the function boot()...
                \Livewire\Livewire::component('tassy::livewire.polling-card',  \TallAndSassy\PageGuideAdmin\Components\PollingCard::class);

*/
class PollingCard extends Component
{
    public int $sample_var = 1; // {{$sample_var}} is now avail in your blade.
    protected $listeners = ['universalHandle_butActuallyForPollingCard' => 'doSuperIncrement'];

    public function doSuperIncrement(int $amount = 100)
    {
        $this->sample_var = $this->sample_var + $amount;
    }
    public function render()
    {
        $this->sample_var = $this->sample_var + 1;
        # access via: <livewire:tassy::livewire.polling-card/>
        return view('tassy::livewire.polling-card');
    }

    public int $count = 99;

    public function doIncrement()
    {
        $this->count = $this->count + 1;
    }
}
