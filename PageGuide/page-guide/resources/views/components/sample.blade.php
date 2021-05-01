<div>
    Sample --BEGIN--
    
    This is a reusable component. Other blades can access it like so:
    {{--
    <x-bladeprefix::sample/>

    -or-
    <x-bladeprefix::sample>
        Bob
    </x-bladeprefix::sample>

     -or-
    <x-bladeprefix::sample>
        <x-slot name='greetings'>
        Hello
        </x-slot>
        Bob
    </x-bladeprefix::sample>
    --}}

    Where 'sample' is whatever you name this file


    {{--
    $greetings = 'Hello'
    $slot = 'Bob'
    --}}

    {{$greetings}} {{$slot}}
    {{-- Hello Bob  --}}

    Sample --END--
</div>
