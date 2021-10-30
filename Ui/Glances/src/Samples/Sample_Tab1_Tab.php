<?php

declare(strict_types=1);
namespace TallAndSassy\Ui\Glances\Samples;
use Livewire\Component;


class Sample_Tab1_Tab extends \TallAndSassy\Ui\Glances\Components\RemergeTab_ComponentBase
{

    public int $view_count = 0;
    public bool $localIsVisible = false;
    public function render()
    {
        $this->view_count++;

        return view('tassy-ui::samples/TabSamples/tab-first');
    }

}
