<?php

namespace TallAndSassy\PageGuideAdmin\Http\Controllers\Admin;

class HelpController extends \TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideAdminController_Base
{
    public const viewRef = "tassy::admin/help/index";
    public static string $title = 'Help';
    public function getBodyView(string $subLevels) : \Illuminate\View\View
    {
        return view(static::viewRef);
    }
}
