<?php
require_once(__DIR__.'/../_bin_utils.php');

$DO_FORCE_REINSTALL = getOptionalOption(
    optionName:'DO_FORCE_REINSTALL',
    default:0,
    doesValidate:fn($passedValueToBeValidated) => in_array($passedValueToBeValidated,['0','1']),
    transformInputToInternal:fn($passedValidatedValue) => $passedValidatedValue
);

if ($DO_FORCE_REINSTALL) {
    jcmd(cmd:'rm database/seeders/TassyTenantSeeder.php', bForceEcho: true);
}

jcmd(cmd:'php artisan migrate:fresh', bForceEcho: true);

jcmd(cmd:'php artisan vendor:publish --tag="tassy-seeders"', bForceEcho: true);

jcmd(cmd:'php artisan db:see --class="Database\Seeders\TassyTenantSeeder"', bForceEcho: true);

