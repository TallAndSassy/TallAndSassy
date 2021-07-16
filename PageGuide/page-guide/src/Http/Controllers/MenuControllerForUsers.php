<?php

namespace TallAndSassy\PageGuide\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use TallAndSassy\PageGuide\Http\Controllers\MenuControllerHelper;

class MenuControllerForUsers
{
    public static function boot() : array
    {
        $isLoggedIn = (Auth::user()) ? true : false;
        if ($isLoggedIn) {
            MenuControllerHelper::BuildMenus_forLoggedIn();
        } else {


            if (config('tassy.page-guide.canSelfRegister')) {
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
        return \TallAndSassy\PageGuide\PageGuideMenuWranglerUser::wranglees();
    }
}
