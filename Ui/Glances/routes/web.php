<?php
use Illuminate\Support\Facades\Route;

use TallAndSassy\Ui\Glances\Samples;

if (config('tassy.ui-glances.DoSamples')) {
    Route::middleware(['auth:sanctum', 'verified'])
        ->get(
            '/admin/'.Samples\TabSample1__Page::getSlug().'/{sublevels?}',
            [Samples\TabSample1__Page::class, 'getFrontView'] // syntax works w/ use Statement
        )
        ->where('sublevels', '.*');

    Route::middleware(['auth:sanctum', 'verified'])
        ->get(
            '/admin/'.Samples\TechBase\Status__Page::getSlug().'/{sublevels?}',
            [Samples\TechBase\Status__Page::class, 'getFrontView'] // syntax works w/ use Statement
        )
        ->where('sublevels', '.*');
}
