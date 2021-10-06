<?php

namespace TallAndSassy\PageGuide\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use TallAndSassy\PageGuide\Http\Controllers\MenuControllerHelper;
use TallAndSassy\Tenancy\TenantUtils;

class MenuControllerForUsers
{
    public static function boot() : array
    {
        $isLoggedIn = (Auth::user()) ? true : false;
        if ($isLoggedIn) {
            MenuControllerHelper::BuildMenus_forLoggedIn();
        } else {


            $tenantSlugOrNull = TenantUtils::GetTenantSlugElseNull();

            if (config('tassy.page-guide.canSelfRegister')) {
                if  ($tenantSlugOrNull  && $tenantSlugOrNull != env('HQ_SUBDOMAIN') ) {
                    \TallAndSassy\PageGuide\PageGuideMenuWranglerUser::wrangleMe(
                        "register",
                        [
                            'name' => "Create Account",
                            "url" => route('register'),
                            "classes" => "",
                            "routeIs" => "register*",
                        ]
                    );
                }
            }

            if ($tenantSlugOrNull) {
                \TallAndSassy\PageGuide\PageGuideMenuWranglerUser::wrangleMe(
                    "log-in",
                    [
                        'name' => "Log In",
                        "url" => route('login'),
                        "classes" => "",
                        "routeIs" => "login*",
                    ]
                );
            }
        }
        return \TallAndSassy\PageGuide\PageGuideMenuWranglerUser::wranglees();
    }
}
