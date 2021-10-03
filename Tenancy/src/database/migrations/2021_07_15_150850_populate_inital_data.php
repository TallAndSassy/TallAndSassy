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
        //$tenant_id = Tenant::factory()->create(['name'=>'HQ', 'slug'=>env('HQ_SUBDOMAIN')])->id;
        #dd(\Illuminate\Support\Env::getRepository());
        # Dying here because the $hq is null
        $hq = env('HQ_SUBDOMAIN');
        assert(!is_null($hq), "HQ_SUBDOMAIN is null. If you don't see HQ_SUBDOMAIN in .env, try adding it. If you see HQ_SUBDOMAIN in the .env file, try `php artisan config:clear` ");
        $tenant_id = Tenant::create(['name'=>'HQ', 'slug'=>$hq])->id;
        session()->put('tenant_id',$tenant_id);


        User::unguard();
        $superuser = User::create([
            'name' => 'Superadmin',
            'email' => 'admin_'.ENV('MEMCACHED_HOST').'@rohrer.org',
            'password' => bcrypt('password'),
            'email_verified_at' => Date::now(),
            //'tenant_id' => $tenant_id, 7/21' wouldn't work

        ]);
        User::reguard();

        $superuser->assignRole('superuser');




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
