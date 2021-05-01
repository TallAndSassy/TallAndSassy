<x-tassy::page-_base >
    {{--  Space out vertically so footer is always at bottom of screen, or below content, whichever is lower
      see: https://stackoverflow.com/questions/59812003/make-footer-fixed-on-the-bottom-with-tailwindcss
    --}}
    <div class="flex flex-row flex-wrap h-screen">
        {{-- Left Col        --}}
        <div class="flex-shrink-0 bg-red-200 w-48">
            Left


        </div>


        {{-- Right Col       --}}
        <div class="flex-shrink flex-grow flex flex-col  justify-between bg-blue-100 w-auto" >
            {{-- Title and Top Menu            --}}
            <x-tassy::header.back.index title="{{$title}} class"/>

            {{-- Body            --}}
            <main class="mb-auto  bg-gray-100">
                <div class="p-10 h-full">{{$slot}}</div>
            </main>

            {{-- Footer--}}
            <x-tassy::footer.back.index/>
        </div>
    </div>

    {{--    <div class="tassy::page-guide.components.page-me bg-gray-100 ">--}}
    {{--        <x-tassy::header.back.index title="{{$title}}"/>--}}

    {{--        <div class="p-10 bg-gray-100 h-full">{{$slot}}</div>--}}

    {{--        <x-tassy::footer.back.index/>--}}
    {{--    </div>--}}
</x-tassy::page-_base>


{{--<x-tassy::page-_base>--}}

{{--    --}}{{-- Header--}}
{{--    <x-tassy::header.back.index title="{{$title}}"/>--}}

{{--    --}}{{-- Below Header--}}

{{--    --}}{{-- SideNav--}}
{{--    <div class="beSideBar flex flex-shrink-0">--}}
{{--        <livewire:tassy::livewire.sidenav/>--}}
{{--        <livewire:tassy::livewire.lowernav/>--}}

{{--        --}}{{-- Content --}}
{{--        --}}{{--  Space out vertically so footer is always at bottom of screen, or below content, whichever is lower--}}
{{--        see: https://stackoverflow.com/questions/59812003/make-footer-fixed-on-the-bottom-with-tailwindcss--}}
{{--        It seems to work good-enough.--}}
{{--        --}}
{{--        <div class="flex flex-col h-screen justify-between bg-gray-100 w-screen">--}}
{{--            <main class="mb-auto p-2">{{$slot}}</main>--}}
{{--             <div cass="moveFooter "><x-tassy::footer.back.index/></div>--}}
{{--        </div>--}}
{{--        <div class="h-0 flex-1 flex flex-col overflow-y-auto">--}}
{{--            <div class="flex-1 bg-gray-800">--}}
{{--                --}}{{----}}{{--                        @livewire('sidenav')--}}

{{--            </div>--}}
{{--            <div class="flex-shrink-0 flex bg-gray-700 align-bottom">--}}
{{--                --}}{{----}}{{--                        @livewire('lowernav')--}}
{{--            </div>--}}
{{--        </div>--}}

{{--    </div>--}}

{{--    --}}{{----}}{{-- Content --}}
{{--    <div class="flex flex-col h-screen justify-between bg-gray-100">--}}
{{--        <main class="mb-auto  bg-red-100">Admin Page</main>--}}
{{--        <x-tassy::footer.back.index/>--}}
{{--    </div>--}}

{{--</x-tassy::page-_base>--}}
