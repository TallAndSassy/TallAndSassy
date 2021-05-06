<?php

Route::get('/admin', fn() => redirect('/admin/'.config('tassy.admin.DefaultSubSlug')));



Route::middleware(['auth:sanctum', 'verified'])
    ->get(
        '/admin/dashboard/{sublevels?}',
        [
            \TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\DashboardController::class,
            'getFrontView'
        ] // syntax works
    )
    ->where('sublevels', '.*');

Route::middleware(['auth:sanctum', 'verified'])
    ->get(
        '/admin/help/{sublevels?}',
        [\TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\HelpController::class, 'getFrontView']
    )
    ->where('sublevels', '.*');


Route::middleware(['auth:sanctum', 'verified'])->get(
    '/admin/about/{sublevels?}',
    [\TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\AboutController::class, 'getFrontView'] // syntax works
)->name('admin/about');


Route::middleware(['auth:sanctum', 'verified'])->get(
    '/admin/config/{sublevels?}',
    [\TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\ConfigController::class, 'getFrontView']
)->name('admin/config');


if (config('tassy.admin.DoSamples')) {
    Route::middleware(['auth:sanctum', 'verified'])
        #->get('/admin/bob/{sublevels?}', 'TallAndSassy\PageGuide\Http\Controllers\Admin\BobController@getFrontView') // syntax works
        ->get(
            '/admin/bob/{sublevels?}',
            //[\TallAndSassy\PageGuide\Http\Controllers\Admin\BobController::class, 'getFrontView'] // syntax works
            [\TallAndSassy\PageGuideAdmin\Http\Controllers\BobController::class, 'getFrontView'] // syntax works w/ use Statement
        )
        ->where('sublevels', '.*');
}
