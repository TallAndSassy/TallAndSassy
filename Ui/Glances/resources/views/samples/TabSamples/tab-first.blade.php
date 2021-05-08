<div>
    JJ, you left off wanting to
    A) Make the tabs reflect our established traditional tabs, visually
    1) Select tab per URL. Careful, keep it local.
    @if ($contentIsVisible)
        @php sleep(3); @endphp
        <span>Hard content from First Tab Sample...</span>
    @else
        <span>[spinner for {{$tabName}}]</span>
    @endif
</div>
