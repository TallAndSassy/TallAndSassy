<x-guest-layout xmlns:x-tassy="http://www.w3.org/1999/xlink">
    <div class="text-6xl m-b-md  flex flex-col items-center ">
        Tenants
    </div>
    <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">

        <div class="w-full  mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
            <ul>
                @foreach (\TallAndSassy\Tenancy\Models\Tenant::all()->where('slug','!=',config('app.HQ_SUBDOMAIN')) as $tenant)
                    <li><a href="{{route('tenant.home', ['tenant' => $tenant])}}">{{$tenant->name}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>

</x-guest-layout>
