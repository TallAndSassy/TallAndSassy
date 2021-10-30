@props(['name','slug'])
<div name="{!! $name !!}"
     x-data=""
     class="p-3 bg-gray-300 rounded-2xl"
     x-init="jRegisterTab($el);
                console.log(activeSlug);
                console.log(activeSlug);
                console.log(arrSlug2DomTab);
                console.log('my slug is: '+$el.attributes.slug.value);
            "
     x-show="($el.attributes.slug.value === activeSlug)"
     slug="{{$slug}}"

>
    <div id="InnerTab_{{$slug}}">
        {!! $slot !!}
    </div>
</div>


{{--@props(['name'])--}}

{{--<div x-data="{ id: '', name: '{{ $name }}' }"--}}
{{--	 x-init="console.log('in tab {{ $name }}'	); id = addTab('{{ $name }}')"--}}
{{--	 x-show="tabState(id)"--}}
{{--	 role="tabpanel"--}}
{{--	 :aria-labelledby="'tab-${id}'"--}}
{{--	 :id="'tab-panel-${id}'">--}}
{{--	{{ $slot }}--}}
{{--</div>--}}

{{--@props(['name','isLivewire'=>false])--}}
{{--<div x-data="{--}}
{{--        name:  '{{$name}}',--}}
{{--        show: false,--}}
{{--        isLivewire: {{$isLivewire ? 'true' : 'false'}},--}}
{{--        showIfActive(active) {--}}
{{--            this.show = (this.name == active);--}}
{{--            if (this.show && this.isLivewire) {--}}
{{--                console.log(this.name + ' is a livewire component.');--}}
{{--                Livewire.emit('iSeeTab', this.name);--}}
{{--                console.log('emmitted to '+this.name);--}}
{{--            }--}}

{{--        }--}}
{{--    }"--}}
{{--    x-show="show"--}}
{{-->--}}
{{--    {{ $slot }}--}}
{{--</div>--}}
