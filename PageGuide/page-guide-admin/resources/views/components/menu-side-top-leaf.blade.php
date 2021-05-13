@props(['suburl', 'svghtml'=>'', 'iconname'=>'', 'iconsizingclasses'=>''])
@php
            $liWrapper_1 = $liWrapper_2 = ' pr-0 ';
               $liWrapper_3 = ' pr-1 pl-2  ';  // feels like should be below, not in li

               $linkFontColor_cssClasses = 'text-gray-300';
               $linkFocus_cssClasses = ' group flex pr-1 pl-2 rounded-md focus:outline-none focus:bg-gray-700 transition ease-in-out duration-150';

               $picked_classes = 'bePickedLink bg-gray-500 rounded'; // think, current page
               $placeholderFontColor_cssClasses = 'text-gray-400';



               $divNode_cssClasses     = "$linkFontColor_cssClasses        $linkFocus_cssClasses no-underline group flex items-center px-2 py-2 text-lg leading-5 font-bold   ";

               $firstLeaf_cssClasses   = "$linkFontColor_cssClasses        $linkFocus_cssClasses p-2 text-lg leading-5 font-bold    ";
               $firstLeafText_cssClasses = "pl-2 pt-0.5";
               $secondLeaf_cssClasses  = "$linkFontColor_cssClasses        $linkFocus_cssClasses group flex items-center ml-8 px-2 py-1 text-sm leading-5 rounded-md  ";
               $secondBreak_cssClasses = "$placeholderFontColor_cssClasses ml-10   text-base font-bold ";
               $thirdLeaf_cssClasses   = "$linkFontColor_cssClasses        $linkFocus_cssClasses ml-12  ";
               $IconSizingClasses_Default = 'beIconWrapper w-6 h-6';
               //$IconSizingClasses = $menuEntry['IconSizingClasses'] ? $menuEntry['IconSizingClasses'] : $IconSizingClasses_Default;
               $icon_cssClasses = "topLevelNavIcon  $placeholderFontColor_cssClasses ";
               $jDetails_summary_cssClasses = "jDetails_summary   cursor-pointer";
               $jDetails_summary_subdiv_cssClasses = "  $divNode_cssClasses";
               $jDetails_body_cssClasses = 'ml-0 ';


@endphp
{{--isTopLeaf--}}
@php
    //$suburl = 'sampleTopLeaf_page';
    $isOnThisRoute = false; //$menutree::isOnThisRoute($menuEntry)
    $pickedClasses_ifOnThisRoute = $isOnThisRoute ? $picked_classes : '';
@endphp
<li class='{{$liWrapper_1}} '>
    {{--        <a {!! \TallAndSassy\PageGuide\Components\Lepage::wireSwaplinkInA($menuEntry['Url']) !!} class="{{$firstLeaf_cssClasses}} {{$menutree::isOnThisRoute($menuEntry) ? 'font-extrabold text-lg' : ''}} {{$pickedClasses_ifOnThisRoute}}">--}}
    <a {!! \TallAndSassy\PageGuide\Components\Lepage::wireSwaplinkInA($suburl) !!} class="{{$firstLeaf_cssClasses}} {{$isOnThisRoute ? 'font-extrabold text-lg' : ''}} {{$pickedClasses_ifOnThisRoute}}">
        @if (!empty($svghtml))
            <div class="mr-1.5">
            {!! $svghtml !!}
            </div>
        @elseif (!empty($iconname))
            @php $IconSizingClasses = $iconsizingclasses ? $iconsizingclasses : $IconSizingClasses_Default; @endphp

            <div class="{{$IconSizingClasses_Default}} mr-1.5">
                @svg($iconname,$icon_cssClasses.' '.$IconSizingClasses)
            </div>
        @endif
{{--            --}}{{-- If you see something like: ErrorException Svg by name "o-homeasdf" from set "heroicons" not found...--}}
{{--            --}}{{-- [ ] Did you put 'x-' in front.  You shouldn't use 'heroicon-o-home', not 'x-heroicon-o-home'--}}
{{--            --}}{{-- [ ] Did you need to install this font kit, like 'composer require blade-ui-kit/blade-heroicons' as specified on the --}}
{{--            --}}{{--     https://blade-ui-kit.com/blade-icons/heroicon-o-home                            --}}
{{--            --}}{{-- Try visiting https://blade-ui-kit.com/blade-icons.--}}
{{--            --}}{{-- You can basically shrink the icon, and maybe increase it, but we need standard spacing, so we wrap it in a w-6 div.   --}}
        {{$slot}}
    </a>
</li>
