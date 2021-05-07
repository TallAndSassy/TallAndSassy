<?php

namespace TallAndSassy\PageGuideAdmin\Http\Controllers;

use TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideAdminController_Base;

class Bob_outputByBlade_Controller extends PageGuideAdminController_Base
{
    public const viewRef = "tassy::admin/bob_outputByBlade";
    public static string $title = 'Bob > Blade';

    public function getBodyView(string $subLevels) : \Illuminate\View\View
    {
        return view(static::viewRef, ['LastName' => "Deis2"]);
    }
}
