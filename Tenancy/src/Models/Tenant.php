<?php

namespace TallAndSassy\Tenancy\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TallAndSassy\Tenancy\database\factories\TenantFactory;
use TallAndSassy\Tenancy\Traits\Uuids;


class Tenant extends Model
{
    use HasFactory, Uuids;

    protected $fillable = ['name','slug'];

    public static function booted() {
        static::created(function ($model) {
            // A Tenant was just created, let's give it an admin user
            if ($model->slug != env('TASSY_TENANCY_HQSUBDOMAIN')) {
                // create schooltwist admin for new tenant
                $tenant_id = $model->id;

                // Build admin user for this (identicial to spot in Tenancy/src/Database/seeders/TassyTenantSeederBase.php)
                $tenant = $model;
                $demoUserEmail = env('TASSY_TENANCY_ADMINEMAIL');
                $demoEmailName = explode('@',$demoUserEmail)[0];
                $demoEmailDomain = explode('@',$demoUserEmail)[1];
                $newTenantEmail = "$demoEmailName+{$tenant->slug}@$demoEmailDomain";


                $new_admin = User::create([
                    'name' => 'Builtin SubDomain Admin',
                    'password' => bcrypt('password'),
                    'email' => $newTenantEmail,//'admin_'.$model->slug.'@rohrer.org',
                    'tenant_id' => $tenant_id,
                ]);

                $new_admin->tenant_id = $tenant_id;
                $new_admin->email_verified_at = now();

                
                $new_admin->save();


                $new_admin->assignRole('webmaster');
            }
        });
    }
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return new TenantFactory();
    }
}
