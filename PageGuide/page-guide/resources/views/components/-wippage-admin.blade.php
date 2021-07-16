<x-tassy::page-_base>
    <style>
        /* Nicer Drop-Down --BEGIN- */


        /* Make detail reveals go smoother
        https://codepen.io/morewry/pen/gbJvy
        */
        details[open] .jDetails_body {
            animation-name: invisiblyGrowFontSize, fadeIn;
            animation-duration: 500ms, 200ms;
            animation-delay: 0ms, 300ms;
        }

        /* add wrapper, continue with font-size */
        @keyframes invisiblyGrowFontSize {
            0% {
                /*font-size: 0;*/
                max-height: 0px;
                opacity: 0;
            }
            100% {
                /*font-size: 1em;*/
                max-height: 999px;
                opacity: 0;
            }
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }


        /* Fancy right-side discloser */
        details[open] .jDetails_summary_discloser {
            transform: scale(-1, 1) rotate(-90deg);
            /*transform: ;*/
            transition: transform 500ms ease-in-out;
            /*animation-duration: 500ms, 200ms;*/
            /*animation-delay: 0ms, 300ms;*/
            /*  transform: scale(-1, 1);*/
            /*color: #1c87c9;*/
            /*-moz-transform: scale(-1, 1);*/
            /*-webkit-transform: scale(-1, 1);*/
            /*-o-transform: scale(-1, 1);*/
            /*-ms-transform: scale(-1, 1);*/
            /*transform: scale(-1, 1);*/
        }

        details .jDetails_summary_discloser {
            /*transform: scale(-1, 1)  rotate(-90deg);*/
            /*transform: ;*/
            transition: transform 300ms ease-in-out;
            /*animation-duration: 500ms, 200ms;*/
            /*animation-delay: 0ms, 300ms;*/
            /*  transform: scale(-1, 1);*/
            /*color: #1c87c9;*/
            /*-moz-transform: scale(-1, 1);*/
            /*-webkit-transform: scale(-1, 1);*/
            /*-o-transform: scale(-1, 1);*/
            /*-ms-transform: scale(-1, 1);*/
            /*transform: scale(-1, 1);*/
        }

        /* Left This puts reveal on far right... in Tall2 5/30/20', we're only
        playing for 'right' reveals so this is net relevant yet */
        /*https://stackoverflow.com/questions/56758098/how-to-position-detail-marker-to-come-after-summary */
        details.jDetailsFarRight {
            min-width: -webkit-fit-content;
            min-width: -moz-fit-content;
            min-width: fit-content;
        }

        .jDetailsFarRight summary {
            position: relative;
            min-width: -webkit-fit-content;
            min-width: -moz-fit-content;
            min-width: fit-content;
            cursor: pointer;
        }

        details.jDetailsFarRight summary::-webkit-details-marker {
            position: absolute;
            right: 0;
            top: 30%;
            z-index: 1;
        }

        /* Nicer Drop-Down --BEGIN- */

    </style>


    <div x-data="{ open: false }">
        {{--          <div class=" inset-0 float w-screen  ">--}}
        {{--            <div class="absolute inset-0 bg-green-600 z-40   opacity-75"></div>--}}
        {{--        </div>--}}
        <div id="curtain" class=" inset-0 float w-screen  ">
            <div class="absolute inset-0 bg-gray-600 z-40   opacity-75"></div>
        </div>
        <div class="h-screen flex overflow-hidden bg-gray-100 fixed inset-0 flex z-40">
            <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
            <!-- Static sidebar for desktop -->
            <div id="adminmenu" class="hidden md:flex flex-shrink-0">
                <div class="flex flex-col w-64">
                    <!-- Sidebar component, swap this element with another sidebar if you like -->
                    <div class="flex flex-col h-0 flex-1 bg-gray-800">
                        <div class="flex-1 flex flex-col pt-5  pb-4 overflow-y-auto">
                            <x-tassy::header.back.corner-block-inner class="pl-4 border-b pb-2 border-gray-700"/>

                            <div class="px-2">
{{--                                <livewire:tassy::livewire.sidenav />--}}
                                @livewire('tassy::livewire.sidenav')
                            </div>
                        </div>
                        <div class="flex-shrink-0 flex  px-2 pt-1  border-t border-gray-700">
                            <livewire:tassy::livewire.lowernav/>
                        </div>
                    </div>
                </div>
            </div>
            {{--  <div class="flex flex-col w-0 flex-1 overflow-hidden">--}}
            <div id="hamburger" class="md:hidden pl-1 pt-1 sm:pl-3 sm:pt-3">
                <button @click="openMenu();"
                        class="-ml-0.5 -mt-0.5 h-12 w-12 inline-flex items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:bg-gray-200 transition ease-in-out duration-150"
                        aria-label="Open sidebar">
                    <!-- Heroicon name: menu -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
            <script>
                let clickedOpen = false;

                function openMenu() {
                    clickedOpen = true;

                    let e = document.getElementById('adminmenu');
                    e.classList.remove('hidden');
                    e.classList.add('flex');

                    e = document.getElementById('hamburger');
                    e.classList.add('hidden');
                    e = document.getElementById('curtain');
                    e.classList.remove('hidden');

                }

                function maybeCloseAdminMenu() {
                    //alert('maybe closing');
                    if (clickedOpen) {
                        clickedOpen = false;
                        let e = document.getElementById('adminmenu');
                        e.classList.add('hidden');
                        e.classList.remove('flex');

                        e = document.getElementById('hamburger');
                        e.classList.remove('hidden');

                        e = document.getElementById('curtain');
                        e.classList.add('hidden');
                    }
                }
            </script>

            <main class="flex-1  relative z-0 overflow-y-auto focus:outline-none" tabindex="0">
                <div class="flex flex-col h-screen justify-between bg-gray-100">
{{dd(get_defined_vars())}}
                    @livewire('tassy:lepage', ['pageRoute' => $pageRoute, 'asrParams'=>$asrParams])
{{--                                    Header--}}

                    <div class="bg-gray-300 rounded border shadow p-4">
                        <div class="h-16  flex bg-gray-100 ">
                            <div class="hidden sm:block p-3  ">
                                <x-tassy::header.back.title>{{$title}}  </x-tassy::header.back.title>
                            </div>

                            <x-tassy::header.menu_for_users class="lg:pt-1"/>

                        </div>
                        <x-tassy::header.back.title class="sm:hidden">{{$title}}  </x-tassy::header.back.title>

                        <main class="mb-auto  bg-gray-100">
                            <div class="p-0 sm:p-3 h-full">{{$slot}}</div>
                        </main>

                        <x-tassy::footer.back.index/>
                    </div>

                </div>

            </main>
        </div>
    </div>
</x-tassy::page-_base>
