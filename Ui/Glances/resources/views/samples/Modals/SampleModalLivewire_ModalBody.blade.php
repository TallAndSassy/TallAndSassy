{{--This is: Ui/Glances/resources/views/samples/Modals/SampleModalLivewire_ModalBody.blade.php--}}


{{-- This works with the livewire component: \Livewire\Livewire::component('tassy-ui::Samples.Modals.SampleButtonModal_CustomAlias',  self::class); --}}
<div>
    <x-tassy-ui::button
        wire:click="handleGoToModal()" {{--    You can look at second half of https://laracasts.com/series/modals-with-the-tall-stack/episodes/6?autoplay=true to remove ajax on close--}}
        enumStyle="Primary"
        class="mt-3"
    >
        Click me for livewire modal  (show:{{$showModal ? 1 : 0}})!
    </x-tassy-ui::button>

    <x-tassy-ui::button
            wire:click="handleGoToModal()" {{--    You can look at second half of https://laracasts.com/series/modals-with-the-tall-stack/episodes/6?autoplay=true to remove ajax on close--}}
    enumStyle="Primary"
            class="mt-3"
    >
        Click me for 2nd livewire modal  (show:{{$showModal ? 1 : 0}})!
    </x-tassy-ui::button>


<x-tassy-ui::modal_livewire name="sample-modal1">
    <x-slot name="title">A Sample Modal from livewire #1</x-slot>
    <x-slot name="body">
        <form
            x-data>
            <p>Here are some details about our stuff</p>

        </form>
    </x-slot>
    <x-slot name="footer">
        <x-tassy-ui::button
            enumStyle='Cancel'
            class="mr-2"

            wire:click="handleCancel()"
        >Cancel</x-tassy-ui::button>
        <x-tassy-ui::button
            enumStyle='Primary'
            wire:click="handlePrimary()"
        >Submit</x-tassy-ui::button>
    </x-slot>
</x-tassy-ui::modal_livewire>

<x-tassy-ui::modal_livewire name="sample-modal2">
    <x-slot name="title">A Sample Modal from livewire #2</x-slot>
    <x-slot name="body">
        <form
                x-data>
            <p>Known limitation: Only one modal template per page.  This seems fixable (and previously fixed, to boot).</p>

        </form>
    </x-slot>
    <x-slot name="footer">
        <x-tassy-ui::button
                enumStyle='Cancel'
                class="mr-2"

                wire:click="handleCancel()"
        >Cancel</x-tassy-ui::button>
        <x-tassy-ui::button
                enumStyle='Primary'
                wire:click="handlePrimary()"
        >Submit</x-tassy-ui::button>
    </x-slot>
</x-tassy-ui::modal_livewire>

</div>
