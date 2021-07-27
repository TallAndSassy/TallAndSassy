<div>
    <x-tassy-ui::tabs :defaultTab="'Second'">
        <x-tassy-ui::tab name="First" :isLivewire="true">
            <livewire:tassy-ui:Sample_Tab1_Tab :tabName="'First'"/>
        </x-tassy-ui::tab>
        <x-tassy-ui::tab name="Second" :isLivewire="true">
            <livewire:tassy-ui:Sample_Tab2_Tab :tabName="'Second'"/>
        </x-tassy-ui::tab>
        <x-tassy-ui::tab name="Third">
            <div class="border shadow mt-2 p-2 ">
                Local body, not livewire
            </div>
        </x-tassy-ui::tab>
        <x-tassy-ui::tab name="Modal-Blade Sample">
            @include('tassy-ui::samples/Modals/sample_modal_blade_tab_body')
        </x-tassy-ui::tab>
        <x-tassy-ui::tab name="Modal-Livewire Sample">
            @include('tassy-ui::samples/Modals/sample_modal_livewire__tab_body')
        </x-tassy-ui::tab>
        <x-tassy-ui::tab name="Tabbed Tech Check">
            <div class="border shadow mt-2 p-2 ">
                Does alpine work?
               @include('tassy-ui::samples/TechBase/Status__')
            </div>
        </x-tassy-ui::tab>
        <x-tassy-ui::tab name="UI">
            <div class="border shadow mt-2 p-2 ">
                @include(('tassy-ui::samples/UI/UISample__Page'))
            </div>
        </x-tassy-ui::tab>
    </x-tassy-ui::tabs>





</div>

