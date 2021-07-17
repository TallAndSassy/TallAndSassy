<?php
/* 7/21' This is needless overhead. This should simply be ' Tenant::count();' in the calling blade. */
namespace TallAndSassy\PageGuideAdmin\Components\SuperAdmin;

use App\Models\Tenant;
use Livewire\Component;

class TenantCount extends Component
{
    public int $tenantCount = 1;

    public function render()
    {
        $this->tenantCount = Tenant::count();
        return view('tassy::super-admin.tenant-count');
    }
}
