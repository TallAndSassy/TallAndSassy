<?php


namespace TallAndSassy\PageGuide;

abstract class PageGuideAdminWrangler extends \TallAndSassy\PageGuide\RenderWrangler
{
    public static function getKeyFromUrl(): string
    {
        $url = app('request')->url(); # "http://test-jet.test/p1/p2/p3"
        $arrUrl = explode('/', $url);

        $p1 = $arrUrl[4] ?: '';
        $p2 = $arrUrl[5] ?: '';
        $key = "{$p1}_{$p2}";

        return $key;
    }

    /* all top menu items are keyed by first two params. Empty string if no param present */
    public static function getActiveKey(): ?string
    {
        if (static::keyExits(static::getKeyFromUrl())) {
            return $p2;
        } else {
            return null;
        }
    }
}
