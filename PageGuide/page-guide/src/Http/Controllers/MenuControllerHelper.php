<?php
declare(strict_types=1);


namespace TallAndSassy\PageGuide\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class MenuControllerHelper {
    public static function BuildMenus_forLoggedIn(): void {
        $isLoggedIn = true;
        $isWebmaster = $isLoggedIn && Auth::user()->can(\TallAndSassy\RolesAndPermissions\BaseTassyPermissions::ACCESS_ADMIN_TOOLS);

        \TallAndSassy\PageGuide\PageGuideMenuWranglerUser::wrangleMe(
            "hom",
            [
                'name' => 'Home',
                "url" => "/",
                "classes" => "",
                "routeIs" => "/",
            ]
        );
        // --- Super Admin Menu Item
        if (Auth::user()->hasRole('superuser')) {
            \TallAndSassy\PageGuide\PageGuideMenuWranglerUser::wrangleMe(
                "superadmin",
                [
                    'name' => "SuperAdmin",
                    "url" => route('superadmin'),
                    "classes" => "",
                    "routeIs" => "superadmin*",
                ]
            );
        }


        if ($isWebmaster){
            \TallAndSassy\PageGuide\PageGuideMenuWranglerUser::wrangleMe(
                "admin",
                [
                    'name' => __('tassy::PageGuide.AdminLinkText'),
                    "url" => "/admin",
                    "classes" => "",
                    "routeIs" => "admin*",
                ]
            );
        }

        \TallAndSassy\PageGuide\PageGuideMenuWranglerUser::wrangleMe(
            "me",
            [
                'name' => __('tassy::PageGuide.MeLinkText'),
                "url" => "/me",
                "classes" => "",
                "routeIs" => "me*",
            ]
        );

    }
}
