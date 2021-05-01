<span>
    <span class='tooltip'>
    @php
        /* indicate that there is a hint, and then show it upon hover:
        https://github.com/Cosbgn/tailwindcss-tooltips
        */
    @endphp
{{--        This style sheet is getting repeated when multiple hints on a page. oouch.--}}
    <style>
        .tooltip .tooltip-text {
            visibility: hidden;
            text-align: center;
            padding: 2px 6px;
            position: absolute;
            z-index: 100;

        }

        .tooltip:hover .tooltip-text {
            visibility: visible;
        }
    </style>

        <span class="text-gray-400 text-sm" style="cursor: help;">(?)</span><span
            class="tooltip-text bg-yellow-400 border rounded border-blue-500 text-blue-700 bg-blue-200 p-3 -mt-6 -ml-6">{{$slot}}</span>



</span>
</span>
