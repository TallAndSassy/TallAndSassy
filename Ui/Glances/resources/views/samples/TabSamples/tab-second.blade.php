<div>

            @if ($enumRenderState_Placeheld_Rendered == 'Rendered')
                    @php sleep(1); @endphp
                    <span>Smoe more content, slightly fast glances hard to build Content...</span>

            @elseif ($enumRenderState_Placeheld_Rendered == 'Placeheld')
                    <span>[spinner for {{$tabName}}]</span>
            @else
                    <span>I'm bad at enums</span>
            @endif
</div>

