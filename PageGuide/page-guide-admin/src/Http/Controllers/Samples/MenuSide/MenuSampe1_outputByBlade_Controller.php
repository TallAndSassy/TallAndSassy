<?php

namespace TallAndSassy\PageGuideAdmin\Http\Controllers\Samples\MenuSide;

use TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideAdminController_Base;

class MenuSampe1_outputByBlade_Controller extends PageGuideAdminController_Base
{
    public const viewRef = "tassy::admin/sample__body";
    public static string $title = 'Menu sample 1';

    public function getBodyView(string $subLevels) : \Illuminate\View\View
    {
        return view(static::viewRef);
    }
}
