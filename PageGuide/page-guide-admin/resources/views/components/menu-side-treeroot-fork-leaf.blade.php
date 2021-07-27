@props(['suburl','label'])
<li>
    @php
        $isOnThisRoute = \TallAndSassy\PageGuide\MenuTree::IsSubUrlMeOrBelow($suburl);
        $pickedClasses_ifOnThisRoute = $isOnThisRoute ? 'picked_classes' : '';
    @endphp
    <a class="linkFontColor_cssClasses   linkFocus_cssClasses ml-10 {{$pickedClasses_ifOnThisRoute}} text-sm"
        {!! \TallAndSassy\PageGuide\Components\Lepage::wireSwaplinkInA($suburl) !!}>{!! $label !!}</a>

</li>
