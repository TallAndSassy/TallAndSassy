@props(['svghtml'=>'', 'iconname'=>'', 'iconsizingclasses'=>'', 'label'])
{{--isTopLeaf--}}
@php
    //$suburl = 'sampleTopLeaf_page';
    $isOnThisRoute = false; //$menutree::isOnThisRoute($menuEntry)
    $pickedClasses_ifOnThisRoute = $isOnThisRoute ? $picked_classes : '';
@endphp
@php
    $isActiveRouteUnderMe = false;//$menutree->isActiveRouteUnderMe($menuEntry);
@endphp
<li class=''>
    <details class="" {{$isActiveRouteUnderMe ? 'open' : ''}}>
        <summary class="jDetails_summary">
            <div class="FYI_subdiv_must_be_here_for_safari_Nov_20  text-gray-400         linkFocus_cssClasses no-underline group flex items-center px-2 py-2 text-lg leading-5 font-bold ">
                {!!  $label !!}
            </div>
        </summary>
        <div class="jDetails_body jDetails_body_cssClasses">
            <ul>
                {!! $slot !!}
            </ul>
        </div>
{{--                @php--}}
{{--                    #$hasMoreSubMenus = true; #presumably, the first time, we'll see--}}
{{--                    $hasMoreSubMenus = isset($menuKeys[$i+1]) && !$menutree::isTop( $menutree->asrMenus[$menuKeys[$i+1]]);#presumably, the first time, we'll see it, but if not, lets recovery gracefully--}}
{{--                    $depth = 2;--}}
{{--                    $lastItemWasType = null;--}}
{{--                @endphp--}}
{{--                @while ($hasMoreSubMenus || $i > 2000)--}}
{{--                    @php--}}

{{--                        $hasMoreSubMenus = isset($menuKeys[$i+1]) && !$menutree::isTop( $menutree->asrMenus[$menuKeys[$i+1]]);--}}

{{--                    @endphp--}}
{{--                    @if ($hasMoreSubMenus)--}}
{{--                        @php  $i++; $key = $menuKeys[$i];--}}
{{--                                            $menuEntry = $menutree->asrMenus[$key];--}}


{{--                        @endphp--}}
{{--                        @if ($menutree::isGroup($menuEntry))--}}
{{--                            @php--}}
{{--                                if (is_null($lastItemWasType) || $lastItemWasType == 'Link') {--}}
{{--                                    $depth = 2; // Groups don't go more than one deeper, a new group resets--}}
{{--                                    $lastItemWasType = 'Group';--}}
{{--                                }--}}
{{--                            @endphp--}}
{{--                            <li>--}}
{{--                                <div--}}
{{--                                    class="{{$secondBreak_cssClasses}}">{{$menuEntry['Label']}}</div>--}}
{{--                            </li>--}}
{{--                        @elseif ($menutree::isLink($menuEntry))--}}
{{--                            @php--}}
{{--                                if ($lastItemWasType == 'Group') {--}}
{{--                                    $depth = 3;--}}
{{--                                    $lastItemWasType = 'Link';--}}
{{--                                }--}}
{{--                                $pickedClasses_ifOnThisRoute = \TallAndSassy\PageGuide\MenuTree::isOnThisRoute($menuEntry) ? $picked_classes : '';--}}
{{--                            @endphp--}}
{{--                            <li>--}}
{{--                                <a class="{{($depth == 2) ? $secondLeaf_cssClasses : ($depth == 3 ? $thirdLeaf_cssClasses : dd([__FILE__,__LINE__,"Too deep"]))}}  {{$pickedClasses_ifOnThisRoute}} "--}}
{{--                                    {!! \TallAndSassy\PageGuide\Components\Lepage::wireSwaplinkInA($menuEntry['Url']) !!}>{{$menuEntry['Label']}}</a>--}}
{{--                            </li>--}}
{{--                        @elseif ($menutree::isTop($menuEntry))--}}
{{--                              Do Nothing--}}
{{--                            @php dd([__FILE__,__LINE__,"YIKES:",'i'=>$i, '$key'=>$key, '$menuEntry'=>$menuEntry, 'menutree'=>$menutree]); @endphp--}}
{{--                        @endif--}}
{{--                    @endif--}}
{{--                @endwhile--}}
{{--            </ul>--}}
{{--        </div>--}}
    </details>
</li>
