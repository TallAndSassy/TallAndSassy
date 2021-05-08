<?php
declare(strict_types=1);
namespace TallAndSassy\Ui\Glances\Samples;

use Illuminate\View\View;
use TallAndSassy\PageGuide\MenuTree;
use TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideAdminController_Base;

final class TabSample1__Page extends PageGuideAdminController_Base{
    public static function Init(): void {
        // add menu item
        MenuTree::singleton('upper')->pushTop(
            'admin.tassy-ui.TabSample1',
            'TabSample1',
            null,
            'heroicon-o-question-mark-circle',
            '/admin/'.self::getSlug()
        );

        // register my controllers (only needed if not (if controller is sitting in the module) in the main app)
        \Livewire\Livewire::component('tassy-ui:Sample_Tab1_Tab',  Sample_Tab1_Tab::class);
        \Livewire\Livewire::component('tassy-ui:Sample_Tab2_Tab',  Sample_Tab2_Tab::class);
    }
    public static string $title = 'TabSample1';

    // ---- Implement: SlugProducer --------------------------------------------------------------------------------
    public static function getSlug(): string {
        return 'TabSample1';
    }

    // ---- Implement: ThisViewProducer --------------------------------------------------------------------------------
    public  function getThisView(): View
    {
        return view('tassy-ui::samples/TabSamples/TabSample1__Page', [ ]);
    }

    public function getBodyView(string $subLevels) : \Illuminate\View\View|string
    {
        return $this->getThisView();
    }
}

