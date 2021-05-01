<x-tassy::page-_base>
    {{--  Space out vertically so footer is always at bottom of screen, or below content, whichever is lower
      see: https://stackoverflow.com/questions/59812003/make-footer-fixed-on-the-bottom-with-tailwindcss
    --}}
    <div class="flex flex-col h-screen justify-between bg-gray-100">
        <x-tassy::header.back.index title="{{$title}}"/>
        <main class="mb-auto  bg-gray-100">
            <div class="p-3 lg:p-10 h-full">{{$slot}}</div>
        </main>

        <x-tassy::footer.back.index/>

    </div>

    {{--    <div class="tassy::page-guide.components.page-me bg-gray-100 ">--}}
    {{--        <x-tassy::header.back.index title="{{$title}}"/>--}}

    {{--        <div class="p-10 bg-gray-100 h-full">{{$slot}}</div>--}}

    {{--        <x-tassy::footer.back.index/>--}}
    {{--    </div>--}}
</x-tassy::page-_base>
