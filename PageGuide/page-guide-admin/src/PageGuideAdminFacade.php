<?php

namespace TallAndSassy\PageGuideAdmin;

use Illuminate\Support\Facades\Facade;

/**
 *
 */
class PageGuideAdminFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'page-guide-admin';
    }
}
