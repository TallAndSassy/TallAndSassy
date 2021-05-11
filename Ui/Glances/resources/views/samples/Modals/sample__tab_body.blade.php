<div class="border shadow mt-2 p-2 h-full">
    Welcome to the pages that explains models
    <hr>
    Here we show the usage of a simply blade-based modal, with a smidge of Alpine to make it dynamic. Importantly, this
    is not a livewire model that might talk to the database.
    <p></p>
    <x-tassy-ui::button
        onclick="$modals.showBladeModalNamed('sample-modal')"
        type="primary"
    >
        Click me!
    </x-tassy-ui::button>
</div>
