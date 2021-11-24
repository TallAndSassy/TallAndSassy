<div>
	<x-tassy-ui::tab-container defaultSlug="second">

		<x-tassy-ui::tab name="First" :isLivewire="true" slug="first">
			<livewire:tassy-ui:Sample_Tab1_Tab :tabName="'First'" :tabSlug="'first'"/>
			{{-- calls vendor/tallandsassy/tallandsassy/Ui/Glances/src/Samples/Sample_Tab1_Tab.php
				which, in turn, loads vendor/tallandsassy/tallandsassy/Ui/Glances/resources/views/samples/TabSamples/tab-first.blade.php
				ugh, naming. --}}
		</x-tassy-ui::tab>
		<x-tassy-ui::tab name="Second" slug='second' :isLivewire="true">
			<livewire:tassy-ui:Sample_Tab2_Tab :tabName="'Second'" :tabSlug="'second'"/>
		</x-tassy-ui::tab>
		<x-tassy-ui::tab name="Third" slug="third">
			<div class="border shadow mt-2 p-2 ">
				Local body, not livewire
			</div>
		</x-tassy-ui::tab>
		<x-tassy-ui::tab name="Blade Modal" slug="mbs">
			@include('tassy-ui::samples/Modals/sample_modal_blade__page')
		</x-tassy-ui::tab>
		<x-tassy-ui::tab name="Tassy Modal" slug="mls">
			@include('tassy-ui::samples.Modals.sample_modal_livewire__page')
		</x-tassy-ui::tab>
		<x-tassy-ui::tab name="Wire Modal" slug="mwm">
			@include('tassy-ui::samples.Modals.WireModal.wire_modal__page')
		</x-tassy-ui::tab>
		<x-tassy-ui::tab name="Tabbed Tech Check" slug="ttc">
			<div class="border shadow mt-2 p-2 ">
				Does alpine work?
				@include('tassy-ui::samples/TechBase/Status__')
			</div>
		</x-tassy-ui::tab>
		<x-tassy-ui::tab name="UI" slug="ui">
			<div class="border shadow mt-2 p-2 ">
				@include(('tassy-ui::samples/UI/UISample__Page'))
			</div>
		</x-tassy-ui::tab>

	</x-tassy-ui::tab-container>

</div>

