<?php

// Tip: You usually need to run  php artisan config:clear after making changes during development
return [
    // --- Quick pages (look in resources/views/vendor/tassy/admin to customize)
    'DoSamples' => false,
    'DoSamples_Side_Blade' => false, //// show how to do custom menu entries on the admin's side menu
    'DoAbout' => false,
    'DoConfig' => false,
    'DoSampleDashboard' => false,
    'DoHelp' => false,

    // ----
    'DefaultSubSlug' => 'config',
    'DoAjaxAdminPages' => true,

    // --- Future 'DoSampleLibraryMaybePremature' => false,
    
];
