<?php

namespace TallAndSassy\PageGuideAdmin\Http\Controllers\Admin;

class MediaController extends \TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideAdminController_Base
{
    public const viewRef = "tassy::admin/media/index";
    public static string $title = 'Media';
    //    public function getBodyView(string $subLevels) : \Illuminate\View\View
    //    {
    //        return view(static::viewRef);
    //    }
}
