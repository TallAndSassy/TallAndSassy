<?php

namespace TallAndSassy\PageGuide\Components;

use Livewire\Component;

/*
        [ ] Be sure to registrer this compoent in TallAndSassy/PageGuideServiceProvider.php
            Something like this in the function boot()...
                \Livewire\Livewire::component('tassy::livewire.sidenav',  \TallAndSassy\PageGuide\Components\Sidenav::class);

*/
class Sidenav extends Component
{
    public string $sample_var = "defaultValue"; // {{$sample_var}} is now avail in your blade.



    public function render()
    {
        # access via: <livewire:tassy::livewire.sidenav/>
        return view('tassy::livewire.sidenav');
    }
}
