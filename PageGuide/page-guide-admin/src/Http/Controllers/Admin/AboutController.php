<?php

namespace TallAndSassy\PageGuideAdmin\Http\Controllers\Admin;

class AboutController extends \TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideAdminController_Base
{
    public const viewRef = "tassy::admin/about/index";
    public static string $title = 'About';
//    public function getBodyView(string $subLevels) : \Illuminate\View\View
//    {
//        return view(static::viewRef);
//    }
}
