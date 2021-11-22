<x-tassy::menu-side-treeroot thisVeryLocalHandleForThisMenuTree="TassySamples">
	<x-slot name="label">
		<div class="mr-1.5">
			<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
		</div>
		<div class="italic">Tassy Samples</div>
	</x-slot>
	<x-tassy::menu-side-treeroot-fork label="Level 1">
		<x-tassy::menu-side-treeroot-fork-leaf suburl="/admin/samples/hello_world" label="Hello"/>
		<x-tassy::menu-side-treeroot-fork-leaf suburl="{{'/admin/'.\TallAndSassy\Ui\Glances\Samples\TechBase\Status__Page::getSlug()}}" label="Alpine Tech"/>
		<x-tassy::menu-side-treeroot-fork-leaf suburl="{{'/admin/'. \TallAndSassy\Ui\Glances\Samples\TabSample0__Page::getSlug()}}" label="Tabs"/>
		<x-tassy::menu-side-treeroot-fork-leaf suburl="/admin/samples/uisamples" label="UI Samples"/>
		<x-tassy::menu-side-treeroot-fork-leaf suburl="/admin/tassy/samples/code" label="Code"/>
	</x-tassy::menu-side-treeroot-fork>
	<x-tassy::menu-side-treeroot-fork label="Level 2">
		<x-tassy::menu-side-treeroot-fork-leaf suburl="{{'/admin/'.\TallAndSassy\Ui\Glances\Samples\TabSample1__Page::getSlug()}}" label="Tab Sampler"/>
	</x-tassy::menu-side-treeroot-fork>
	<x-tassy::menu-side-treeroot-fork label="Grok">
		<x-tassy::menu-side-treeroot-fork-leaf suburl="{{'/admin/'.\TallAndSassy\Ui\Glances\Samples\Modals\GrokModalLepage::getSlug()}}" label="Modals"/>
		<x-tassy::menu-side-treeroot-fork-leaf suburl="/grok" :active="request()->routeIs('grok*')" label="GrokTest"/>
	</x-tassy::menu-side-treeroot-fork>
	{{--	<x-tassy::menu-side-treeroot-leaf suburl="/mockups/Mock_User020_Page" label="School Year"/>--}}
	{{--	<x-tassy::menu-side-treeroot-leaf suburl="/admin/sample_menuside_reject1" label="Season Calendar"/>--}}
</x-tassy::menu-side-treeroot>