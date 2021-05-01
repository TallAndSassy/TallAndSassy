<?php

namespace TallAndSassy\PageGuideAdmin\Http\Controllers\Admin;

class ConfigController extends \TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideAdminController_Base
{
    public const viewRef = "tassy::admin/config/index";
    public static string $title = 'Config';
    //    public function getBodyView(string $subLevels) : \Illuminate\View\View
    //    {
    //        return view(static::viewRef);
    //    }
}
