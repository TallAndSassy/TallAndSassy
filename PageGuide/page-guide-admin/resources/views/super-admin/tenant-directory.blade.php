<div clas="p-4 mt-6">

{{--    <x-tassy-ui::button--}}
{{--        onclick="$modals.showBladeModalNamed('sample-modal')"--}}
{{--        enumStyle="Primary"--}}
{{--    >--}}
{{--        New Tenant--}}
{{--    </x-tassy-ui::button>--}}
{{--    <x-tassy::ui.looks.link-to-modal--}}
{{--        href=""--}}
{{--        onclick="$modals.showBladeModalNamed('sample-modal')"--}}
{{--    >New Tenant</x-tassy::ui.looks.link-to-modal>--}}
    <x-tassy::ui.looks.button-to-modal showBladeModalNamed="tenant-create-modasdfgsdfdl">New Tenant</x-tassy::ui.looks.button-to-modal>

    @include('tassy::super-admin.tenant-create-modal')
{{--    @include('tassy::super-admin.tenant-test-modal')--}}

{{--    https://tailwindui.com/components/application-ui/lists/tables--}}
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                #
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                URL
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Stats(tbd)
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Odd row -->
                            @php
                            $i = 0;
                            @endphp
                            @foreach (\TallAndSassy\Tenancy\Models\Tenant::all() as $tenant)
                                @php $i = $i + 1; @endphp
                                <tr class="bg-white">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{$i}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{$tenant->name}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="{{route('tenant.home', ['tenant' => $tenant])}}">{{route('tenant.home', ['tenant' => $tenant])}}</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        tbd
                                    </td>
                                </tr>
                            @endforeach



                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
