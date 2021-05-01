<?php

namespace TallAndSassy\PageGuide;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TallAndSassy\PageGuide\PageGuide
 */
class PageGuideFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'page-guide';
    }
}
