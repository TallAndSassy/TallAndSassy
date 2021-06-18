@props(['suburl','label'])
<li>
    <a class="linkFontColor_cssClasses   linkFocus_cssClasses ml-10 pickedClasses_ifOnThisRoute text-sm"
        {!! \TallAndSassy\PageGuide\Components\Lepage::wireSwaplinkInA($suburl) !!}>{!! $label !!}</a>

</li>
