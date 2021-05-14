@props(['suburl', 'svghtml'=>'', 'iconname'=>'', 'iconsizingclasses'=>''])

@php
    $isOnThisRoute = false; //$menutree::isOnThisRoute($menuEntry)
    $pickedClasses_ifOnThisRoute = $isOnThisRoute ? 'picked_classes' : '';
@endphp
<li class=' '>
    <a {!! \TallAndSassy\PageGuide\Components\Lepage::wireSwaplinkInA($suburl) !!} class=" linkFontColor_cssClasses linkFocus_cssClasses {{$isOnThisRoute ? 'font-extrabold text-lg' : ''}} pickedClasses_ifOnThisRoute divNode_cssClasses ">
{{--        @if (!empty($svghtml))--}}
{{--            <div class="mr-1.5">--}}
{{--            {!! $svghtml !!}--}}
{{--            </div>--}}
{{--        @elseif (!empty($iconname))--}}
{{--            @php $IconSizingClasses = 'iconsizingclasses' ? 'iconsizingclasses' : 'IconSizingClasses_Default'; @endphp--}}

{{--            <div class="IconSizingClasses_Default mr-1.5">--}}
{{--                @svg($iconname,'icon_cssClasses'.' '.'IconSizingClasses')--}}
{{--            </div>--}}
{{--        @endif--}}
{{--            --}}{{-- If you see something like: ErrorException Svg by name "o-homeasdf" from set "heroicons" not found...--}}
{{--            --}}{{-- [ ] Did you put 'x-' in fro                nt.  You shouldn't use 'heroicon-o-home', not 'x-heroicon-o-home'--}}
{{--            --}}{{-- [ ] Did you need to install this font kit, like 'composer require blade-ui-kit/blade-heroicons' as specified on the --}}
{{--            --}}{{--     https://blade-ui-kit.com/blade-icons/heroicon-o-home                            --}}
{{--            --}}{{-- Try visiting https://blade-ui-kit.com/blade-icons.--}}
{{--            --}}{{-- You can basically shrink the icon, and maybe increase it, but we need standard spacing, so we wrap it in a w-6 div.   --}}
        {!!  $slot !!}
    </a>
</li>
