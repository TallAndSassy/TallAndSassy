<?php
declare(strict_types=1);

namespace TallAndSassy\People\Models;


use TallAndSassy\Tenancy\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class UserBase extends Authenticatable
    // typically, but a killer for demos and dev. No handled by the leaf /app/models/user.php implements \Illuminate\Contracts\Auth\MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new TenantScope());
        static::creating(function($model){

            // Mostly make sure we give the user a tenant
            if (isset($model->tenant_id)) { // whomever made this user, is telling us the tenent
                // do nothing

            } elseif(session()->has('tenant_id')) {
                $model->tenant_id = session()->get('tenant_id');

            } else {
                $superadminpattern = env('TASSY_TENANCY_ADMINEMAIL');
                if ($model->email == $superadminpattern) {
                    $model->tenant_id = null;
                } else {
                    #dd(session()->getContainer());
                    dd( $model->email, ENV('MEMCACHED_HOST'),env('TASSY_TENANCY_ADMINEMAIL'), $superadminpattern, __METHOD__, __FILE__, __LINE__, $model);
                    abort(500);
                }

            }
        });

        // I can't find where to add that in registration. Everyone is now gonna be a booker unless we say explicitly otherwise
        static::created(function($model) {
            $model->assignRole('booker');
        });
    }
}