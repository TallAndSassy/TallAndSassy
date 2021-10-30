<div>
{{--    <x-tassy-ui::tab-container defaultSlug="a">--}}

{{--        <x-tassy-ui::tab name="Students1" slug="a">--}}
{{--            <h1>Student Stuff</h1>--}}
{{--        </x-tassy-ui::tab >--}}

{{--        <x-tassy-ui::tab name="Notes2" slug="b">--}}
{{--            <h1>Note stuff</h1>--}}
{{--        </x-tassy-ui::tab >--}}

{{--        <x-tabs.tab name="Finance">--}}
{{--            <h1>Finance stuff</h1>--}}
{{--        </x-tabs.tab>--}}

{{--    </x-tassy-ui::tab-container>--}}

    <x-tassy-ui::tab-container defaultSlug="second">

        <x-tassy-ui::tab name="First" :isLivewire="true" slug="first">
            <livewire:tassy-ui:Sample_Tab1_Tab :tabName="'First'" :tabSlug="'first'"/>
        </x-tassy-ui::tab>
        <x-tassy-ui::tab name="Second" slug='second' :isLivewire="true">
            <livewire:tassy-ui:Sample_Tab2_Tab :tabName="'Second'" :tabSlug="'second'"/>
        </x-tassy-ui::tab>
        <x-tassy-ui::tab name="Third" slug="third">
            <div class="border shadow mt-2 p-2 ">
                Local body, not livewire
            </div>
        </x-tassy-ui::tab>
        <x-tassy-ui::tab name="Modal-Blade Sample" slug="mbs">
            @include('tassy-ui::samples/Modals/sample_modal_blade_tab_body')
        </x-tassy-ui::tab>
        <x-tassy-ui::tab name="Modal-Livewire Sample" slug="mls">
            @include('tassy-ui::samples/Modals/sample_modal_livewire__tab_body')
        </x-tassy-ui::tab>
        <x-tassy-ui::tab name="Tabbed Tech Check" slug="ttc">
            <div class="border shadow mt-2 p-2 ">
                Does alpine work?
               @include('tassy-ui::samples/TechBase/Status__')
            </div>
        </x-tassy-ui::tab>
        <x-tassy-ui::tab name="UI" slug="ui">
            <div class="border shadow mt-2 p-2 ">
                @include(('tassy-ui::samples/UI/UISample__Page'))
            </div>
        </x-tassy-ui::tab>
    </x-tassy-ui::tab-container>





</div>

