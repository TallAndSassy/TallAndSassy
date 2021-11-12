<?php

Route::get(
    '/',
    function () {
        #\TallAndSassy\PageGuide\Http\Controllers\MenuController::boot();

        return view('tassy::front/index');
    }
)->name('tenant.home');;

Route::get('/admin', fn () => redirect('/admin/default'));

// =========================== Admin ===================================================================================
# works: Route::middleware(['auth:sanctum', 'verified'])->get('/admin/bob', fn () => 'hi');
# works Route::middleware(['auth:sanctum', 'verified'])->get('/admin/bob', function () { return 'bye';});
# works (but shows nothing, as expected) Route::middleware(['auth:sanctum', 'verified'])->get('/admin/bob', function (BobController $b) { return 'b';});

// =========================== Me ======================================================================================
Route::middleware(['auth:sanctum', 'verified'])->get(
    '/me',
    function () {
        #\TallAndSassy\PageGuide\Http\Controllers\MenuController::boot();

        return view('tassy::me/index');
    }
)->name('me');

