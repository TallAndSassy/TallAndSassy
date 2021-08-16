<?php

namespace TallAndSassy\Tenancy\Middleware;
use TallAndSassy\Tenancy\Models\Tenant;
use Closure;
use Illuminate\Http\Request;

class SubdomainTenancy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $host = $request->getHttpHost();
        $host_exploded = explode('.', $host);
        if (count($host_exploded) > 3) {
            abort(500);
        }
        $subdomain = $host_exploded[0];
        $tenant = Tenant::where('slug', $subdomain)->first();

        if (is_null($tenant)) {

            return redirect()->route('tenant.directory');
        } else {
            session()->put('tenant_id', $tenant->id);
        }


        return $next($request);
    }
}
