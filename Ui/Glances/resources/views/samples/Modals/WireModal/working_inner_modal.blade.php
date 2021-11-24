{{--This is file: vendor/tallandsassy/tallandsassy/Ui/Glances/resources/views/samples/Modals/WireModal/working_inner_modal.blade.php--}}
<x-tassy-ui::wire-modal>
    <x-slot name="title">
        Hello World
    </x-slot>

    <x-slot name="content">
        Hi! 👋
        Count = {{$counter}}
    </x-slot>

    <x-slot name="buttons">
        {{--        Buttons go here...--}}
        <button wire:click="doIncrement">[Increment]</button>
        <button wire:click="$emit('closeModal')">[Close Modal]</button>
    </x-slot>
</x-tassy-ui::wire-modal>
