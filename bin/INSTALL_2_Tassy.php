<?php
require_once(__DIR__.'/_bin_utils.php');

if (! (
    isSettableOptionSet('TASSY_TENANCY_HQSUBDOMAIN') &&
    isSettableOptionSet('TASSY_TENANCY_ADMINEMAIL') &&
    isSettableOptionSet('REGISTRATION_COMPLETENESS')
)) {
    $c = new Colors();
    echo "\n";
    echo $c->getColoredString("\n\nYou are missing stuff. Try something like this  ",'red');
    echo $c->getColoredString("\n   php vendor/tallandsassy/tallandsassy/bin/INSTALL_2_Tassy.php --TASSY_TENANCY_HQSUBDOMAIN=hq --TASSY_TENANCY_ADMINEMAIL=bob@gmail.com --REGISTRATION_COMPLETENESS=email --MAIL_HOST=smtp.postmarkapp.com --MAIL_USERNAME=SomeUserName --MAIL_PASSWORD=SomePassword --MAIL_FROM_ADDRESS='no-reply@mydomainiown.com' --MAIL_FROM_NAME='The Robot' --MAIL_PORT=587 ",'green');
    echo $c->getColoredString("\n\n   --MAX_PROCRASTINATION=(0,1) if 1, skips migrate and npm stuff, presuming you'll just do it later ",'brown');
    echo $c->getColoredString("\n\n   --REGISTRATION_COMPLETENESS=(none,email) email forces email verification of new users. You'll want to set up the email settings when  ",'brown');
    echo $c->getColoredString("\n\n   --REGISTRATION_COMPLETENESS=email --MAIL_HOST=smtp.postmarkapp.com --MAIL_USERNAME=SomeUserName --MAIL_PASSWORD=SomePassword --MAIL_FROM_ADDRESS='no-reply@mydomainiown.com' --MAIL_FROM_NAME='The Robot'",'brown');
    echo $c->getColoredString("\n\n   --MAIL_PORT=587 #or whatever. Fios will, for example, block port 25",'brown');

    echo "\n";
    echo "\n";
    exit(-1);
}

$MAX_PROCRASTINATION = getOptionalOption(
    optionName:'MAX_PROCRASTINATION',
    default:0,
    doesValidate:fn($passedValueToBeValidated) => in_array($passedValueToBeValidated,['0','1']),
    transformInputToInternal:fn($passedValidatedValue) => $passedValidatedValue*1,
    doEcho: true,
);
# Add Admin Email (we need mostly for demos for now) -------------------------------------------------------------------------------------------------------------------------------
$TASSY_TENANCY_ADMINEMAIL = getRequiredOption(
    optionName:'TASSY_TENANCY_ADMINEMAIL',
);

/*
# Now, let's get TallAndSassy working so we can see what a minimum installation looks like.
# Goal: Be able to run this multiple times, within the same Laravel installation.
Goal #2: Make this happen automatically during the package installation. sheesh.
*/
// Init Tall & Sassy

# Add HQ (we need an HQ subdomain) -------------------------------------------------------------------------------------------------------------------------------------------------
$TASSY_TENANCY_HQSUBDOMAIN = getOptionalOption(
    optionName:'TASSY_TENANCY_HQSUBDOMAIN',
    default:'hq',
    doesValidate:fn($passedValueToBeValidated) => strlen($passedValueToBeValidated) < 32,
    transformInputToInternal:fn($passedValidatedValue) => strtolower($passedValidatedValue),
    doEcho:  true
);


$REGISTRATION_COMPLETENESS = getRequiredOption(optionName:'REGISTRATION_COMPLETENESS');
assert(in_array($REGISTRATION_COMPLETENESS,['none','email']));

