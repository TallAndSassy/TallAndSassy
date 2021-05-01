<div>
    @php
    // Next: Add some options to align in two-column grid (but wait until real)
    $hint = isset($hint) ? $hint : null;
    @endphp
    <span class="text-gray-600">{{$label}}</span><span class="text-gray:400">:</span>
    <span class="text-gray-800">{{$value}}</span>
    @if($hint)
        <x-tassy::ui.looks.hint>{{$hint}}</x-grok::ui.looks.hint>
    @endif
</div>
