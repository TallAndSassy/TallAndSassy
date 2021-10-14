<?php

namespace TallAndSassy\PageGuideAdmin\Http\Controllers\Admin;

abstract class PageGuideAdminController_Base extends PageGuide_Controller_Base
{
    public const viewRef = "tassy::admin/__body"; // Definitely override me
    public function getFrontView(string $subLevels = '')
    {
        $subLevels = 'admin/'.$subLevels;
        $asrParams = static::subLevels2asrParams($subLevels);
        if (isset($asrParams['fetchy']) && $asrParams['fetchy'] == 1) {
            return static::getBodyView($subLevels);
        }

        return view("tassy::admin.__index_shell", ['viewRef' => static::viewRef,'asrParams' => $asrParams, 'ControllerName' => get_called_class(), 'controllerObj' => $this]);
        //            if ($isBodyOnly) {
        //                return 'body from AdminController';
        //    dd([__FILE__,__LINE__]);
        //
        //                return view("tassy::admin.__body", ['viewRef' => static::viewRef ,'asrParams' => $asrParams, 'ControllerName' => get_called_class(), 'controllerObj' => $this]);
        //            } else {
        //
        //                return view("tassy::admin.__index_shell", ['viewRef' => static::viewRef,'asrParams' => $asrParams, 'ControllerName' => get_called_class(), 'controllerObj' => $this]);
        //            }
    }
}
