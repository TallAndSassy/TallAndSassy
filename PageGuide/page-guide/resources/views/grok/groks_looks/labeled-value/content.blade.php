@php
$slug = "labeled-value";
$pathOffRouteToSample = $pathOffRouteToGroks."/$slug/sample.blade.php";
@endphp
@include("tassy::/grok/groks_looks/$slug/sample")
<x-grok::tas-sample-from-file language="html" path="{{$pathOffRouteToSample}}"/>

              <pre>
[ ] Next: Maybe format certain things nicely?  (wait until real uses)
    [ ] Date (Terse?, Standard?, Verbose?)
    [ ] Money
    [ ] Time
    [ ] Delta Time
[ ] Later: Editable
                        </pre>
