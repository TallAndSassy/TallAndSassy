@php

    // JJ - How can you make these common without perculating up the heirarchy?  Simple includes hide varaibles.
          /*   $liWrapper_1 = $liWrapper_2 = 'pr-1 pb-1';
             $liWrapper_3 = ' pr-1 -ml-2 pl-2  ';  // feels like should be below, not in li

             $linkFontColor_cssClasses = 'text-gray-300';
             $linkFocus_cssClasses = ' group flex pr-1 pl-2 rounded-md focus:outline-none focus:bg-gray-600 transition ease-in-out duration-150';
             $picked_classes = 'bg-gray-500 rounded';
             $placeholderFontColor_cssClasses = 'text-gray-400';


             $divNode_cssClasses     = "$linkFontColor_cssClasses        $linkFocus_cssClasses no-underline group flex items-center px-2  text-md leading-5 font-bold   ";

             $firstLeaf_cssClasses   = "$linkFontColor_cssClasses        $linkFocus_cssClasses px-2 text-lg leading-5 font-bold    ";
             $secondLeaf_cssClasses  = "$linkFontColor_cssClasses        $linkFocus_cssClasses group flex items-center px-2  text-sm  rounded-md  ";
             $secondBreak_cssClasses = "$placeholderFontColor_cssClasses ml-1.5 text-base font-bold ";
             $thirdLeaf_cssClasses   = "$linkFontColor_cssClasses        $linkFocus_cssClasses ml-5 ";
             $icon_cssClasses = "topLevelNavIcon w-6 h-6 mr-3 $placeholderFontColor_cssClasses";
             $jDetails_summary_cssClasses = "jDetails_summary cursor-pointer $divNode_cssClasses";
             $jDetails_body_cssClasses = 'ml-11';

 $firstLeafText_cssClasses = "hidden lg:block";*/
@endphp



<div>
     {!!  \TallAndSassy\PageGuide\MenuTree::singleton('lower')->getHtml();!!}
</div>
