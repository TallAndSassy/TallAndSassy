<div class="border shadow mt-2 p-2 h-full">
    Welcome to the pages that explains models
    <hr>
    Here we show the usage of a simply blade-based modal, with a smidge of Alpine to make it dynamic. Importantly, this
    is not a livewire model that might talk to the database.
    <p></p>

    <x-tassy-ui::button
        onclick="$modals.showBladeModalNamed('sample-modal')"
        enumStyle="Primary"
    >
        Click me!
    </x-tassy-ui::button>
    <hr>
    So, launch a modal, make a button or link, and add an on-click
    <pre>
        <code class="html">
        onclick="$modals.showBladeModalNamed('sample-modal')"
        </code>
    </pre>
    <pre>
        <code class="html">
            @php
                $sample =<<<EOD
                    <x-tassy-ui::modal name="sample-modal">
                        <x-slot name="title">A Sample Modal</x-slot>
                        <x-slot name="body">
                            <p>Here are some details about our stuff</p>
                        </x-slot>
                        <x-slot name="footer">
                            <x-tassy-ui::button
                                type='cancel'
                                @click="show = false">Go Away</x-tassy-ui::button>
                        </x-slot>
                    </x-tassy-ui::modal>
                EOD;
                print htmlspecialchars($sample);
            @endphp

        </code>
    </pre>

    {{--    Look at http://127.0.0.1:8002/grok/ElegantTechnologies/Grok/grok in Teamsy10--}}
</div>
{{--        Put modals at bottom of page avoid issues  --}}
@include('tassy-ui::samples.Modals.sample-modal-blade')
