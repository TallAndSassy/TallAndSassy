<?php

namespace TallAndSassy\Ui\Glances\Components;
use Livewire\Component;
trait RemergeTab_Implementation {
    public bool $contentIsVisible = false;
    public string $tabName;

    public function mount_RemergeTab_Implementation(string $tabName) {
        $this->tabName = $tabName;
        //$this->listeners['iSeeTab'] =  'maybeShowContent';
    }
    public function maybeShowContent(string $tabName): void {
        if ($tabName == $this->tabName) {
            $this->nowShowContent();
        }

    }
    public function nowShowContent(): void {
        $this->contentIsVisible = true;
    }
}

class RemergeTab_ComponentBase  extends Component {
    use RemergeTab_Implementation;
    protected $listeners = ['iSeeTab' => 'maybeShowContent'];

}
