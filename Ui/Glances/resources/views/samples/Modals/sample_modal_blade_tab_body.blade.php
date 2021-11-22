<div class="border shadow mt-2 p-2 h-full">


    <x-tassy-ui::button
        onclick="$modals.showBladeModalNamed('sample-modal')" {{--        see vendor/tallandsassy/tallandsassy/Ui/resources/js/app.js--}}
        enumStyle="Primary"
    >
        Click me!
    </x-tassy-ui::button>

    <x-tassy-ui::button
            onclick="$modals.showBladeModalNamed('sample-modal2')"
            enumStyle="Primary"
    >
        Click me, too, but notice bug that it ignores modal name.
    </x-tassy-ui::button>

</div>


{{--        Put modals at bottom of page avoid issues  --}}
<x-tassy-ui::modal_blade name="sample-modal">
    <x-slot name="title">A Sample Modal</x-slot>
    <x-slot name="body">
        <p>Here are some details about our stuff</p>
    </x-slot>
    <x-slot name="footer">
        <x-tassy-ui::button
                enumStyle='Cancel'
                @click="show = false">Go Away</x-tassy-ui::button>
    </x-slot>
</x-tassy-ui::modal_blade>

