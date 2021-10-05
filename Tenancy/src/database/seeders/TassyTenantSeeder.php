<?php
declare(strict_types=1);
namespace Database\Seeders;
class TassyTenantSeeder extends \TallAndSassy\Tenancy\database\seeders\TassyTenantSeederBase
{
    // This is currently copied from the i published via ServiceProvider (php artisan vendor:publish --tag="tassy-seeders")
    // This is here cuz I couldn't figure out how to make a package based seed available.  But this is kind of nice, too.
    // Seed me via the:
    //   php artisan db:see --class="Database\Seeders\TassyTenantSeeder"
}
