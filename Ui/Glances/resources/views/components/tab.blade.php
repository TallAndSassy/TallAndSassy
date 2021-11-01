@props(['name','slug','enumLivewireRendering_default_custom'=>'default'])
@php
    $isLivewire = str_starts_with(trim($slot),'<div wire:id');
    if ($isLivewire) {
        assert(in_array($enumLivewireRendering_default_custom,['default','custom']), 'enumLivewireRendering_default_custom must be set when including a livewire componenent');
    }
@endphp
<div name="{!! $name !!}"
     x-data="{
                isLivewire: {{$isLivewire ? 'true' : 'false'}},
                iBecameVisible: function() {
                    console.log('I ('+$el.attributes.slug.value+') become visible');
                    Livewire.emit('iSeeTab', $el.attributes.slug.value); // uhhh, this is dumb 10/21'  just call livewire directly
                     console.log('emmitted to '+$el.attributes.slug.value);
                }
            }"
     class="p-3 bg-gray-300 rounded-2xl"
     x-init="jRegisterTab($el);
                console.log(activeSlug);
                console.log(activeSlug);
                console.log(arrSlug2DomTab);
                console.log('my slug is: '+$el.attributes.slug.value);
                $watch('activeSlug', function(value, oldValue)  {
                    console.log('oldValue:'+oldValue + ' newvalue:'+value);
                    if (activeSlug == $el.attributes.slug.value) {
                        iBecameVisible();
                    }
                });
            "
     x-show="($el.attributes.slug.value === activeSlug)"
     slug="{{$slug}}"

>
    <div id="InnerTab_{{$slug}}">
        {!! $slot !!}
    </div>
</div>
