@props(['suburl', 'svghtml'=>'', 'iconname'=>'', 'iconsizingclasses'=>''])

@php
    // INPUT: suburl
    $isOnThisRoute = \TallAndSassy\PageGuide\MenuTree::IsSubUrlMeOrBelow($suburl);
    $pickedClasses_ifOnThisRoute = $isOnThisRoute ? 'picked_classes' : '';

@endphp
<li class=' '>
    <a {!! \TallAndSassy\PageGuide\Components\Lepage::wireSwaplinkInA($suburl) !!}
       class="
       linkFontColor_cssClasses text-gray-300
       linkFocus_cssClasses group flex pr-1 pl-2 rounded-md focus:outline-none focus:bg-gray-700 transition ease-in-out duration-150
        {{$isOnThisRoute ? 'font-extrabold text-lg' : ''}} {{$pickedClasses_ifOnThisRoute}}
        divNode_cssClasses o-underline group flex items-center px-2 py-2 text-lg leading-5 font-bold
        "
    >
{{--        Hey: 10/21' These .css classes should (maybe??) exists. They are spelled out in menutree.blade.php, but I'm struggling on how to centralize this.
            So, I'm repeating the tailwind classes here.  Probably good-enough, for now.
--}}

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
