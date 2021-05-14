<x-tassy::menu-side-treerootleaf suburl="/admin/help">
    TreeRootLeaf NoIcon
</x-tassy::menu-side-treerootleaf>
<x-tassy::menu-side-treerootleaf suburl="/admin/help">
    TreeRootLeaf2
</x-tassy::menu-side-treerootleaf>
<x-tassy::menu-side-treerootleaf suburl="/admin/help">
    TreeRootLeaf3
</x-tassy::menu-side-treerootleaf>

<x-tassy::menu-side-treerootleaf suburl="/admin/help">
    <div class="mr-1.5">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
        </svg>
    </div>
    TreeRootLeafIcn1
</x-tassy::menu-side-treerootleaf>
<x-tassy::menu-side-treerootleaf suburl="/admin/help">
    {{--    Pro-Tip: We subdued the icon with a wrapping div color and adjusted the inner svg for h/w-5 (vs 6)--}}
    <div class="mr-1.5 text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
        </svg>
    </div>
    TreeRootLeafIcn2
</x-tassy::menu-side-treerootleaf>
<x-tassy::menu-side-treerootleaf suburl="/admin/help">
    TreeRootLeaf4
</x-tassy::menu-side-treerootleaf>
<x-tassy::menu-side-treerootleaf suburl="/admin/help">
    TreeRootLeaf5
</x-tassy::menu-side-treerootleaf>


<x-tassy::menu-side-divider-at-root-level/>


<x-tassy::menu-side-treeroot>
    <x-slot name="label">
        <div class="mr-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
            </svg>
        </div>
        <div class="italic">TreeRoot</div>
    </x-slot>

    <x-tassy::menu-side-treeroot-leaf suburl="/admin/sample_menuside_sub1" label="Sub1"/>
    <x-tassy::menu-side-treeroot-leaf suburl="/admin/sample_menuside_sub2" label="Sub2"/>
    <x-tassy::menu-side-treeroot-leaf suburl="/admin/sample_menuside_sub3" label="Sub3"/>
    <x-tassy::menu-side-treeroot-leaf suburl="/admin/sample_menuside_sub4" label="Sub4"/>
    <x-tassy::menu-side-treeroot-fork label="Rejects">
        <x-tassy::menu-side-treeroot-fork-leaf suburl="/admin/sample_menuside_reject1" label="Shrub"/>
        <x-tassy::menu-side-treeroot-fork-leaf suburl="/admin/sample_menuside_reject2" label="Bush"/>
        <x-tassy::menu-side-treeroot-fork-leaf suburl="/admin/sample_menuside_reject3" label="Scrub"/>
    </x-tassy::menu-side-treeroot-fork>
    <x-tassy::menu-side-treeroot-fork label="Winners">
        <x-tassy::menu-side-treeroot-fork-leaf suburl="/admin/sample_menuside_winRose" label="Rose"/>
        <x-tassy::menu-side-treeroot-fork-leaf suburl="/admin/sample_menuside_winTulip" label="Tulip"/>
        <x-tassy::menu-side-treeroot-fork-leaf suburl="/admin/sample_menuside_winDaffodil" label="Daffodil"/>
    </x-tassy::menu-side-treeroot-fork>
    <x-tassy::menu-side-treeroot-leaf suburl="/admin/sample_menuside_sub4" label="Trail"/>
    <x-tassy::menu-side-treeroot-leaf suburl="/admin/sample_menuside_sub4" label="Help"/>
</x-tassy::menu-side-treeroot>


