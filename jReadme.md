Motivation: The old tall and sassy was all over the place
so difficult to maintain since so distributed.
More importantly, difficult to refactor.
Trying to remerge and maybe get into a tight copy-able module
Try to keep it segregated and eventually move back into a package
and definitely to keep the core poking around a separate area of 
concern
============

app/Providers/RouteServiceProvider.php
    'str_replace("HOME = '/dashboard';", "HOME = '/me';", $file);

replace resources/view/auth,profile,team ????

/config (add)     ????
    /TallAndSassy/
        app-branding
        app-theme-base
        page-guide-admin
        app-theme-base-ui-glances-livewire-flash
        app-theme-base-ui-glances-tasuiglances

/routes/web (replace)
    [ ] replace whole file, just append include
        'require_once(__DIR__.'/../modules/TallAndSassy/page-guide/routes/web.php');')


composer.json
    [ ] add to psr4
        "TallAndSassy\\PageGuide\\": "modules/TallAndSassy/page-guide/src",
        "TallAndSassy\\PageGuideAdmin\\": "modules/TallAndSassy/page-guide-admin/src"
    [ ] composer require blade-ui-kit/blade-heroicons
    [ ] composer require blade-ui-kit/blade-zondicons
composer require barryvdh/laravel-debugbar --dev
                owenvoke/blade-fontawesome
config/app.php
    Add service provider...
        [ ] \TallAndSassy\PageGuide\PageGuideServiceProvider::class

public/img/logos
    
 (Copied in resources/viewslayouts/app.blade.php)
 from somewhere?

Get resource/public/css/app.css to work via webpack
    For each module, you need to make an entry mirroring whatever you do for app.css
