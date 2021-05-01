<?php

namespace TallAndSassy\PageGuide\Http\Livewire;

use Livewire\Component;

class DoModal extends Component
{
    public $text;
    public $modalUrl;
    public $modalTitle ='Default Title';
    protected $listeners=['modalUrl', 'modalTitle'];
    public function modalUrl($modalUrl) {
        $this->modalUrl = $modalUrl;
    }
    public function modalTitle($modalTitle) {
        $this->modalTitle = $modalTitle;
    }
    public function mount(string $text) {
        $this->text = $text;
    }
    public function render()
    {
        return view('tassy::livewire.do-modal');
    }
}
