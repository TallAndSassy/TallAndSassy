<?php
declare(strict_types=1);
namespace TallAndSassy\PageGuideAdmin\Http\Controllers;

use TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideAdminController_Base;

class Bob_outputByReturnedString_Controller extends PageGuideAdminController_Base
{
    public static string $title = 'Bob String';
    public function getBodyView(string $subLevels) : \Illuminate\View\View|string
    {
        return 'Body of '.get_called_class().'. A simple string returned from '.__METHOD__;

    }
}
