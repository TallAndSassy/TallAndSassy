<div>

	@include('tassy-ui::samples/Modals/WireModal/working_example')
	<x-tassy-ui::code-reveal summary="Example: Button" language="html" path="vendor/tallandsassy/tallandsassy/Ui/Glances/resources/views/samples/Modals/WireModal/working_example.blade.php"/>
	<x-tassy-ui::code-reveal summary="Example: Inner Modal" language="html" path="vendor/tallandsassy/tallandsassy/Ui/Glances/resources/views/samples/Modals/WireModal/working_inner_modal.blade.php"/>
	<x-tassy-ui::code-reveal summary="Example: Modal Livewire Controller" language="php" path="vendor/tallandsassy/tallandsassy/Ui/Glances/src/Samples/Modals/WireModal/WorkingSampleLivetroller.php"/>

	<hr>
	Let's discuss wire modal stuff. We're using `https://github.com/wire-elements/modal` for our modals. Mainly, we really like that it has a multi-modal concept, so you
	can open a new modal from an existing modal, and then close back to the original modal. You can learn more about it from the github page and the author's page
	`https://philo.dev/laravel-modals-with-livewire/`
	<p>
		For our purposes, we'll want to create a new livewire modal component whenever we want a fresh modal. This will create livetroller code for us to manage our
		modal, along with a blade to make the modal look all pretty.
	</p>
</div>