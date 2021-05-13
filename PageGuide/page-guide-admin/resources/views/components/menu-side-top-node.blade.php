@props(['svghtml'=>'', 'iconname'=>'', 'iconsizingclasses'=>''])
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
@php
    $isActiveRouteUnderMe = false;//$menutree->isActiveRouteUnderMe($menuEntry);
@endphp
<li class='{{$liWrapper_1}}'>
    <details class="" {{$isActiveRouteUnderMe ? 'open' : ''}}>
        <summary class="{{$jDetails_summary_cssClasses}}">
            <div class="FYI_subdiv_must_be_here_for_safari_Nov_20 {{$jDetails_summary_subdiv_cssClasses}}">
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

                <div class=" {{$firstLeafText_cssClasses}}">{{$slot}}</div>
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
                              Do Nothing
                            @php dd([__FILE__,__LINE__,"YIKES:",'i'=>$i, '$key'=>$key, '$menuEntry'=>$menuEntry, 'menutree'=>$menutree]); @endphp
                        @endif
                    @endif
                @endwhile
            </ul>
        </div> 
    </details>
</li>
