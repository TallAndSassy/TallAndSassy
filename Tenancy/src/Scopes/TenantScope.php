<?php

namespace TallAndSassy\Tenancy\Scopes;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use TallAndSassy\RolesAndPermissions\BaseTassyPermissions;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     *
     * https://laracasts.com/series/multitenancy-in-practice/episodes/2
     */
    public function apply(Builder $builder, Model $model)
    {
        if (session()->has('tenant_id')) {
            if (
                !$model instanceof User // infinite recursion otherwise
                && !is_null($user = Auth::user())
                && $user instanceof User
                && !$user->can(BaseTassyPermissions::ACCESS_SUPERADMIN_DASHBOARD)
            ) {
                $builder->where('tenant_id', '=', session()->get('tenant_id'));
            }

        } else {
            if (
                !$model instanceof User // infinite recursion otherwise
                && !is_null($user = Auth::user())
                && $user instanceof User
                && !$user->can(BaseTassyPermissions::ACCESS_SUPERADMIN_DASHBOARD)
            ) {
                $builder->where('tenant_id', '=', null);
            }


        }
    }
}
