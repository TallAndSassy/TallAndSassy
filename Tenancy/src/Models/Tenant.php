<?php

namespace TallAndSassy\Tenancy\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tenant extends Model
{
    use HasFactory, Uuids;

    protected $fillable = ['name','slug'];

    public static function booted() {
        static::created(function ($model) {
            if ($model->slug != ENV('HQ_SUBDOMAIN')) {
                // create schooltwist admin for new tenant
                $new_admin = User::create(['name' => 'School Twist Admin', 'password' => bcrypt('password'), 'email' => 'admin_'.$model->slug.'@rohrer.org']);

                $new_admin->tenant_id = $model->id;
                $new_admin->email_verified_at = now();

                $new_admin->save();

                $new_admin->assignRole('webmaster');
            }
        });
    }
}
