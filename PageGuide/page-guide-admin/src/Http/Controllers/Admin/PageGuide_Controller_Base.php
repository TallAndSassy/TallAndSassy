<?php

namespace TallAndSassy\PageGuideAdmin\Http\Controllers\Admin;

abstract class PageGuide_Controller_Base extends \Illuminate\Routing\Controller
{
    //abstract public const viewRef = "tassy::admin/__body"; but 'abstract isn't a PHP thingy here

    public static function subLevels2asrParams($subLevels) : array
    {
        //fyi: explode('/','')) == [0=>'']
        $subLevels = trim($subLevels);
        $arrParams = explode('/', $subLevels);
        // handle degenerate
        if (empty($arrParams[0])) {
            array_shift($arrParams);
        }
        #$arrParams = (count($arrParams) == 1 && empty($arrParams[0])) ? [] : $arrParams;

        $asrParams = [];
        $numParams = count($arrParams);
        #dd($numParams);

        for ($i = 0; $i < $numParams; $i = $i + 2) {
            #dd($arrParams);

            #assert(isset($arrParams[$i + 1]), __FILE__.__LINE__."$subLevels arrParams must be key/value set at i($i) '".implode('-', $arrParams)."' count(numParams):".$numParams."vs ".$numParams);
            if ( isset($arrParams[$i+1])) {
                $asrParams[$arrParams[$i]] = $arrParams[$i + 1];
            } else {
                $asrParams[$arrParams[$i]] = null;
            }

        }


        return $asrParams;
    }

    // showAdminFronts is called by the routes/web.php
    abstract public function getFrontView(string $subLevels = '');
//    {
//        $subLevels = 'admin/'.$subLevels;
//        $asrParams = static::subLevels2asrParams($subLevels);
//        if (isset($asrParams['fetchy']) && $asrParams['fetchy'] == 1) {
//            return static::getBodyView($subLevels);
//        }
//
//        return view("tassy::admin.__index_shell", ['viewRef' => static::viewRef,'asrParams' => $asrParams, 'ControllerName' => get_called_class(), 'controllerObj' => $this]);
//        //            if ($isBodyOnly) {
//        //                return 'body from AdminController';
//        //    dd([__FILE__,__LINE__]);
//        //
//        //                return view("tassy::admin.__body", ['viewRef' => static::viewRef ,'asrParams' => $asrParams, 'ControllerName' => get_called_class(), 'controllerObj' => $this]);
//        //            } else {
//        //
//        //                return view("tassy::admin.__index_shell", ['viewRef' => static::viewRef,'asrParams' => $asrParams, 'ControllerName' => get_called_class(), 'controllerObj' => $this]);
//        //            }
//    }

    #abstract public function getBodyView(string $subLevels) :  \Illuminate\View\View;
    public function getBodyView(string $subLevels) : \Illuminate\View\View|string
    {
        // maybe this should be 5/21' static::getBodyView($sublevels)
        return view(static::viewRef);
    }

    //    public static function wireSwaplinkInA(string $url) // See LePage
}
