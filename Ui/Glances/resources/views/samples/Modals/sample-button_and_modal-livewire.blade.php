<div>
    <x-tassy-ui::button
        wire:click="handleGoToModal()"
        {{--    wire:click="$set('showModal', true)" // You can look at second half of https://laracasts.com/series/modals-with-the-tall-stack/episodes/6?autoplay=true to remove ajax on close--}}
    enumStyle="Primary"
    class="mt-3"
>
    Click me for livewire modal (show:{{$showModal ? 1 : 0}})!
</x-tassy-ui::button>

@php
//You left about to move LiveWire into Ui
@endphp
<x-tassy-ui::modal_livewire name="sample-modal">
    <x-slot name="title">A Sample Modal from livewire</x-slot>
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

</div>
