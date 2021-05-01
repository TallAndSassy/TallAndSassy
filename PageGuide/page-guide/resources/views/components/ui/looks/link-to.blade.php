<a
    @php
        /* Usage:
       <x-link-to href="https://www.google.com"  enum-sandbox="tab" enum-location="outside">
       */

       $enumSandboxAllowed = ['tab', 'download','program','same','touch', 'change', 'back'];
       $enumSandbox= isset($enumSandbox) ? $enumSandbox : 'same';
       assert (in_array($enumSandbox, $enumSandboxAllowed), "$enumSandbox");


       $enumLocation = isset($enumLocation) ? $enumLocation : 'inside';
       $enumLocationAllowed = ['inside', 'outside', 'anchor']; // Same, means an anchor elsewhere on the page
       assert (in_array($enumLocation, $enumLocationAllowed),$enumLocation);
       if ($enumLocation == 'inside') {
            $classColor = 'text-indigo-600';
       } elseif ($enumLocation == 'outside') {
           $classColor = 'text-blue-600';
       } elseif ($enumLocation == 'anchor') {
           $classColor = 'text-indigo-400';
       } else {
           assert(0);
       }
       $classUnderline = in_array($enumSandbox,[ 'tab', 'download','program','same','back']) ? 'underline' : '';

       $classWeight = $enumSandbox == 'change' ? 'font-bold' : '';
       $extraAttribs = isset($extraAttribs) ? $extraAttribs : '';

    @endphp
    {!! $extraAttribs !!}
    href="{{$href}}"
    {!! $enumSandbox == 'tab' ? "target='_BLANK'" : '' !!}
    {!! $attributes->merge(['class' => "$classColor   $classWeight"]) !!}
>
    @if($enumSandbox == 'back')
        <span class="text-red-600 text-xl no-underline">‹</span>
    @endif
    <span class="{{$classUnderline}}">{{$slot}}</span>

    @if ($enumSandbox == 'tab')
        <span class="text-gray-400 text-xs no-underline">↗</span></a>
    @elseif ($enumSandbox == 'program')
        <span class="text-gray-400 text-xs no-underline">⇪</span>
    @elseif ($enumSandbox == 'download')
    <span class="text-gray-400 text-xs no-underline">↓</span>
    @elseif ($enumSandbox == 'same')
    @endif

</a>

