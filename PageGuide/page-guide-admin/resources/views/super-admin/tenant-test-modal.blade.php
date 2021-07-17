<x-tassy-ui::modal_blade name="tenant-create-modal">
    <x-slot name="title">Create New Tenant</x-slot>
    <x-slot name="body">
        Something body.
        Known bug - non-livewire modals show all modals, not just the named modal.

    </x-slot>
    <x-slot name="footer">
        <x-tassy-ui::button
            enumStyle='Cancel'
            @click="show = false"
            class="mr-4">Cancel
        </x-tassy-ui::button>
        <x-tassy-ui::button
            enumStyle='Submit'
            @click="show = false">Submit
        </x-tassy-ui::button>
    </x-slot>
</x-tassy-ui::modal_blade>
