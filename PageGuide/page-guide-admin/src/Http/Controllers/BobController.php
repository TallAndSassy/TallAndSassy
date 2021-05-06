<?php

namespace TallAndSassy\PageGuideAdmin\Http\Controllers;

use TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideAdminController_Base;

class BobController extends PageGuideAdminController_Base
{
    public const viewRef = "tassy::admin/bob";
    public static string $title = 'Bob';
    public function getBodyView(string $subLevels) : \Illuminate\View\View
    {
        return view(static::viewRef, ['LastName' => "Deis2"]);
    }
}
