@props(['suburl','label'])
<li>
    @php
        $isOnThisRoute = \TallAndSassy\PageGuide\MenuTree::IsSubUrlMeOrBelow($suburl);
        $pickedClasses_ifOnThisRoute = $isOnThisRoute ? 'picked_classes' : '';
    @endphp
    <a class="
    linkFontColor_cssClasses   text-gray-300
    linkFocus_cssClasses group flex pr-1 pl-2 rounded-md focus:outline-none focus:bg-gray-700 transition ease-in-out duration-150
    {{--        Hey: 10/21' These .css classes should (maybe??) exists. They are spelled out in menutree.blade.php, but I'm struggling on how to centralize this.
            So, I'm repeating the tailwind classes here.  Probably good-enough, for now.
--}}
    ml-10 {{$pickedClasses_ifOnThisRoute}} text-sm"
        {!! \TallAndSassy\PageGuide\Components\Lepage::wireSwaplinkInA($suburl) !!}>{!! $label !!}</a>

</li>