# Email Settings  -------------------------------------------------------------------------------------------------------------------------------------------------
$MAIL_HOST_elseFalse = getOptionalOption(
    optionName:'MAIL_HOST',
    default:false,
    doesValidate:fn($passedValueToBeValidated) => strlen($passedValueToBeValidated) < 256,
    transformInputToInternal:fn($passedValidatedValue) => $passedValidatedValue,
    doEcho:  true
);
$MAIL_USERNAME_elseFalse = getOptionalOption(
    optionName:'MAIL_USERNAME',
    default:false,
    doesValidate:fn($passedValueToBeValidated) => strlen($passedValueToBeValidated) < 256,
    transformInputToInternal:fn($passedValidatedValue) => $passedValidatedValue,
    doEcho:  true
);
$MAIL_PASSWORD_elseFalse = getOptionalOption(
    optionName:'MAIL_PASSWORD',
    default:false,
    doesValidate:fn($passedValueToBeValidated) => strlen($passedValueToBeValidated) < 256,
    transformInputToInternal:fn($passedValidatedValue) => $passedValidatedValue,
    doEcho:  true
);
$MAIL_FROM_ADDRESS_elseFalse = getOptionalOption(
    optionName:'MAIL_FROM_ADDRESS',
    default:$TASSY_TENANCY_ADMINEMAIL,
    doesValidate:fn($passedValueToBeValidated) => strlen($passedValueToBeValidated) < 256,
    transformInputToInternal:fn($passedValidatedValue) => $passedValidatedValue,
    doEcho:  true
);
$MAIL_FROM_NAME_elseFalse = getOptionalOption(
    optionName:'MAIL_FROM_NAME',
    default:false,
    doesValidate:fn($passedValueToBeValidated) => strlen($passedValueToBeValidated) < 256,
    transformInputToInternal:fn($passedValidatedValue) => $passedValidatedValue,
    doEcho:  true
);
$MAIL_PORT_elseFalse = getOptionalOption(
    optionName:'MAIL_PORT',
    default:false,
    doesValidate:fn($passedValueToBeValidated) => strlen($passedValueToBeValidated) <= 3,
    transformInputToInternal:fn($passedValidatedValue) => $passedValidatedValue*1,
    doEcho:  true
);

if ($REGISTRATION_COMPLETENESS != 'none') {
    assert(
        $MAIL_HOST_elseFalse !== false &&
        $MAIL_USERNAME_elseFalse !== false &&
        $MAIL_PASSWORD_elseFalse !== false &&
        $MAIL_FROM_ADDRESS_elseFalse !== false &&
        $MAIL_FROM_NAME_elseFalse !== false, "REGISTRATION_COMPLETENESS is set to $REGISTRATION_COMPLETENESS. Email settings must be configured."
    );
}


$localhostName = 'localhost';// INPUT (uncommon)
$dirParts = explode('/',getcwd());
$APP_NAME = $dirParts[count($dirParts)-1];
$APP_URL = "http://{$localhostName}";
print "\n localhostName=>$localhostName";
print "\n APP_NAME=>$APP_NAME";
print "\n APP_URL=>$APP_URL";
print "\n MAX_PROCRASTINATION=>$MAX_PROCRASTINATION";
print "\n REGISTRATION_COMPLETENESS = $REGISTRATION_COMPLETENESS";
print "\n MAIL_HOST = ". ( $MAIL_HOST_elseFalse !== false ? $MAIL_HOST_elseFalse : 'default');
print "\n MAIL_USERNAME = ". ( $MAIL_USERNAME_elseFalse !== false ? $MAIL_USERNAME_elseFalse : 'default');
print "\n MAIL_PASSWORD = ". ( $MAIL_PASSWORD_elseFalse !== false ? $MAIL_PASSWORD_elseFalse : 'default');
print "\n MAIL_FROM_ADDRESS = ". ( $MAIL_FROM_ADDRESS_elseFalse !== false ? $MAIL_FROM_ADDRESS_elseFalse : 'default');
print "\n MAIL_FROM_NAME = ". ( $MAIL_FROM_NAME_elseFalse !== false ? $MAIL_FROM_NAME_elseFalse : 'default');
print "\n MAIL_PORT = ". ( $MAIL_PORT_elseFalse !== false ? $MAIL_PORT_elseFalse : 'default');

print "\n";

// delete if already there
jcmd(cmd:"sed -i'.orig' '/TASSY_TENANCY_HQSUBDOMAIN=.*$/d' .env", bForceEcho: true);

# add new TASSY_TENANCY_HQSUBDOMAIN to .env
jcmd(cmd:"sed -i'.orig' '1s/^/TASSY_TENANCY_HQSUBDOMAIN={$TASSY_TENANCY_HQSUBDOMAIN}\\n/' .env", bForceEcho: true);

