@props(['summary','language','path'])
@php
	$veryLocalDomId = uniqid();
@endphp

<details class=" ml-3 mt-3" id="{{$veryLocalDomId}}"
		 x-data="{ }"
		 x-init="() => {
			{{-- Motivation: kick off prism rendering whenever livewire update			--}}
			 document.addEventListener('snumRenderStateChanged', function () {
				{{-- Called via $this->dispatchBrowserEvent('snumRenderStateChanged'); in your livewire:
					Ui/Glances/src/Components/RemergeTab_ComponentBase.php
				--}}
				Prism.highlightAll();

				{{--  NiceToDo: Only update the related code in this livewire change.  Something like this.--}}
				{{--  var block = document.getElementById('{{$veryLocalDomId}}')--}}
				{{--  Prism.highlightElement(block);--}}
			});

			{{-- NiceToDo: Get this to respond to livewire component.rendered.  I couldn't grab it. So mannually munging in snumRenderStateChanged--}}
			{{-- document.addEventListener('component.rendered', function () {--}}
			{{-- document.addEventListener('rendered', function () {--}}
			{{-- document.addEventListener('livewire:rendered', function () {--}}
			{{-- window.livewire.on('livewire:rendered', () => {alert('on2');});--}}
		 }"

    >
	<summary class="text-gray-600 cursor-pointer" wire:dirty.class="bg-red-300" >{{$summary}}</summary>
	<x-grok::tas-sample-from-file language="{{$language}}" path="{!! $path !!}"/>
	<script>
		// A block loaded through ajax won't get parsed. We'll need to tell prism to parse this.
		// https://schier.co/blog/how-to-re-run-prismjs-on-ajax-content
		// https://prismjs.com/extending.html#api


        document.addEventListener('livewire:updated', function () {
            component.rendered('updated2');
            var block = document.getElementById('{{$veryLocalDomId}}')
            Prism.highlightElement(block);
        });
        document.addEventListener('updated', function () {
            console.log('updated');
            var block = document.getElementById('{{$veryLocalDomId}}')
            Prism.highlightElement(block);
        });

        document.addEventListener('livewire:load', function () {
            component.rendered('livewire:load');
            var block = document.getElementById('{{$veryLocalDomId}}')
            Prism.highlightElement(block);
        });
	</script>
</details>
