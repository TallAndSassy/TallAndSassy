@php
$slug = "lists";
$pathOffRouteToSample = $pathOffRouteToGroks."/$slug/sample.blade.php";
@endphp
@include("tassy::/grok/groks_looks/$slug/sample")
<x-tassy::ui.looks.title>UnOrdered</x-tassy::ui.looks.title>
<x-grok::tas-sample-from-file language="html" path="{{$pathOffRouteToSample}}"/>

@php
$slug = "lists";
$pathOffRouteToSample = $pathOffRouteToGroks."/$slug/sample2.blade.php";
@endphp
@include("tassy::/grok/groks_looks/$slug/sample2")
<x-tassy::ui.looks.title>Ordered</x-tassy::ui.looks.title>
<x-grok::tas-sample-from-file language="html" path="{{$pathOffRouteToSample}}"/>


