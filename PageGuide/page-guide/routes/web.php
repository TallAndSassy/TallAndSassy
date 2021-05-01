<?php

// Front


Route::get(
    '/',
    function () {
        \TallAndSassy\PageGuide\Http\Controllers\Front\MenuController::boot();

        return view('tassy::front/index');
    }
);

Route::get('/admin', fn () => redirect('/admin/default'));

// =========================== Admin ===================================================================================
# works: Route::middleware(['auth:sanctum', 'verified'])->get('/admin/bob', fn () => 'hi');
# works Route::middleware(['auth:sanctum', 'verified'])->get('/admin/bob', function () { return 'bye';});
# works (but shows nothing, as expected) Route::middleware(['auth:sanctum', 'verified'])->get('/admin/bob', function (BobController $b) { return 'b';});
Route::middleware(['auth:sanctum', 'verified'])
    #->get('/admin/bob/{sublevels?}', 'TallAndSassy\PageGuide\Http\Controllers\Admin\BobController@getFrontView') // syntax works
    ->get(
        '/admin/bob/{sublevels?}',
        //[\TallAndSassy\PageGuide\Http\Controllers\Admin\BobController::class, 'getFrontView'] // syntax works
        [\TallAndSassy\PageGuideAdmin\Http\Controllers\BobController::class, 'getFrontView'] // syntax works w/ use Statement
    )
    ->where('sublevels', '.*');



// -- WARNING -- These routes are matching before page-guide-admin routes match
if (0) {
    Route::middleware(['auth:sanctum', 'verified'])->get(
        '/admin/{sublevels?}',
        function (\TallAndSassy\PageGuide\Http\Controllers\Admin\AdminController $AdminController, string $sublevels) {
            \TallAndSassy\PageGuide\Http\Controllers\Admin\MenuController::boot(); //10/22 no-op
            #dd($AdminController);

            return $AdminController->showAdminFronts($sublevels);
        }
    )->name('admin');
}

// =========================== Me ======================================================================================
Route::middleware(['auth:sanctum', 'verified'])->get(
    '/me',
    function () {
        \TallAndSassy\PageGuide\Http\Controllers\Me\MenuController::boot();

        return view('tassy::me/index');
    }
)->name('me');



//// =========================== Boot Stuff  =============================================================================
///*  Build back-end menu entries
//    This should almost definitely live somewhere else
//*/
//$isBackPage = \TallAndSassy\PageGuide\Http\Controllers\PageGuideController::isABackPage();
//if ($isBackPage) {
//    \TallAndSassy\PageGuide\PageGuideMenuWranglerBack::wrangleMe(
//        "home",
//        [
//            'name' => __('tassy::PageGuide.FrontLinkText'),
//            "url" => "/",
//            "classes" => "",
//            "routeIs" => fn () => \TallAndSassy\PageGuide\Http\Controllers\PageGuideController::isAFrontPage(),
//        ]
//    );
//
//    \TallAndSassy\PageGuide\PageGuideMenuWranglerBack::wrangleMe(
//        "admin",
//        [
//            'name' => __('tassy::PageGuide.AdminLinkText'),
//            "url" => "/admin",
//            "classes" => "",
//            "routeIs" => fn () => \TallAndSassy\PageGuide\Http\Controllers\PageGuideController::isAnAdminPage(),
//        ]
//    );
//
//    \TallAndSassy\PageGuide\PageGuideMenuWranglerBack::wrangleMe(
//        "me",
//        [
//            'name' => __('tassy::PageGuide.MeLinkText'),
//            "url" => "/me",
//            "classes" => "",
//            "routeIs" => fn () => \TallAndSassy\PageGuide\Http\Controllers\PageGuideController::isAMePage(),
//
//        ]
//    );
//}
