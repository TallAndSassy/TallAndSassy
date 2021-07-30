<?php
declare(strict_types=1);

namespace TallAndSassy\Tenancy;

use App\Models\Tenant;

class TenantUtils
{
    static function GetTenantIdElseNull(): ?string {
        if (! session()->has('tenant_id')) {
            return null;
        } else {
            return session()->get('tenant_id');
        }

    }

    /* exception if tenant id isn't there */
    static function GetTenantId(): string {
        $id = session()->get('tenant_id');
        if ($id) {
            return $id;
        } else {
            throw new \Exception('No tenant session set. Maybe try GetTenantSlugElseNull if you are not sure?');
        }

    }

    static function GetTenantSlugElseNull(): ?string {
        $tenantIdElseNull = static::GetTenantIdElseNull();
        if (is_null($tenantIdElseNull)) {
            return null;
        } else {
            $tenantId = $tenantIdElseNull;
            $slug = Tenant::find($tenantId)->slug;
            return $slug;
        }
    }
}
