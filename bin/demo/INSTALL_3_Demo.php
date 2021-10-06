<?php
require_once(__DIR__.'/../_bin_utils.php');

$DO_FORCE_REINSTALL = getOptionalOption(
    optionName:'DO_FORCE_REINSTALL',
    default:1,
    doesValidate:fn($passedValueToBeValidated) => in_array($passedValueToBeValidated,['0','1']),
    transformInputToInternal:fn($passedValidatedValue) => $passedValidatedValue,
    doEcho: true
);

if ($DO_FORCE_REINSTALL) {
    jcmd(cmd:'rm database/seeders/TassyTenantSeeder.php', bForceEcho: true);
}

jcmd(cmd:'php artisan migrate:fresh', bForceEcho: true);

jcmd(cmd:'php artisan vendor:publish --tag="tassy-seeders"', bForceEcho: true);

jcmd(cmd:'php artisan db:seed --class="Database\Seeders\TassyTenantSeeder"', bForceEcho: true);

$c = new Colors();
echo $c->getColoredString("\n\nPlease start a server (it not already running)  ",'red');
echo $c->getColoredString(" (hint: use something like 'localhost' and not IP cuz of tenancy stuff. It should normally match APP_URL in .env)  ",'dark_gray');
echo $c->getColoredString("\n   php artisan serve --host=localhost   ",'green');
echo "\n";
echo "\n";
