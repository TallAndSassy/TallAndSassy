@props(['enumStyle'])
<button
    @php
    $extraClass = '';
    if ($enumStyle == 'primary') {
        $extraClass .= 'bg-blue-500 hover:bg-blue-600';
    } elseif ($enumStyle == 'cancel') {
        $extraClass .= 'bg-gray-500 hover:bg-gray-600';
    }
    @endphp
    {{ $attributes([
    'type'=>"button",
    'class'=> "rounded shadow px-3 py-2 mb-2 ".$extraClass ]) }}
    {{ $attributes }}>
    {{$slot}}
</button>
