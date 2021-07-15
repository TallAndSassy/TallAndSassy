<div>
    @php
        // =========================== Boot Stuff  =============================================================================
        /*  Build back-end menu entries
           This should almost definitely live somewhere else

            2021-07-14 Gavin: Yes. Yes it should.
        */
        \TallAndSassy\PageGuide\PageGuideMenuWranglerBack::wrangleMe(
           "home",
           [
               'name' => __('tassy::PageGuide.FrontLinkText'),
               "url" => "/",
               "classes" => "",
               "routeIs" => fn () => 0,
           ]
        );

        $isLoggedIn = (Auth::user()) ? true : false;
        $isWebmaster = $isLoggedIn && Auth::user()->can(\TallAndSassy\RolesAndPermissions\BaseTassyPermissions::ACCESS_ADMIN_TOOLS);
        if ($isLoggedIn) {
            if ($isWebmaster){
                \TallAndSassy\PageGuide\PageGuideMenuWranglerBack::wrangleMe(
                   "admin",
                   [
                       'name' => __('tassy::PageGuide.AdminLinkText'),
                       "url" => "/admin",
                       "classes" => "",
                       "routeIs" => fn () => 0,
                   ]
                );
            }
        }


        \TallAndSassy\PageGuide\PageGuideMenuWranglerBack::wrangleMe(
           "me",
           [
               'name' => __('tassy::PageGuide.MeLinkText'),
               "url" => "/me",
               "classes" => "",
               "routeIs" => fn () => \TallAndSassy\PageGuide\Http\Controllers\PageGuideController::isAMePage(),

           ]
        );

    @endphp
    <x-tassy::header.back.menu class="lg:pt-1"/>
</div>
