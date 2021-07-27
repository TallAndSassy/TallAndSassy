@props(['suburl','label'])
<li>
    @php
    $isOnThisRoute = \TallAndSassy\PageGuide\MenuTree::IsSubUrlMeOrBelow($suburl);
    $pickedClasses_ifOnThisRoute = $isOnThisRoute ? 'picked_classes' : '';
    @endphp
    <a class="linkFontColor_cssClasses linkFocus_cssClasses flex items-center ml-8 px-2 py-1 leading-5 rounded-md {{$pickedClasses_ifOnThisRoute}} "
        {!! \TallAndSassy\PageGuide\Components\Lepage::wireSwaplinkInA($suburl) !!}>{!! $label !!}</a>

</li>
