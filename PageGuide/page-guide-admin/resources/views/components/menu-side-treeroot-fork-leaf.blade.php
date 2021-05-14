@props(['suburl','label'])
<li>
    <a class="linkFontColor_cssClasses   linkFocus_cssClasses ml-12 pickedClasses_ifOnThisRoute "
        {!! \TallAndSassy\PageGuide\Components\Lepage::wireSwaplinkInA($suburl) !!}>{!! $label !!}</a>

</li>
