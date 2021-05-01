<x-app-layout>
    @php
        $pathOffRouteToGroks = 'packages/TallAndSassy/TasUiGlances/resources/views/groks_glances';

    @endphp
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Glances Stuff Here
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <x-grok::action-section title="Flash" class="mt-4">
                <x-slot name="description">
                    @include('tassy::/groks_glances/flash/description',['pathOffRouteToGroks'=>$pathOffRouteToGroks])
                </x-slot>

                <x-slot name="content">
                    @include('tassy::/groks_glances/flash/content', ['pathOffRouteToGroks'=>$pathOffRouteToGroks])
                </x-slot>
            </x-grok::action-section>
        </div>
    </div>
</x-app-layout>
