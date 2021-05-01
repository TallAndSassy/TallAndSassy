@livewire("demo.demo-flash-on-click")

<x-tassy::title>Installation</x-tassy::title>
@php
$slug = "flash";
$pathOffRouteToSample = $pathOffRouteToGroks."/$slug/sample_010_install_to_layout";
@endphp
<x-grok::tas-sample-from-file language="html" path="{{$pathOffRouteToSample}}"/>

<x-tassy::title>Usage: Prep</x-tassy::title>
@php $pathOffRouteToSample = $pathOffRouteToGroks."/$slug/sample_020_some_lw.console"; @endphp
<x-grok::tas-sample-from-file language="php" path="{{$pathOffRouteToSample}}"/>

@php $pathOffRouteToSample = $pathOffRouteToGroks."/$slug/sample_030_some_lw_new_func.txt"; @endphp
<x-grok::tas-sample-from-file language="php" path="{{$pathOffRouteToSample}}"/>

@php $pathOffRouteToSample = $pathOffRouteToGroks."/$slug/sample_032_some_lw_blade.txt"; @endphp
<x-grok::tas-sample-from-file language="html" path="{{$pathOffRouteToSample}}"/>


@php $pathOffRouteToSample = $pathOffRouteToGroks."/$slug/sample_035_calling_blade.html"; @endphp
<x-grok::tas-sample-from-file language="html" path="{{$pathOffRouteToSample}}"/>

<x-tassy::title>Learn more</x-tassy::title>
<a href="https://github.com/Grimthorr/laravel-toast">https://github.com/Grimthorr/laravel-toast</a>

<pre>

( ) Next: try to bring it here argh...
</pre>
