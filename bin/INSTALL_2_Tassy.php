<?php
require_once(__DIR__.'/_bin_utils.php');
/*
# Now, let's get TallAndSassy working so we can see what a minimum installation looks like.
# Goal: Be able to run this multiple times, within the same Laravel installation.
Goal #2: Make this happen automatically during the package installation. sheesh.
*/
// Init Tall & Sassy

# Add HQ (we need an HQ subdomain) -------------------------------------------------------------------------------------------------------------------------------------------------
$HQ_SUBDOMAIN = getOptionalOption(
    optionName:'HQ_SUBDOMAIN',
    default:'hq',
    doesValidate:fn($passedValueToBeValidated) => strlen($passedValueToBeValidated) < 32,
    transformInputToInternal:fn($passedValidatedValue) => strtolower($passedValidatedValue)
);
// delete if already there
jcmd(cmd:"sed -i'.orig' '/HQ_SUBDOMAIN=.*$/d' .env", bForceEcho: true);

# add new HQ_SUBDOMAIN to .env
jcmd(cmd:"sed -i'.orig' '1s/^/HQ_SUBDOMAIN={$HQ_SUBDOMAIN}\\n/' .env", bForceEcho: true);

# reparse .env
jcmd(cmd:"php artisan config:clear", bForceEcho: true);



# Tenant Middleware ----------------------------------------------------------------------------------------------------------------------------------------------------------------

/*
[ ] append to app/Http/Kernel.php' #WIP - was trying to get to autoregister
    protected $routeMiddleware = [...
        'tenancy' => Middleware\SubdomainTenancy::class
*/
insertAfter(
    filePath:'app/Http/Kernel.php',
    contentToFindInALine: 'protected $routeMiddleware = [',
    contentToInsertAfterFoundLine: "        'tenancy' => \TallAndSassy\Tenancy\Middleware\SubdomainTenancy::class, // Added programmatically by Tall & Sassy",
    bForceEcho: true
);


# Custom Homepage ------------------------------------------------------------------------------------------------------------------------------------------------------------------
// Make homepage for users default to /me instead of /dashboard
$cmd =<<<EOF
sed -i'.orig' 's/\/dashboard/\/me/g' app/Providers/RouteServiceProvider.php
EOF;

jcmd(cmd:$cmd, bForceEcho: true);
/*// Change default home page
    app/Providers/RouteServiceProvider.php
    'str_replace("HOME = '/dashboard';", "HOME = '/me';", $file);
    (this might be better: https://laravel-news.com/override-login-redirects-in-jetstream-fortify)
*/

// Init the db ------------------------------------------------------------------------------------------------------------------------------------------------------------------
jcmd(cmd:'php artisan migrate:fresh', bForceEcho: true);

# Nix jetstreams unwanted UI ------------------------------------------------------------------------------------------------------------------------------------------------------------------
// Keep the old stuff, for reference.  You could safely delete them
jcmd(cmd:'mkdir resources/views/jorig', bForceEcho: true);
jcmd(cmd:'mv resources/views/auth resources/views/jorig', bForceEcho: true);
jcmd(cmd:'mv resources/views/profile resources/views/jorig', bForceEcho: true);
jcmd(cmd:'mv resources/views/teams resources/views/jorig', bForceEcho: true);


jcmd(cmd:'cp -r vendor/tallandsassy/tallandsassy/PageGuide/page-guide/resources/views/auth resources/views', bForceEcho:true);
jcmd(cmd:'cp -r vendor/tallandsassy/tallandsassy/PageGuide/page-guide/resources/views/profile resources/views', bForceEcho:true);
jcmd(cmd:'cp -r vendor/tallandsassy/tallandsassy/PageGuide/page-guide/resources/views/teams resources/views', bForceEcho:true);
jcmd(cmd:'cp -r vendor/tallandsassy/tallandsassy/PageGuide/page-guide/resources/views/layouts/app.blade.php resources/views/layouts', bForceEcho:true);

//[] replace resources/view/auth,profile,team ????
//    mkdir resources/views/jorig
//    mv resources/views/auth resources/views/jorig
//    mv resources/views/profile resources/views/jorig
//    mv resources/views/teams resources/views/jorig
//
//    cp -r vendor/tallandsassy/tallandsassy/PageGuide/page-guide/resources/views/auth resources/views
//    cp -r vendor/tallandsassy/tallandsassy/PageGuide/page-guide/resources/views/profile resources/views
//    cp -r vendor/tallandsassy/tallandsassy/PageGuide/page-guide/resources/views/teams resources/views
//    cp -r vendor/tallandsassy/tallandsassy/PageGuide/page-guide/resources/views/layouts/app.blade.php resources/views/layouts
//


# public/img/logos -----------------------------------------------------------------------------------------------------------------------------------------------------------------
jcmd(cmd:'cp -r vendor/tallandsassy/tallandsassy/PageGuide/page-guide/resources/public/img public/img', bForceEcho: true);


# fix tail/jit beta  ---------------------------------------------------------------------------------------------------------------------------------------------------------------
// [ ] This is not compatible with tail/jit Beta (6/30/21')
//    In 'tailwind.config.js' disable jit like this--> // mode: 'jit'
$cmd =<<<EOF
sed -i'.orig' "s/\mode: 'jit'/\/\/mode: 'jit' /" tailwind.config.js
EOF;

jcmd(cmd:$cmd, bForceEcho: true);
jcmd(cmd:'cp -r vendor/tallandsassy/tallandsassy/PageGuide/page-guide/resources/public/img public/img', bForceEcho: true);

