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
            '/admin/samples/hello_world',
            fn() => 'hello world. (as string from inside tallandsassy/Ui/Glances/routes/web.php) Hit you browser\s back button.'
        )
        ->where('sublevels', '.*');

    Route::middleware(['auth:sanctum', 'verified'])
        ->get(
            '/admin/'.Samples\TechBase\Status__Page::getSlug().'/{sublevels?}',
            [Samples\TechBase\Status__Page::class, 'getFrontView'] // syntax works w/ use Statement
        )
        ->where('sublevels', '.*');
    Route::middleware(['auth:sanctum', 'verified'])
        ->get(
            '/admin/samples/uisamples',
            [Samples\TechBase\UiSampleController::class, 'getFrontView']
            //fn() => (new Samples\TechBase\Generic__Page('Temp Samples', 'uisamples'))->getFrontView()
            //fn()=> view('tassy-ui::samples/UI/UISample__Page', [ ])
        );

    Route::middleware(['auth:sanctum', 'verified'])
        ->get(
            '/admin/'.Samples\TabSample0__Page::getSlug().'/{sublevels?}',
            [Samples\TabSample0__Page::class, 'getFrontView'] // syntax works w/ use Statement
        )
        ->where('sublevels', '.*');

    Route::middleware(['auth:sanctum', 'verified'])
        ->get(
            '/admin/blah/{sublevels?}',
            fn() => (new Samples\TechBase\Generic__Page())->getFrontView(),
        )
        ->where('sublevels', '.*');

    Route::middleware(['auth:sanctum', 'verified'])
        ->get(
            '/admin/GrokModalLepage/{sublevels?}',
            fn() => 'hello'
            //fn() => (new Samples\Modals\GrokModalLepage())->getFrontView(),
        )
        ->where('sublevels', '.*');


        Route::get(
            '/admin/tassy/samples/code',
            [Samples\Code\CodeHomeTabbedPageController::class, 'getFrontView']
        );

        //-------- Level 2 --------
    Route::get(
        '/admin/tassy/level2/tabs',
        [Samples\Level2\TabsController::class, 'getFrontView']
    );


}
