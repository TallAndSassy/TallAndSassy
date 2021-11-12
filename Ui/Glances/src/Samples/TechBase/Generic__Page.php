<?php
declare(strict_types=1);
namespace TallAndSassy\Ui\Glances\Samples\TechBase;

WIP
use Illuminate\View\View;
use TallAndSassy\PageGuide\MenuTree;
use TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideAdminController_Base;

/* Motivation: Make simple admin pages w/o having to make a controller.  Good for mockup hosting and static-ish pages */
class Generic__Page extends PageGuideAdminController_Base
{
    #public const viewRef = "tassy::admin/bobtabs__";
    public static string $title = 'TmpUiGlance Tech Status';
    private static string $slug;
    public const viewRef = "tassy::admin/help/index";
    public function __construct(string $title, string $theSlug) {
        static::$title = $title;// this is problematic
        static::$slug = $theSlug;
    }

    public static function Init(): void {
    }

    // ---- Implement: SlugProducer --------------------------------------------------------------------------------
    public static function getSlug(): string {
       return static::$slug;
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
