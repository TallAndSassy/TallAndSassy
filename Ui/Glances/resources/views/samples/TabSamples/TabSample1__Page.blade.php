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
    </x-tassy-ui::tabs>
</div>

