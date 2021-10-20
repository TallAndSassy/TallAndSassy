<div>
    @if ($contentIsVisible)
        @php sleep(3); @endphp
        <span class="border bg-green-300">Hard content from First Tab Sample... Should have taken 3 seconds to render the first time cuz of 'sleep' throttle</span>

    @else
        <span>[spinner for {{$tabName}} - pretend this is spinning. This will go away in three seconds if tabs are working]</span>
    @endif
    <div class="border m-2 shadow">
        todo:
        <br>
        Make tabs work on narrow screens, like on main_feb1
    </div>
</div>
