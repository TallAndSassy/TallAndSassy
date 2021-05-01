<?php

namespace TallAndSassy\PageGuideAdmin;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TallAndSassy\PageGuideAdmin\PageGuideAdminController
 */
class PageGuideAdminFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'page-guide-admin';
    }
}
