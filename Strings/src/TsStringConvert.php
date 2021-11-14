<?php
declare(strict_types=1);


namespace TallAndSassy\Strings;

use Illuminate\Support\Str;

class TsStringConvert {
    /*
     * History: copied from EtStringConvert
     */
    public static function pure2url(string $pure) : string {
        return urlencode($pure);
    }
    public static function pure2htmlAttribute(string $pure) : string {
        return urlencode($pure);
    }
    /* Decode with (php) static::htmlAttribute_playsWithJavascript2pure or in .js  decodeURIComponent //https://stackoverflow.com/a/5952090
     * Motivation: If javascript (like alpine) needs to grab the value, then you can't use php's urlencode cuz it isn't compatible
     * with javascript's decodeURIComponent
     *
     */
    public static function pure2htmlAttribute_playsWithJavascript(string $pure) : string {
        return rawUrlEncode($pure);
    }
    /* compatible (can roundtrip with) with javascript 'decodeURIComponent(blah)'
    */
    public static function htmlAttribute_playsWithJavascript2pure(string $pure) : string {
        return rawUrlDecode($pure);
    }
    public static function pure2htmlAttribute2(string $pure) : string {
        return addslashes(htmlentities($pure));
    }
    public static function htmlAttribute2pure(string $pure) : string {
        return urldecode($pure);
    }

    /* @returns: string compatible with livewire attributes
     * <livewire:ReplaceableView_htmlAttributeCompatible :tabName="'ReplaceableString_shortNodeName'" :tabSlug="'ReplaceableString_shortNodeName'"/>
     * */
    public static function viewPath2htmlAttribute_playsWithLivewire(string $pureViewPath): string {
        $pureViewPath = str_replace('/','.',$pureViewPath);
        // want horns.experiment1636900535-livetroller  horns.-experiment1636900535-livetroller vs.
        $pureViewPath = Str::kebab($pureViewPath);
        $pureViewPath = str_replace('.-','.',$pureViewPath);
        return $pureViewPath;
    }


}
