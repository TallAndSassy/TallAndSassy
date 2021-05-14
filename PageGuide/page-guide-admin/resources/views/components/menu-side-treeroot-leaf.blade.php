@props(['suburl','label'])
<li>
    <a class="linkFontColor_cssClasses linkFocus_cssClasses flex items-center ml-8 px-2 py-1 leading-5 rounded-md pickedClasses_ifOnThisRoute "
        {!! \TallAndSassy\PageGuide\Components\Lepage::wireSwaplinkInA($suburl) !!}>{!! $label !!}</a>

</li>
