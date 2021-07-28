@props(['svghtml'=>'', 'iconname'=>'', 'iconsizingclasses'=>'', 'label', 'thisVeryLocalHandleForThisMenuTree'])

@php

    $isActiveRouteUnderMe =  \TallAndSassy\PageGuide\MenuTree::IsThisTheSameMenuHandle_asRouteWeAreVisiting($thisVeryLocalHandleForThisMenuTree)
@endphp
<li class=''>
    <details class="" {{$isActiveRouteUnderMe ? 'open' : ''}}>
        <summary class="jDetails_summary cursor-pointer">
            <div class="FYI_subdiv_must_be_here_for_safari_Nov_20  text-gray-400 linkFocus_cssClasses no-underline group flex items-center px-2 py-2 text-lg leading-5 font-bold ">
                {!!  $label !!}
            </div>
        </summary>
        <div class="jDetails_body jDetails_body_cssClasses">
            <ul>
                {!! $slot !!}
            </ul>
        </div>
    </details>
</li>
