<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PopulateRoles extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $booker = Role::create(['name' => 'booker']);
        $webmaster = Role::create(['name' => 'webmaster']);
        $superuser = Role::create(['name' => 'superuser']);

        $permission = Permission::create(['name' => \TallAndSassy\RolesAndPermissions\BaseTassyPermissions::ACCESS_ADMIN_TOOLS]);
        $permission->assignRole($webmaster);
        $permission->assignRole($superuser);

        $permission = Permission::create(['name' => \TallAndSassy\RolesAndPermissions\BaseTassyPermissions::EDIT_HOMEPAGE]);
        $permission->assignRole($webmaster);
        $permission->assignRole($superuser);

        $permission = Permission::create(['name' => \TallAndSassy\RolesAndPermissions\BaseTassyPermissions::ACCESS_SUPERADMIN_DASHBOARD]);
        $permission->assignRole($superuser);

//        $permission = Permission::create(['name' => 'sign up student']);
//        $permission->assignRole($booker);




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Role::where('name', 'booker')->first()->delete();
        Role::where('name', 'webmaster')->first()->delete();
        Role::where('name', 'superuser')->first()->delete();

        Permission::where('name', \TallAndSassy\RolesAndPermissions\BaseTassyPermissions::ACCESS_ADMIN_TOOLS)->first()->delete();

    }
}
