<div src="vendor/tallandsassy/page-guide/resources/views/admin/menu.blade.php">
    @php
    // WARNING: THIS IS THE TOP MENU... MENUTREE is the SIDE MENU
        // =========================== Boot Stuff  =============================================================================
        /*  Build back-end menu entries
           This should almost definitely live somewhere else
        Q: Why is this here?
        A: Althought I'm sure there is a better place for it, LePage.blade.php includes it, and when the body was
            updated, it was getting re-generated. Now, that would be a problem, but the logic that looks at front vs.
            back depends upon the the url, which was no longer relevant. Ugh.
            So, we ended up just telling lepage.blade.php (which is ALWAYS just for admin) to include the admin
            version of this menu.  It is not ideal, but good enough for now.

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

        \TallAndSassy\PageGuide\PageGuideMenuWranglerBack::wrangleMe(
           "admin",
           [
               'name' => __('tassy::PageGuide.AdminLinkText'),
               "url" => "/admin",
               "classes" => "",
               "routeIs" => fn () => 1,
           ]
        );

        \TallAndSassy\PageGuide\PageGuideMenuWranglerBack::wrangleMe(
           "me",
           [
               'name' => __('tassy::PageGuide.MeLinkText'),
               "url" => "/me",
               "classes" => "",
               "routeIs" => fn () => 0,

           ]
        );

    @endphp
    <x-tassy::header.back.menu class="lg:pt-1 "/>
</div>
