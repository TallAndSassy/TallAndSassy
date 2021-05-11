<x-tassy-ui::modal_blade name="sample-modal">
    <x-slot name="title">A Sample Modal</x-slot>
    <x-slot name="body">
        <p>Here are some details about our stuff</p>
    </x-slot>
    <x-slot name="footer">
        <x-tassy-ui::button
            enumStyle='cancel'
            @click="show = false">Go Away</x-tassy-ui::button>
    </x-slot>
</x-tassy-ui::modal_blade>
