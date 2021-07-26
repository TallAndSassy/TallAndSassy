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
