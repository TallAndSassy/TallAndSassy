@props(['name','isLivewire'=>false])
<div
		x-data="{
			name:  '{{$name}}',
			show: false,
			isLivewire: {{$isLivewire ? 'true' : 'false'}},
			showIfActive(active) {
				this.show = (this.name == active);
				if (this.show && this.isLivewire) {
					console.log(this.name + ' is a livewire component.');
					Livewire.emit('iSeeTab', this.name);
					console.log('emmitted to '+this.name);
				}

			}
		}"
		x-init="id = addTab('{{ $name }}')"
		x-show="tabState(id)"
		role="tabpanel"
		:aria-labelledby="`tab-${id}`"
		:id="`tab-panel-${id}`">
	{{ $slot }}
	>
</div>