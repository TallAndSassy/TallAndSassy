<x-tassy::page-me title="Super Admin">

    <div>
        <x-tassy-ui::tab-container defaultSlug="dashboard">
            <x-tassy-ui::tab name="Dashboard" :isLivewire="false" slug="dashboard">
                {{--                https://tailwindui.com/components/application-ui/data-display/stats--}}
                <div>
                    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
                        <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Num Tenants
                            </dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                <a href="/superadmin/dashboard?pageTab=Tenants"><livewire:tassy:super-admin.tenant-count/></a>
                            </dd>
                        </div>
                        <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Num Users
                            </dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                {{\App\Models\User::count()}}
                            </dd>
                        </div>
                    </dl>
                </div>

            </x-tassy-ui::tab>


            <x-tassy-ui::tab name="Tenants" :isLivewire="true" slug="tenants">
                <livewire:tassy:super-admin.tenant-directory :tabName="'SuperAdminTenantDirectory'"/>
            </x-tassy-ui::tab>

            <x-tassy-ui::tab name="More..." slug="more">
                <div class="border shadow mt-2 p-2 ">
                    TBD
                </div>
            </x-tassy-ui::tab>
{{--            <x-tassy-ui::tab name="Modal-Blade Sample">--}}
{{--                @include('tassy-ui::samples/Modals/sample_modal_blade_tab_body')--}}
{{--            </x-tassy-ui::tab>--}}
{{--            <x-tassy-ui::tab name="Modal-Livewire Sample">--}}
{{--                @include('tassy-ui::samples/Modals/sample_modal_livewire__tab_body')--}}
{{--            </x-tassy-ui::tab>--}}
{{--            <x-tassy-ui::tab name="Tabbed Tech Check">--}}
{{--                <div class="border shadow mt-2 p-2 ">--}}
{{--                    Does alpine work?--}}
{{--                    @include('tassy-ui::samples/TechBase/Status__')--}}
{{--                </div>--}}
{{--            </x-tassy-ui::tab>--}}
{{--        </x-tassy-ui::tabs>--}}
        </x-tassy-ui::tab-container>




    </div>


</x-tassy::page-me>
