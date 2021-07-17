 @php
     $random_number =uniqid();
 @endphp
    <button
        {{$attributes}}
            href = "{{$href}}"
            class = "text-sm font-medium text-indigo-600 text-left"
            style = "border-bottom: 1px dotted; text-shadow: 0.5px 0.5px 1px #64748b"
            random_number = "{{$random_number}}"
            ><span>{!! $slot !!}</span>
    </button>

