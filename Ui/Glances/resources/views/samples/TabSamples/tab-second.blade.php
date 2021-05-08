<div>
    @if ($contentIsVisible)
        @php sleep(1); @endphp
        <span>Smoe more content, slightly fast glances hard to build Content...</span>
    @else
        <span>[spinner for {{$tabName}}]</span>
    @endif
</div>

