<?php

namespace TallAndSassy\PageGuideAdmin\Http\Controllers\Admin;

abstract class PageGuideFrontController_Base extends PageGuide_Controller_Base
{
    public const viewRef = "tassy::front/front_page_default";
    public function getFrontView(string $subLevels = '')
    {
        //        $subLevels = 'admin/'.$subLevels;
        //        $asrParams = static::subLevels2asrParams($subLevels);
        //        if (isset($asrParams['fetchy']) && $asrParams['fetchy'] == 1) {
        //            return static::getBodyView($subLevels);
        //        }
        //
        //        return view("tassy::front.__index_shell", ['viewRef' => static::viewRef,'asrParams' => $asrParams, 'ControllerName' => get_called_class(), 'controllerObj' => $this]);
        return static::getBodyView($subLevels);

    }

}
