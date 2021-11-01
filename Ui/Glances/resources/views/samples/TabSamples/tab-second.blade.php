<div>

    @if ($snumRenderState == \TallAndSassy\Ui\Glances\Components\EnumRenderState::RENDERED->value)
                    @php sleep(1); @endphp
                    <span>Smoe more content, slightly fast glances hard to build Content...</span>

    @elseif ($snumRenderState == \TallAndSassy\Ui\Glances\Components\EnumRenderState::PLACEHELD->value)
        <x-spinners.loading/>
            @else
                    <span>I'm bad at enums</span>
            @endif
</div>

