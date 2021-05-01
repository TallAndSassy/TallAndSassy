<div>

    @if (! $isLivewire)
        <x-tassy::page-admin>
            <x-slot name="title">
                {!! $title !!}
            </x-slot>
            {!! $slot !!}
        </x-tassy::page-admin>
    @else
        {{-- <x-tassy::page-admin>--}}
        {!! $slot !!}
    @endif
</div>

