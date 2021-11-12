<?php

namespace TallAndSassy\Ui\Glances\Samples\TechBase;

class UiSampleController extends \TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideAdminController_Base
{
    public const viewRef = "tassy-ui::samples/UI/UISample__Page";
    public static string $title = 'UI Sample';
    public function getBodyView(string $subLevels) : \Illuminate\View\View
    {
        $asr = static::subLevels2asrParams($subLevels);
        return view(static::viewRef);
    }
}
