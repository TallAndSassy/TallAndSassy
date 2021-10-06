<?php

namespace TallAndSassy\Tenancy\database\seeders;




use TallAndSassy\Cms\Models\Page;
use TallAndSassy\Tenancy\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
class TassyTenantSeederBase extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        // Lets make a bunch of tenants, and create users and data in each one
        $numTenants = 10;
        $numUsersPerTenants = 8;
        for ($i = 0; $i < $numTenants; $i++) {
            // Per tenant stuff...
            $tenant = Tenant::factory()->create();
            session()->put('tenant_id', $tenant->id);

            for ($userNum = 1; $userNum <= $numUsersPerTenants; $userNum++) {
                $aUser = User::factory()->create();
                $aUser->assignRole('booker');
            }
            Page::factory()->create(['slug' => 'home', 'title' => "Home Page for ".$tenant->name]);
            Page::factory(5)->create();


            // Make a new user assigned to this tenant
            $demoUserEmail = env('TASSY_TENANCY_ADMINEMAIL');
            $demoEmailName = explode('@',$demoUserEmail)[0];
            $demoEmailDomain = explode('@',$demoUserEmail)[1];
            $newTenantEmail = "$demoEmailName+{$tenant->slug}@$demoEmailDomain";
            $admin_user = User::factory()->create(['email' => $newTenantEmail, 'name' => 'Webmaster']);
            $admin_user->assignRole('webmaster');
        }




    }
}
