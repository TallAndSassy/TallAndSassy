<div>
    @php
    $delaySeconds = 3;
    @endphp
    @if ($enumRenderState_Placeheld_Rendered == 'Rendered')
        @php sleep($delaySeconds); @endphp
        <span class="border bg-green-300">Hard content from First Tab Sample... Should have taken {{$delaySeconds}} seconds to render the first time cuz of hardcoded 'sleep' throttle that is just here as a demo</span>

    @elseif ($enumRenderState_Placeheld_Rendered == 'Placeheld')
        <span>[spinner for {{$tabName}} - pretend this is spinning. This will go away in {{$delaySeconds}} seconds if deferred Livewire as tabs are working]</span>
    @else
        <span>I'm bad at enums</span>
    @endif
    <div class="border m-2 shadow">
        Livewire based view count: {{$view_count}}
        <br>
        $tabName: {{$tabName }}
        <br>
        $tabSlug: {{$tabSlug }}

    </div>
</div>