// delete if already there
jcmd(cmd:"sed -i'.orig' '/TASSY_TENANCY_ADMINEMAIL=.*$/d' .env", bForceEcho: true);

# add new TASSY_TENANCY_ADMINEMAIL to .env
jcmd(cmd:"sed -i'.orig' '1s/^/TASSY_TENANCY_ADMINEMAIL={$TASSY_TENANCY_ADMINEMAIL}\\n/' .env", bForceEcho: true);


# add new localhost (vs. 127.0.0.1 cuz we can only have subdomains on a top level domains, not IPs) to .env
// MEMCACHED_HOST=127.0.0.1
jcmd(cmd:"sed -i'.orig' '/MEMCACHED_HOST=.*$/d' .env", bForceEcho: true);
jcmd(cmd:"sed -i'.orig' '1s/^/MEMCACHED_HOST='{$localhostName}'\\n/' .env", bForceEcho: true);

jcmd(cmd:"sed -i'.orig' '/APP_URL=.*$/d' .env", bForceEcho: true);
jcmd(cmd:"sed -i'.orig' '1s/^/APP_URL=\"{$APP_URL}\"//\\n/' .env", bForceEcho: true);

jcmd(cmd:"sed -i'.orig' '/APP_NAME=.*$/d' .env", bForceEcho: true);
jcmd(cmd:"sed -i'.orig' '1s/^/APP_NAME='{$APP_NAME}'\\n/' .env", bForceEcho: true);
//jcmd(cmd:"sed -i'.orig' '1s/^/APP_NAME={$APP_NAME}//\\n/' .env", bForceEcho: true);



// Update email settings, if relevant
if ($MAIL_HOST_elseFalse != false) {
    jcmd(cmd:"sed -i'.orig' '/MAIL_HOST=.*$/d' .env", bForceEcho: true);
    jcmd(cmd:"sed -i'.orig' '1s/^/MAIL_HOST='{$MAIL_HOST_elseFalse}'\\n/' .env", bForceEcho: true);
}
if ($MAIL_USERNAME_elseFalse != false) {
    jcmd(cmd:"sed -i'.orig' '/MAIL_USERNAME=.*$/d' .env", bForceEcho: true);
    jcmd(cmd:"sed -i'.orig' '1s/^/MAIL_USERNAME='{$MAIL_USERNAME_elseFalse}'\\n/' .env", bForceEcho: true);

}
if ($MAIL_PASSWORD_elseFalse != false) {
    jcmd(cmd:"sed -i'.orig' '/MAIL_PASSWORD=.*$/d' .env", bForceEcho: true);
    jcmd(cmd:"sed -i'.orig' '1s/^/MAIL_PASSWORD='{$MAIL_PASSWORD_elseFalse}'\\n/' .env", bForceEcho: true);

}
if ($MAIL_FROM_ADDRESS_elseFalse != false) {
    jcmd(cmd:"sed -i'.orig' '/MAIL_FROM_ADDRESS=.*$/d' .env", bForceEcho: true);
    jcmd(cmd:"sed -i'.orig' '1s/^/MAIL_FROM_ADDRESS='{$MAIL_FROM_ADDRESS_elseFalse}'\\n/' .env", bForceEcho: true);

}
if ($MAIL_FROM_NAME_elseFalse != false) {
    jcmd(cmd:"sed -i'.orig' '/MAIL_FROM_NAME=.*$/d' .env", bForceEcho: true);
    $sed = "sed -i'.orig' '1s/^/MAIL_FROM_NAME=\"{$MAIL_FROM_NAME_elseFalse}\"\\n/' .env"; // quotes tricked me here
    jcmd(cmd:$sed, bForceEcho: true);

}

if ($MAIL_PORT_elseFalse != false) {
    jcmd(cmd:"sed -i'.orig' '/MAIL_PORT=.*$/d' .env", bForceEcho: true);

    jcmd(cmd:"sed -i'.orig' '1s/^/MAIL_PORT='{$MAIL_PORT_elseFalse}'\\n/' .env", bForceEcho: true);

}
// Troubleshooting: https://postmarkapp.com/support/article/1116-troubleshooting-common-connection-issues

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