// Nudge Use to use HasRoles; -----------------------------------------------------------------------------------------------------------------------------------------------------------------
// Find  'namespace App\Models;' and insert 'use Spatie\Permission\Traits\HasRoles;' aft
$ret = insertAfter(
    filePath:'app/Models/User.php',
    contentToFindInALine: 'namespace App\Models;',
    contentToInsertAfterFoundLine: 'use Spatie\Permission\Traits\HasRoles; // Added by INSTALL_2_Tassy.php',
    bForceEcho: true
);
assert($ret);

// Find  'namespace App\Models;' and insert 'use Spatie\Permission\Traits\HasRoles;' aft
$ret = insertAfter(
    filePath:'app/Models/User.php',
    contentToFindInALine: 'use TwoFactorAuthenticatable;',
    contentToInsertAfterFoundLine: '    use HasRoles; // Added by INSTALL_2_Tassy.php',
    bForceEcho: true
);
assert($ret);

// Old User seeder dies without a tenant. Let's just comment it out
$ret = commentOutLineWithStuff(
    filePath:'database/seeders/DatabaseSeeder.php',
    contentToFindInALine: '\App\Models\User::factory(10)->create();',
    doDieOnNoMatch: true,
    bForceEcho: true
);
assert($ret);

// Init DB --------- ----------------------------------------------------------------------------------------------------------------------------------------------------------------
jcmd(cmd:'cp vendor/tallandsassy/tallandsassy/PageGuide/stubs/web.stub routes/web.php', bForceEcho: true);


// Big changes to model/User.php ... (good candidate for Rector?)
$newMethods = '  
 protected static function booted()
    {
        static::addGlobalScope(new TenantScope());
        static::creating(function($model){            
            if ($model->tenant_id) {
                // no-op $model->tenant_id =  $model->tenant_id;
            } elseif(session()->has("tenant_id")) {
                $model->tenant_id = session()->get("tenant_id");
            } else {
                $superadminpattern = "admin_".ENV("MEMCACHED_HOST")."@rohrer.org";
                if ($model->email == $superadminpattern) {
                    $model->tenant_id = null;
                } else {
                    #dd(session()->getContainer());
                    dd( $model->email, ENV("MEMCACHED_HOST"), $superadminpattern, __METHOD__, __FILE__, __LINE__);
                    abort(500);
                }

            }
        });

        // I can not find where to add that in registration. Everyone is now gonna be a booker unless we say explicitly otherwise
        static::created(function($model) {
            $model->assignRole("booker");
        });
    }';
$ret = insertAfter(
    filePath:'app/Models/User.php',
    contentToFindInALine: '];', // hmm, looks fragile
    contentToInsertAfterFoundLine: $newMethods,
    bForceEcho: true
);
print "\n";
assert($ret);


// Get our factories up and available.
// There are definitily ways to do this, but I couldn't make it work.
// So, we'll just copy over...
// https://twitter.com/wylesone/status/1303610973736128512
// https://gist.github.com/fourstacks/9cc6a68ed25fbbf00aa016da34f9a8be
//jcmd(cmd:'mkdir -p database/factories/TallAndSassy/Cms/Models', bForceEcho: true);
//jcmd(cmd:'cp -r vendor/tallandsassy/tallandsassy/Cms/src/database/factories/* database/factories/TallAndSassy/Cms/Models', bForceEcho: true);
//
//jcmd(cmd:'mkdir -p database/factories/TallAndSassy/Tenancy/Models', bForceEcho: true);
//jcmd(cmd:'cp -r vendor/tallandsassy/tallandsassy/Tenancy/src/database/factories/* database/factories/TallAndSassy/Tenancy/Models', bForceEcho: true);

// Smoother routing  ----------------------------------------------------------------------------------------------------------------------------------------------------------------
// nix the original
jcmd(cmd:'mv routes/web.php routes/web.php.orig', bForceEcho: true);
// use our own web.php, which has a special web-admin--routes.php --- anything there is force to admin-only
jcmd(cmd:'cp vendor/tallandsassy/tallandsassy/PageGuide/stubs/web.stub routes/web.php', bForceEcho: true);
jcmd(cmd:'cp vendor/tallandsassy/tallandsassy/PageGuide/stubs/web-admin--routes.stub routes/web-admin--routes.php', bForceEcho: true);
jcmd(cmd:'cp vendor/tallandsassy/tallandsassy/PageGuide/stubs/web-admin-people.stub routes/web-admin-people.php', bForceEcho: true);


// js  ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// ToDO: Make better by searching for  webpack.mix.js and seeing how livewire, etc. does this
// [ ] Big webpack.mix.js stuff (TODO)\
jcmd(cmd:'mv webpack.mix.js webpack.mix.js.orig', bForceEcho: true);
jcmd(cmd:'cp vendor/tallandsassy/tallandsassy/Ui/webpack.mix.js webpack.mix.js', bForceEcho: true);
jcmd(cmd:'cp vendor/tallandsassy/tallandsassy/Cms/resources/js/jckeditor.js resources/js/jckeditor.js', bForceEcho: true);

// Nudge the provider  -----------------------------------------------------------------------------------------------------------------------------------------------------------------
jcmd(cmd:'php artisan tassy-cms:install', bForceEcho: true);
jcmd(cmd:'php artisan tassy-page-guide:install', bForceEcho: true);
jcmd(cmd:'npm install', bForceEcho: true);
jcmd(cmd:'npm run dev', bForceEcho: true);


$c = new Colors();
echo "\n";
echo $c->getColoredString("\n\nPlease the user's guide at:  ",'red');
echo $c->getColoredString("\n   USERS_GUIDE.md   ",'green');
echo "\n";
echo "\n";
echo $c->getColoredString("\n\nRun the demo seeder:  ",'red');
echo $c->getColoredString("\n   php vendor/tallandsassy/tallandsassy/bin/demo/INSTALL_3_Demo.php   ",'green');
