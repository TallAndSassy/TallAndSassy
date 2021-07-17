Motivation: The old tall and sassy was all over the place
so difficult to maintain since so distributed.
More importantly, difficult to refactor.
Trying to remerge and maybe get into a tight copy-able module
Try to keep it segregated and eventually move back into a package
and definitely to keep the core poking around a separate area of 
concern
============
[ ] Install this into /submodules
    -- In Sourtree
        Add, as a submodule https://github.com/TallAndSassy/TallAndSassy to 'submodules/TallAndSassy' on 'main' branch
    -- OR (manually) --
        mkdir submodules
        git clone https://github.com/TallAndSassy/TallAndSassy.git modules


composer.json
    [ ] add to psr4
        "TallAndSassy\\PageGuide\\": "submodules/TallAndSassy/PageGuide/page-guide/src",
        "TallAndSassy\\PageGuideAdmin\\": "submodules/TallAndSassy/PageGuide/page-guide-admin/src",
        "TallAndSassy\\Ui\\Glances\\": "submodules/TallAndSassy/Ui/Glances/src",
        "TallAndSassy\\Strings\\": "submodules/TallAndSassy/Strings/src",
        "TallAndSassy\\RolesAndPermissions\\": "submodules/TallAndSassy/RolesAndPermissions/src",
        "TallAndSassy\\Tenancy\\": "submodules/TallAndSassy/Tenancy/src"
        ...
    [ ] composer require blade-ui-kit/blade-heroicons
    [ ] composer require blade-ui-kit/blade-zondicons
    [ ] composer require owenvoke/blade-fontawesome

    ( ) composer require barryvdh/laravel-debugbar --dev

composer dump-autoload

config/app.php
    Add service provider...
        // --- Tall And Sassy
        \TallAndSassy\PageGuide\PageGuideServiceProvider::class,
        \TallAndSassy\PageGuideAdmin\PageGuideAdminServiceProvider::class,
        \TallAndSassy\Ui\Glances\UiGlances_ServiceProvider::class,

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
    NiceTODO: make a 'publish' util 

/routes/web (replace)
    [ ]  just append include
        // Make work with TallAndSassy routes. This should be automatic (shrug)
        require_once(__DIR__ . '/../modules/TallAndSassy/PageGuide/page-guide/routes/web.php');
        require_once(__DIR__ . '/../modules/TallAndSassy/PageGuide/page-guide-admin/routes/web.php');
        require_once(__DIR__ . '/../modules/TallAndSassy/Ui/Glances/routes/web.php');

public/img/logos
    cp -r submodules/TallAndSassy/PageGuide/page-guide/resources/public/img public/img

Get resource/public/css/app.css to work via webpack
    [ ] This is not compatible with tail/jit Beta (6/30/21')
        In 'tailwind.config.js' disable jit like this: // mode: 'jit'

    For each sub-module, you need to make an entry mirroring whatever you do for app.css
    Like:
        mix.js([
        'resources/js/app.js',
        'modules/TallAndSassy/Ui/resources/js/app.js', // <-- Import module js.  There is definetly a better way
        ], 'public/js')
        .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        ])
        .postCss('modules/TallAndSassy/PageGuide/page-guide/resources/public/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        ])
        .postCss('modules/TallAndSassy/PageGuide/page-guide-admin/resources/public/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        ]) // We can probably combine all module .css into one array, like in the mix.js above. But, there is also an probably and automated way, too.
        ;


webpack.mix.js (something like this...)
mix.js([
'resources/js/app.js',
'modules/TallAndSassy/Ui/assets/js/app.js' // <-- Import module js.  There is definetly a better way
], 'public/js')
.postCss('resources/css/app.css', 'public/css', [
require('postcss-import'),
require('tailwindcss'),
])
.postCss('modules/TallAndSassy/PageGuide/page-guide/resources/public/css/app.css', 'public/css', [
require('postcss-import'),
require('tailwindcss'),
])
.postCss('modules/TallAndSassy/PageGuide/page-guide-admin/resources/public/css/app.css', 'public/css', [
require('postcss-import'),
require('tailwindcss'),
]) // We can probably combine all module .css into one array, like in the mix.js above. But, there is also an probably and automated way, too.
;