//// Nudge Use to use HasRoles; -----------------------------------------------------------------------------------------------------------------------------------------------------------------
//// Find  'namespace App\Models;' and insert 'use Spatie\Permission\Traits\HasRoles;' aft
//$ret = insertAfter(
//    filePath:'app/Models/User.php',
//    contentToFindInALine: 'namespace App\Models;',
//    contentToInsertAfterFoundLine: 'use Spatie\Permission\Traits\HasRoles; // Added by INSTALL_2_Tassy.php',
//    bForceEcho: true
//);
//assert($ret);
//
//// Find  'namespace App\Models;' and insert 'use Spatie\Permission\Traits\HasRoles;' aft
//$ret = insertAfter(
//    filePath:'app/Models/User.php',
//    contentToFindInALine: 'use TwoFactorAuthenticatable;',
//    contentToInsertAfterFoundLine: '    use HasRoles; // Added by INSTALL_2_Tassy.php',
//    bForceEcho: true
//);
//assert($ret);
//
//$ret = insertAfter(
//    filePath:'app/Models/User.php',
//    contentToFindInALine: 'use Spatie\Permission\Traits\HasRoles;',
//    contentToInsertAfterFoundLine: 'use TallAndSassy\Tenancy\Scopes\TenantScope;',
//    bForceEcho: true
//);
//print "\n";
//assert($ret);
// Old User seeder dies without a tenant. Let's just comment it out
$ret = commentOutLineWithStuff(
    filePath:'database/seeders/DatabaseSeeder.php',
    contentToFindInALine: '\App\Models\User::factory(10)->create();',
    doDieOnNoMatch: true,
    bForceEcho: true
);
assert($ret);

// Init DB --------- ----------------------------------------------------------------------------------------------------------------------------------------------------------------
// Use our copy of the UserFactory
jcmd(cmd:'mv database/factories/UserFactory.php database/factories/UserFactory.orig.eraseme', bForceEcho: true);
jcmd(cmd:'cp vendor/tallandsassy/tallandsassy/Tenancy/src/database/factories/stub/UserFactory.php database/factories', bForceEcho: true);

jcmd(cmd:'php artisan vendor:publish --tag="tassy"', bForceEcho: true);
jcmd(cmd:'cp vendor/tallandsassy/tallandsassy/PageGuide/stubs/web.stub routes/web.php', bForceEcho: true);


// Big changes to model/User.php ... (good candidate for Rector?)
jcmd(cmd:'mv app/Models/User.php app/Models/User.php.eraseme', bForceEcho: true);
if ($REGISTRATION_COMPLETENESS == 'none') {
    jcmd(cmd: 'cp vendor/tallandsassy/tallandsassy/People/src/Models/Stubs/User.NoEmailVerification.php.stub app/Models/User.php', bForceEcho: true);
} elseif ($REGISTRATION_COMPLETENESS =='email') {
    jcmd(cmd: 'cp vendor/tallandsassy/tallandsassy/People/src/Models/Stubs/User.YesEmailVerification.php.stub app/Models/User.php', bForceEcho: true);

} else {
    assert(0, 'logic error');
}
//$newMethods = '
// protected static function booted()
//    {
//        static::addGlobalScope(new TenantScope());
//        static::creating(function($model){
//            if ($model->tenant_id) {
//                // no-op $model->tenant_id =  $model->tenant_id;
//            } elseif(session()->has("tenant_id")) {
//                $model->tenant_id = session()->get("tenant_id");
//            } else {
//                $superadminpattern = env("TASSY_TENANCY_ADMINEMAIL");
//                if ($model->email == $superadminpattern) {
//                    $model->tenant_id = null;
//                } else {
//                    #dd(session()->getContainer());
//                    dd( $model->email, env("MEMCACHED_HOST"), $superadminpattern, __METHOD__, __FILE__, __LINE__);
//                    abort(500);
//                }
//
//            }
//        });
//
//        // I can not find where to add that in registration. Everyone is now gonna be a booker unless we say explicitly otherwise
//        static::created(function($model) {
//            $model->assignRole("booker");
//        });
//    }';
//$ret = insertAfter(
//    filePath:'app/Models/User.php',
//    contentToFindInALine: '];', // hmm, looks fragile
//    contentToInsertAfterFoundLine: $newMethods,
//    bForceEcho: true
//);
//print "\n";
//assert($ret);




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
jcmd(cmd:'cp vendor/tallandsassy/tallandsassy/PageGuide/stubs/routes/web.stub routes/web.php', bForceEcho: true);
jcmd(cmd:'cp vendor/tallandsassy/tallandsassy/PageGuide/stubs/routes/web-admin--routes.stub routes/web-admin--routes.php', bForceEcho: true);
jcmd(cmd:'cp vendor/tallandsassy/tallandsassy/PageGuide/stubs/routes/web-front--routes.stub routes/web-front--routes.php', bForceEcho: true);
jcmd(cmd:'cp vendor/tallandsassy/tallandsassy/PageGuide/stubs/routes/web-me--routes.stub routes/web-me--routes.php', bForceEcho: true);
jcmd(cmd:'cp vendor/tallandsassy/tallandsassy/PageGuide/stubs/routes/web-admin-people.stub routes/web-admin-people.php', bForceEcho: true);

