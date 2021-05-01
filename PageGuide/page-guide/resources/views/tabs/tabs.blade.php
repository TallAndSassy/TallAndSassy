<div>
    @php
    // INPUT: $dtoNavTabs, $defaultTab, $currentTab, $ownerName

@endphp
    @if($dtoNavTabs)

            <div class="hidden sm:block">
                <nav class="flex">

                 @foreach ($dtoNavTabs->values as $key=>$dtoNavTab)

                    @php
                    $isActive = ($key == $currentTab);
                    $activeToggleClasses = ($isActive) ? " border-indigo-500 border-l border-t border-r rounded-t-lg py-1 " : "border-b   rounded-t ";

                    @endphp

                    <button
                        {!! $ownerName::wireSwaplinkInA($dtoNavTab->href) !!}
                        {{--                        wire:click="$emit('goToTab','{{$tabSlug}}')"--}}
                        x-on:click.prevent
                        class="whitespace-no-wrap px-3
                             font-medium text-sm leading-5 text-gray-600 no-underline
                            py-2

                            {{$activeToggleClasses}}
                            hover:text-gray-700 hover:bg-gray-200 hover:border-t hover:border-r hover:rounded-t-xlg
                            focus:outline-none focus:text-gray-700 focus:border-gray-300
                            ">
                        {{ $dtoNavTab->title }}


                        @if($dtoNavTab->badge)
                            @php
                                $badgeClasses =  'bg-gray-100 text-gray-800';
                            @endphp
                            <sup
                                class="bg-gray-300 py-1 px-2 rounded-full text-xs {!! $badgeClasses !!} ">{!! $dtoNavTab->badge !!}</sup>
                        @endif


                        @if($dtoNavTab->hint)
                            {{--   https://github.com/Cosbgn/tailwindcss-tooltips--
                            Look in layouts/base/ for some tab styling --}}
                            <x-tassy::ui.looks.hint>{!! $dtoNavTab->hint !!}</x-tassy::ui.looks.hint>
                {{--        <span class="text-gray-300 font-normal tooltip" title=""><sup>(?)</sup><span class="tooltip-text text-gray-700 border border-gray-700 bg-gray-200 p-3 -mt-4 ml-0 rounded">{!! $hintContent !!}</span></span>--}}

                        @endif
                    </button>

                @endforeach

                <div class=" border-b w-full"></div>{{--                Add a spacer so the underbar extends across the screen--}}
                </nav>
            </div>
    @endif
</div>
