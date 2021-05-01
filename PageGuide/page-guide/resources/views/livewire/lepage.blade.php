<div src="vendor/tallandsassy/page-guide/resources/views/livewire/lepage.blade.php">
{{-- Header--}}

    <div class="h-16  flex bg-gray-100 ">
        <div class="hidden sm:block p-3  ">
            <x-tassy::header.back.title>{{$title}}  </x-tassy::header.back.title>
        </div>

{{--        {!! $menuHtml !!}--}}
{{--        <x-tassy::header.back.menu class="lg:pt-1"/>--}}
        @include('tassy::admin.menu', ['class'=>"lg:pt-1"])

    </div>
    <x-tassy::header.back.title class="sm:hidden">{{$title}}  </x-tassy::header.back.title>

    {{--Body--}}
    <main class="mb-auto  bg-gray-100">
        <div class="p-0 sm:p-3 h-full">{!! $bodyHtml !!}</div>
    </main>


</div>
