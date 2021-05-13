{{--INPUT: EnumType Top...--}}
<div src="vendor/tallandsassy/page-guide/resources/views/admin/menutree.blade.php">

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
    <style>
        /* Do not show > reveal */
        summary.jDetails_summary::marker {
            display: none;
        }

        summary.jDetails_summary::-webkit-details-marker {
            display: none;
        }
    </style>

    <nav class=" flex flex-1  {{ $arrAttributes['class']}}">
        <ul class="pt-2 w-full">

            @if ($handle == 'upper')
                @include('tassy::admin.menu-side-upper-above')
            @endif
            @if ($handle == 'lower')
                @include('tassy::admin.menu-side-lower-above')
            @endif
            @php $menuKeys = array_keys($menutree->asrMenus);;@endphp
            @for ($i = 0; $i < count($menuKeys); $i++)
                @php
                    $key = $menuKeys[$i];
                    $menuEntry = $menutree->asrMenus[$key];
                    if ($key == 'admin.salad.fruit') {
                        #dd($menuEntry);
                    }
                    $pickedClasses_ifOnThisRoute = \TallAndSassy\PageGuide\MenuTree::isOnThisRoute($menuEntry) ? $picked_classes : '';
                @endphp
                @if ($menutree::isTopLeaf($menuEntry))
                    <li class='{{$liWrapper_1}} '>
                        <a {!! \TallAndSassy\PageGuide\Components\Lepage::wireSwaplinkInA($menuEntry['Url']) !!} class="{{$firstLeaf_cssClasses}} {{$menutree::isOnThisRoute($menuEntry) ? 'font-extrabold text-lg' : ''}} {{$pickedClasses_ifOnThisRoute}}">
                            @if (! empty($menuEntry['SvgHtml']) )
                                {!! $menuEntry['SvgHtml'] !!}
                            @elseif (! empty($menuEntry['IconName']) )
                                {{-- If you see something like: ErrorException Svg by name "o-homeasdf" from set "heroicons" not found...--}}
                                {{-- [ ] Did you put 'x-' in front.  You shouldn't use 'heroicon-o-home', not 'x-heroicon-o-home'--}}
                                {{-- [ ] Did you need to install this font kit, like 'composer require blade-ui-kit/blade-heroicons' as specified on the --}}
                                {{--     https://blade-ui-kit.com/blade-icons/heroicon-o-home                            --}}
                                {{-- Try visiting https://blade-ui-kit.com/blade-icons.--}}
                                {{-- You can basically shrink the icon, and maybe increase it, but we need standard spacing, so we wrap it in a w-6 div.   --}}
                                @php $IconSizingClasses = $menuEntry['IconSizingClasses'] ? $menuEntry['IconSizingClasses'] : $IconSizingClasses_Default; @endphp
                                <div class="{{$IconSizingClasses_Default}}">
                                    @svg($menuEntry['IconName'],$icon_cssClasses.' '.$IconSizingClasses)
                                </div>
                            @endif
                            <span class=" {{$firstLeafText_cssClasses}} ">{{$menuEntry['Label']}}</span>
                        </a>
                    </li>
                @elseif ($menutree::isTopNode($menuEntry))
                    @php
                    $isActiveRouteUnderMe = $menutree->isActiveRouteUnderMe($menuEntry);
                    @endphp
                    <li class='{{$liWrapper_1}}'>
                        <details class="" {{$isActiveRouteUnderMe ? 'open' : ''}}>
                            <summary class="{{$jDetails_summary_cssClasses}}">
                                <div class="FYI_subdiv_must_be_here_for_safari_Nov_20 {{$jDetails_summary_subdiv_cssClasses}}">
                                @if (! empty($menuEntry['SvgHtml']) )
                                    {!! $menuEntry['SvgHtml'] !!}
                                @elseif (! empty($menuEntry['IconName']) )
                                    {{-- If you see something like: ErrorException Svg by name "o-homeasdf" from set "heroicons" not found...--}}
                                    {{-- [ ] Did you put 'x-' in front.  You should use 'heroicon-o-home', not 'x-heroicon-o-home'--}}
                                    {{-- [ ] Did you need to install this font kit, like 'composer require blade-ui-kit/blade-heroicons' as specified on the --}}
                                    {{--     https://blade-ui-kit.com/blade-icons/heroicon-o-home                            --}}
                                    {{-- Try visiting https://blade-ui-kit.com/blade-icons.--}}
                                    {{-- You can basically shrink the icon, and maybe increase it, but we need standard spacing, so we wrap it in a w-6 div.   --}}
                                    @php $IconSizingClasses = $menuEntry['IconSizingClasses'] ? $menuEntry['IconSizingClasses'] : $IconSizingClasses_Default; @endphp
                                    <div class="{{$IconSizingClasses_Default}}">
                                        @svg($menuEntry['IconName'],$icon_cssClasses.' '.$IconSizingClasses)
                                    </div>
                                @endif

                                <div class=" {{$firstLeafText_cssClasses}}">{{$menuEntry['Label']}}</div>
                                </div>
                            </summary>
                            <div class="jDetails_body {{$jDetails_body_cssClasses}}">
                                <ul>
                                    @php
                                        #$hasMoreSubMenus = true; #presumably, the first time, we'll see
                                        $hasMoreSubMenus = isset($menuKeys[$i+1]) && !$menutree::isTop( $menutree->asrMenus[$menuKeys[$i+1]]);#presumably, the first time, we'll see it, but if not, lets recovery gracefully
                                        $depth = 2;
                                        $lastItemWasType = null;
                                    @endphp
                                    @while ($hasMoreSubMenus || $i > 2000)
                                        @php

                                            $hasMoreSubMenus = isset($menuKeys[$i+1]) && !$menutree::isTop( $menutree->asrMenus[$menuKeys[$i+1]]);

                                        @endphp
                                        @if ($hasMoreSubMenus)
                                            @php  $i++; $key = $menuKeys[$i];
                                            $menuEntry = $menutree->asrMenus[$key];


                                            @endphp
                                            @if ($menutree::isGroup($menuEntry))
                                                @php
                                                    if (is_null($lastItemWasType) || $lastItemWasType == 'Link') {
                                                        $depth = 2; // Groups don't go more than one deeper, a new group resets
                                                        $lastItemWasType = 'Group';
                                                    }
                                                @endphp
                                                <li>
                                                    <div
                                                        class="{{$secondBreak_cssClasses}}">{{$menuEntry['Label']}}</div>
                                                </li>
                                            @elseif ($menutree::isLink($menuEntry))
                                                @php
                                                    if ($lastItemWasType == 'Group') {
                                                        $depth = 3;
                                                        $lastItemWasType = 'Link';
                                                    }
                                                    $pickedClasses_ifOnThisRoute = \TallAndSassy\PageGuide\MenuTree::isOnThisRoute($menuEntry) ? $picked_classes : '';
                                                @endphp
                                                <li>
                                                    <a class="{{($depth == 2) ? $secondLeaf_cssClasses : ($depth == 3 ? $thirdLeaf_cssClasses : dd([__FILE__,__LINE__,"Too deep"]))}}  {{$pickedClasses_ifOnThisRoute}} "
                                                        {!! \TallAndSassy\PageGuide\Components\Lepage::wireSwaplinkInA($menuEntry['Url']) !!}>{{$menuEntry['Label']}}</a>
                                                </li>
                                            @elseif ($menutree::isTop($menuEntry))
                                                {{--  Do Nothing--}}
                                                @php dd([__FILE__,__LINE__,"YIKES:",'i'=>$i, '$key'=>$key, '$menuEntry'=>$menuEntry, 'menutree'=>$menutree]); @endphp
                                            @endif
                                        @endif
                                    @endwhile
                                </ul>
                            </div>
                        </details>
                    </li>
                @else
                    @php dump([__FILE__,__LINE__,"YIKES:",'i'=>$i, '$key'=>$key, '$menuEntry'=>$menuEntry, 'menutree'=>$menutree]); @endphp
                @endif
            @endfor
                @if ($handle == 'upper')
                    @include('tassy::admin.menu-side-upper-below')
                    @if(config('tassy.admin.DoSamples_Side_Blade'))
                        @include('tassy::samples/menu-side/sample_menu')
                    @endif

                @endif
                @if ($handle == 'lower')
                    @include('tassy::admin.menu-side-lower-below')
                @endif
        </ul>
    </nav>
</div>
