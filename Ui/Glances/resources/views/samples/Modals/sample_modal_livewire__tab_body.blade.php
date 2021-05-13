{{--        Put modals at bottom of page avoid issues  --}}


<div class="border shadow mt-2 p-2 h-full">
    Welcome to the pages that explains models that are derived from livewire
    <hr>
{{--    @once--}}
{{--        @php--}}
{{--        // You might think this would work, but you need to call this from outside the blade. \TallAndSassy\Ui\Glances\Samples\Modals\SampleButtonModal_LivewireController::SelfRegister();--}}
{{--        @endphp--}}
{{--    @endonce--}}
    @livewire('tassy-ui::Samples.Modals.SampleButtonModal_CustomAlias')
</div>

