<a
    href="{{$href}}"
    class=""
    style="">
    <span class="{{config('app-theme-base.link_to_outside_classes')}}" style="{{config('app-theme-base.link_to_outside_style')}}">
        {!! $slot !!}</span>{!! config('app-theme-base.link_to_outside_rightHtml') !!}
</a>
