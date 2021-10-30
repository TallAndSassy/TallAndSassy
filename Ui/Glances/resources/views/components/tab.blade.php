@props(['name','slug','isLivewire'=>false])
<div name="{!! $name !!}"
     x-data="{
                isLivewire: {{$isLivewire ? 'true' : 'false'}},
                iBecameVisible: function() {
                    console.log('I ('+$el.attributes.slug.value+') become visible');
                    Livewire.emit('iSeeTab', $el.attributes.slug.value);
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