//
// js  ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// ToDO: Make better by searching for  webpack.mix.js and seeing how livewire, etc. does this
// [ ] Big webpack.mix.js stuff (TODO)\
jcmd(cmd:'mv webpack.mix.js webpack.mix.js.orig', bForceEcho: true);
jcmd(cmd:'cp vendor/tallandsassy/tallandsassy/Ui/webpack.mix.js webpack.mix.js', bForceEcho: true);
jcmd(cmd:'cp vendor/tallandsassy/tallandsassy/Cms/resources/js/jckeditor.js resources/js/jckeditor.js', bForceEcho: true);


// Mostly User Stuff
// Terms and Privacy
// Make user accept the new terms and policy
// uncomment config/jetstream.php --> Features::termsAndPrivacyPolicy(),
$ret = insertAfter(
    filePath:'config/jetstream.php',
    contentToFindInALine:'// Features::termsAndPrivacyPolicy()',
    contentToInsertAfterFoundLine:'Features::termsAndPrivacyPolicy(),// flipped by Tassy install script',
    bForceEcho:true);
assert($ret);
$ret = commentOutLineWithStuff(
    filePath:'config/jetstream.php',
    contentToFindInALine: 'Features::accountDeletion(),',
    doDieOnNoMatch: true,
    bForceEcho: true
);
assert($ret);

// Make new user verify email
// see: https://jetstream.laravel.com/2.x/features/registration.html
if ($REGISTRATION_COMPLETENESS == 'email') {
    $ret = insertAfter(
        filePath: 'config/fortify.php',
        contentToFindInALine: '// Features::emailVerification(),',
        contentToInsertAfterFoundLine: 'Features::emailVerification(), // flipped by Tassy install script',
        bForceEcho: true);
    assert($ret);
}


// Nudge the provider  -----------------------------------------------------------------------------------------------------------------------------------------------------------------
jcmd(cmd:'php artisan vendor:publish --tag=tassy-config', bForceEcho: true);
jcmd(cmd:'php artisan tassy-cms:install', bForceEcho: true);
jcmd(cmd:'php artisan tassy-page-guide:install', bForceEcho: true);
if ( $MAX_PROCRASTINATION) {
    print "\nImplementing the protocals of MAX_PROCRASTINATION\n";
} else {
    // Init the db ------------------------------------------------------------------------------------------------------------------------------------------------------------------
    jcmd(cmd:'php artisan migrate:fresh', bForceEcho: true);

    jcmd(cmd: 'npm install', bForceEcho: true);
    jcmd(cmd: 'npm run dev', bForceEcho: true);
}


$c = new Colors();
echo "\n";
echo $c->getColoredString("\n\nPlease start a server  ",'red');
echo $c->getColoredString(" (hint: use something like 'localhost' and not IP cuz of tenancy stuff. It should normally match APP_URL in .env)  ",'dark_gray');
echo $c->getColoredString("\n   php artisan serve --host=localhost   ",'green');
echo "\n";
echo "\n";
echo $c->getColoredString("\n\nPlease the user's guide at:  ",'red');
echo $c->getColoredString("\n   USERS_GUIDE.md   ",'green');
echo "\n";
echo "\n";
echo $c->getColoredString("\n\nRun the demo seeder:  ",'red');
echo $c->getColoredString("\n   php vendor/tallandsassy/tallandsassy/bin/demo/INSTALL_3_Demo.php   ",'green');
echo "\n";
echo "\n";
