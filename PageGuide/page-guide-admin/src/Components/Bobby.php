<?php

namespace TallAndSassy\PageGuideAdmin\Components;

use Livewire\Component;


/*
        [ ] Be sure to registrer this compoent in TallAndSassy/PageGuideServiceProvider.php
            Something like this in the function boot()...
                \Livewire\Livewire::component('tassy::livewire.bobby',  \TallAndSassy\PageGuide\Components\Bobby::class);

*/
class Bobby extends Component
{
    public string $sample_var = "defaultValue"; // {{$sample_var}} is now avail in your blade.

    // Other ways to invoke methods.... see: https://laravel-livewire.com/docs/2.x/events#from-js
    //      protected $listeners = ['someGlobalHandle_butActuallyForBobby' => 'doSuperIncrement'];
    //
    // From within the lw blade template (uncommon, probably would call wire:click="doSuperIncrement()")
    //      <button wire:click="$emit('someGlobalHandle_butActuallyForBobby'">
    // From within the lwController.php (uncommon, probably would call $this-doSuperIncrement()
    //      $this->emit('someGlobalHandle_butActuallyFor');
    // From another blade file in your app
    //      <script> Livewire.emit('someGlobalHandle_butActuallyForBobby') </script>
    //      Say, in help.blade.php, you have... You can have a button outside the lw blade template do stuff inside the template
    //      <div>
    //          <livewire:tassy::livewire.bobby/>
    //
    //          <button x-on:click="Livewire.emit('someGlobalHandle_butActuallyForBobby', '1000')"
    //                  class="pt-4 rounded shadow p-2 bg-green-400">
    //                  Click to Increment from outside the livewire blade
    //          </button>

    // You can invoke this function from _inside_, and only inside, the livewire blade template, like.. (see above for other options)
    //      <button wire:click="doSuperIncrement()" class="rounded shadow p-2 bg-red-400">Super Increment</button>
    // public function doSuperIncrement(int $amount = 100)
    // {
    //     $this->sample_var = $this->sample_var + $amount;
    // }


    // mount is like __construct.  (wip)
    // public function mount(int $newStart) {
    //      $this->sample_var = $newStart;
    // }

    public function render()
    {
        // access via:
        //      <livewire:tassy::livewire.bobby/>

        // Ex: Increment sample_var everytime this instance re-renders, like via: <div wire:poll.5s>
        //      $this->sample_var = $this->sample_var + 1;
        return view('tassy::livewire.bobby');
    }
}


