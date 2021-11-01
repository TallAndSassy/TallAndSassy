<div>
    @php
    $delaySeconds = 3;
    @endphp
    @if ($snumRenderState == \TallAndSassy\Ui\Glances\Components\EnumRenderState::RENDERED->value)
        @php sleep($delaySeconds); @endphp
        <span class="border bg-green-300">Hard content from First Tab Sample... Should have taken {{$delaySeconds}} seconds to render the first time cuz of hardcoded 'sleep' throttle that is just here as a demo</span>

    @elseif ($snumRenderState == \TallAndSassy\Ui\Glances\Components\EnumRenderState::PLACEHELD->value)
        <x-spinners.working/>
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
