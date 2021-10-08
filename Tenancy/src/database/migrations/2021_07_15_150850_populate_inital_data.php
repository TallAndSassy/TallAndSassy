<?php
#namespace TallAndSassy\Tenancy\database\migrations;
#namespace database\migrations;

use TallAndSassy\Tenancy\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Date;

class PopulateInitalData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Make HQ tenant
        //$tenant_id = Tenant::factory()->create(['name'=>'HQ', 'slug'=>env('app.TASSY_TENANCY_HQSUBDOMAIN')])->id;
        #dd(\Illuminate\Support\Env::getRepository());
        # Dying here because the $hq is null
        $hq = env('TASSY_TENANCY_HQSUBDOMAIN');

        assert(!is_null($hq), "TASSY_TENANCY_HQSUBDOMAIN is null. If you don't see TASSY_TENANCY_HQSUBDOMAIN in .env, try adding it. If you see TASSY_TENANCY_HQSUBDOMAIN in the .env file, try `php artisan config:clear` ");
        $tenant_id = Tenant::create(['name'=>'HQ', 'slug'=>$hq])->id;
        session()->put('tenant_id',$tenant_id);


        User::unguard();

        $superuser = User::create([
            'name' => 'Superadmin',
            'email' => env('TASSY_TENANCY_ADMINEMAIL'),

            'password' => App::environment(['local', 'staging']) ?  bcrypt('password') : bcrypt(uniqid().uniqid()), // if not dev, require email reset
            'email_verified_at' => Date::now(),
            'tenant_id' => $tenant_id, //7/21' wouldn't work, but maybe does in october cuz of ordering

            // TODO: ROLE?
        ]);
        $superuser->assignRole('superuser');
        User::reguard();





    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
