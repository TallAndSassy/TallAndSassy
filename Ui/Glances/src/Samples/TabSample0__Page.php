<?php
declare(strict_types=1);
namespace TallAndSassy\Ui\Glances\Samples;

use Illuminate\View\View;
use TallAndSassy\PageGuide\MenuTree;
use TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideAdminController_Base;

final class TabSample0__Page extends PageGuideAdminController_Base{
    public static function Init(): void {
        // add menu item
        MenuTree::singleton('upper')->pushTop(
            'admin.tassy-ui.TabSample0',
            'TabSample0',
            null,
            'heroicon-o-question-mark-circle',
            '/admin/'.self::getSlug()
        );
    }
    public static string $title = 'TabSample0';

    // ---- Implement: SlugProducer --------------------------------------------------------------------------------
    public static function getSlug(): string {
        return 'TabSample0';
    }

    // ---- Implement: ThisViewProducer --------------------------------------------------------------------------------
    public  function getThisView(): View
    {
        return view('tassy-ui::samples/TabSamples/TabSample0__Page', [ ]);
    }

    public function getBodyView(string $subLevels) : \Illuminate\View\View
    {
        return $this->getThisView();
    }
}

