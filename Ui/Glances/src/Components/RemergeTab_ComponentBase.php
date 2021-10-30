<?php

namespace TallAndSassy\Ui\Glances\Components;
use Livewire\Component;
trait RemergeTab_Implementation {
    
    public string $tabName;
    public string $tabSlug;
    public string $enumRenderState_Placeheld_Rendered = 'Placeheld';

    public function mount_RemergeTab_Implementation(string $tabName, string $tabSlug) {
        $this->tabName = $tabName;
        $this->tabSlug = $tabSlug;
        //$this->listeners['iSeeTab'] =  'maybeShowContent';
    }
    public function maybeShowContent(string $tabSlug): void {
        if ($tabSlug == $this->tabSlug) {
            if ($this->enumRenderState_Placeheld_Rendered == 'Placeheld') {
                
                $this->enumRenderState_Placeheld_Rendered = 'Rendered';
            } elseif ($this->enumRenderState_Placeheld_Rendered == 'Rendered') {
                $this->skipRender();
            } else {
                assert(0,$this->enumRenderState_Placeheld_Rendered. ' is bonkers');
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
