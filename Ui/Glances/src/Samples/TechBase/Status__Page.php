<?php
declare(strict_types=1);
namespace TallAndSassy\Ui\Glances\Samples\TechBase;

use Illuminate\View\View;
use TallAndSassy\PageGuide\MenuTree;
use TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideAdminController_Base;

class Status__Page extends PageGuideAdminController_Base
{
    #public const viewRef = "tassy::admin/bobtabs__";
    public static string $title = 'TmpUiGlance Tech Status';
    public function __construct() {
    }

    public static function Init(): void {
//        MenuTree::singleton('upper')->pushTop(
//            'admin.tassy-ui.TechWorks',
//            'TmpGUi Tech',
//            null,
//            'heroicon-o-question-mark-circle',
//            '/admin/'.self::getSlug()
//        );
    }

    // ---- Implement: SlugProducer --------------------------------------------------------------------------------
    public static function getSlug(): string {
        return 'uig_tech_status';
    }

    // ---- Implement: ThisHtmlProducer --------------------------------------------------------------------------------
    public function getThisHtml(): string
    {
        return static::getThisView()->render();
    }


    // ---- Implement: ThisViewProducer --------------------------------------------------------------------------------
    public function getBodyView(string $subLevels) : \Illuminate\View\View|string
    {
        return $this->getThisView();
    }

    public  function getThisView(): View
    {
        return view('tassy-ui::samples/TechBase/Status__', [
            'parentSlug'=>static::getSlug(),
        ]);
    }
}
