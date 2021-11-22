<?php

namespace TallAndSassy\Ui\Glances\Components;
use Livewire\Component;


trait RemergeTab_Implementation {
    
    public string $tabName;
    public string $tabSlug;
    
    public string $snumRenderState = 'Placeheld';

    public function mount_RemergeTab_Implementation(string $tabName, string $tabSlug) {
        $this->tabName = $tabName;
        $this->tabSlug = $tabSlug;
    }
    public function maybeShowContent(string $tabSlug): void {
        if ($tabSlug == $this->tabSlug) { //Q: I see "RemergeTab_ComponentBase::$tabSlug must not be accessed before initialization" here A: Make sure you have the tabSlug attribute set, like:  <livewire:tassy-ui:Sample_Tab1_Tab :tabName="'First'" :tabSlug="'first'"/>
            if ($this->snumRenderState == enumRenderState::PLACEHELD->value) {
                
                $this->snumRenderState = enumRenderState::RENDERED->value;
                $this->dispatchBrowserEvent('snumRenderStateChanged');
                #ddd(__FILE__,__LINE__);
            } elseif ($this->snumRenderState == enumRenderState::RENDERED->value) {
                $this->skipRender();
            } else {
                assert(0,$this->snumRenderState. ' is bonkers');
            }
        } else {
            $this->skipRender();
        }


    }
   
}

class RemergeTab_ComponentBase  extends Component {
    use RemergeTab_Implementation;
    protected $listeners = ['iSeeTab' => 'maybeShowContent'];

}
