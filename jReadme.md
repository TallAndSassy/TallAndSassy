Motivation: The old tall and sassy was all over the place
so difficult to maintain since so distributed.
More importantly, difficult to refactor.
Trying to remerge and maybe get into a tight copy-able module
Try to keep it segregated and eventually move back into a package
and definitely to keep the core poking around a separate area of 
concern
============
[ ] Install this into /modules
    mkdir modules
    git clone https://github.com/TallAndSassy/TallAndSassy.git modules

composer.json
    [ ] add to psr4
        "TallAndSassy\\PageGuide\\": "modules/TallAndSassy/PageGuide/page-guide/src",
        "TallAndSassy\\PageGuideAdmin\\": "modules/TallAndSassy/PageGuide/page-guide-admin/src"
    [ ] composer require blade-ui-kit/blade-heroicons
    [ ] composer require blade-ui-kit/blade-zondicons
    [ ] composer require owenvoke/blade-fontawesome

    ( ) composer require barryvdh/laravel-debugbar --dev

composer dump-autoload

config/app.php
    Add service provider...
    [ ] \TallAndSassy\PageGuide\PageGuideServiceProvider::class

// Change default home page
app/Providers/RouteServiceProvider.php
    'str_replace("HOME = '/dashboard';", "HOME = '/me';", $file);
        (this might be better: https://laravel-news.com/override-login-redirects-in-jetstream-fortify)

replace resources/view/auth,profile,team ????
    mkdir resources/views/jorig
    mv resources/views/auth resources/views/jorig
    mv resources/views/profile resources/views/jorig
    mv resources/views/teams resources/views/jorig

    cp -r modules/TallAndSassy/PageGuide/page-guide/resources/views/auth resources/views
    cp -r modules/TallAndSassy/PageGuide/page-guide/resources/views/profile resources/views
    cp -r modules/TallAndSassy/PageGuide/page-guide/resources/views/teams resources/views

    cp modules/TallAndSassy/PageGuide/page-guide/resources/views/layouts/app.blade.php resources/views/layouts

/config (add)     ????
    cp -r modules/TallAndSassy/PageGuide/page-guide/config config
    (maybe tweak stuff)

/routes/web (replace)
    [ ] replace whole file, just append include
        require_once(__DIR__ . '/../modules/TallAndSassy/PageGuide/page-guide/routes/web.php');
        require_once(__DIR__ . '/../modules/TallAndSassy/PageGuide/page-guide-admin/routes/web.php');

public/img/logos
    cp -r modules/TallAndSassy/PageGuide/page-guide/resources/public/img resources/img

Get resource/public/css/app.css to work via webpack
    For each sub-module, you need to make an entry mirroring whatever you do for app.css
    Like:
        .postCss('modules/TallAndSassy/PageGuide/page-guide/resources/public/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        ])
        .postCss('modules/TallAndSassy/PageGuide/page-guide-admin/resources/public/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        ])


