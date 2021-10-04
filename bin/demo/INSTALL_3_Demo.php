<?php
require_once(__DIR__.'/../_bin_utils.php');
jcmd(cmd:'php artisan vendor:publish --tag="tassy-seeders"', bForceEcho: true);

jcmd(cmd:'php artisan db:seed --class=TassyTenantSeeder', bForceEcho: true);

