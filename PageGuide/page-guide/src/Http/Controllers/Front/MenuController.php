<?php

namespace TallAndSassy\PageGuide\Http\Controllers\Front;

use Illuminate\Support\Facades\Auth;

class MenuController
{
    public static function boot()
    {
        $isLoggedIn = (Auth::user()) ? true : false;
        $isWebmaster = $isLoggedIn && Auth::user()->can(\TallAndSassy\RolesAndPermissions\BaseTassyPermissions::ACCESS_ADMIN_TOOLS);
        if ($isLoggedIn) {
//            dd(Auth::user());
            if ($isWebmaster){
                \TallAndSassy\PageGuide\PageGuideMenuWranglerFront::wrangleMe(
                    "admin",
                    [
                        'name' => __('tassy::PageGuide.AdminLinkText'),
                        "url" => "/admin",
                        "classes" => "",
                        "routeIs" => "admin*",
                    ]
                );
            }

            \TallAndSassy\PageGuide\PageGuideMenuWranglerFront::wrangleMe(
                "me",
                [
                    'name' => __('tassy::PageGuide.MeLinkText'),
                    "url" => "/me",
                    "classes" => "",
                    "routeIs" => "me*",
                ]
            );

            // Doesn't seem to show up, not sure why - oh well 5/21'
            // But we really do want the top nav for front and my pages to be the same
//            \TallAndSassy\PageGuide\PageGuideMenuWranglerBack::wrangleMe(
//                "admin",
//                [
//                    'name' => __('tassy::PageGuide.AdminLinkText'),
//                    "url" => "/admin",
//                    "classes" => "",
//                    "routeIs" => fn () => 0,
//                ]
//            );


            // FYI: 10/20' -

        //            \TallAndSassy\PageGuide\PageGuideMenuWranglerFront::wrangleMe(
            //                "log-out",
            //                [
            //                    'name' => "Log Out",
            //                    "url" => route('logout'),
            //                    "classes" => "",
            //                    "routeIs" => "logout*"
            //                ]
            //            );
        } else {
            \TallAndSassy\PageGuide\PageGuideMenuWranglerFront::wrangleMe(
                "log-in",
                [
                    'name' => "Log In",
                    "url" => route('login'),
                    "classes" => "",
                    "routeIs" => "login*",
                ]
            );

            if (config('page-guide.canSelfRegister')) {
                \TallAndSassy\PageGuide\PageGuideMenuWranglerFront::wrangleMe(
                    "register",
                    [
                        'name' => "Register",
                        "url" => route('register'),
                        "classes" => "",
                        "routeIs" => "register*",
                    ]
                );
            }
        }
    }
}
