<div>
    @if ($contentIsVisible)
        @php sleep(3); @endphp
        <span>Hard content from First Tab Sample...</span>
    @else
        <span>[spinner for {{$tabName}}]</span>
    @endif
    <div class="border m-2 shadow">
        todo:
        <br>
        Make tabs work on narrow screens, like on main_feb1
    </div>
</div>
