<div>

    @push('TassyScripts') {{--    Hey - make sure @stack('TassyScripts') is in page-_base.blade.php--}}
        <script>

            function theModal() {

                return {
                    show: false,
                    open(path, title, enumCancelOkClose, primaryName_elseNull) {
                        //alert('got here. path:'+path+' title:' +title + ' enumCancelOkClose:'+enumCancelOkClose);
                        this.show = true;
                        // '/justBody/1 is hack to tell heirachy controller to only show body

                         window.livewire.emit('innerModalPath', path + '/justBody/1', title, enumCancelOkClose, primaryName_elseNull);

                        // TODO: Figure out how to open with loader and then livewire ajax
                    },
                    open2(obj) {
                        this.show = true;
                        window.livewire.emit('innerModalPath', obj.path, obj.title, obj.primaryName_elseNull);
                        // TODO: Figure out how to open with loader and then livewire ajax
                    },
                    close() {
                        this.show = false;

                    },
                    isOpen() {
                        return this.show === true
                    },
                }
            }

            // window.thatModal = theModal();
            // alert(window.thatModal.show);
        </script>
    @endpush

    <style>
        /*https://www.w3schools.com/howto/howto_css_loader.asp*/
        .loading {
            border: 16px solid #f3f3f3; /* Light grey */
            border-top: 16px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }


        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .waiting {
            border-top: 16px solid blue;
            border-right: 16px solid green;
            border-bottom: 16px solid red;
            border-left: 16px solid pink;
            width: 120px;
            border-radius: 50%;
            height: 120px;
            animation: spin 2s linear infinite;
        }


    </style>

    <div x-data="theOneModal = theModal()" x-show="isOpen()">
{{--            <div x-data="theOneModal = theModal()">--}}
        <div class="z-50 fixed bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center">
            <!--
              Background overlay, show/hide based on modal state.
            -->
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!--
              Modal panel, show/hide based on modal state.
            -->
            @php
            $placeholderFontColor_cssClasses = 'text-gray-400';
            $icon_cssClasses = "topLevelNavIcon w-6 h-6 mr-0 $placeholderFontColor_cssClasses ";
            // $innerModalPath = "admin/seasons/details/id/1224d03b-f221-443f-a7ef-a6b1de3aeff1"  something like this
            // What should we really be loading here?
            // And how does this fit in with routes and controllers?
            //
            // Now, the thing is, I want this to be more ajax-y.  But maybe not, maybe I've already ajaxed about as
            //  much as it
            //
            /*
             * https://stackoverflow.com/questions/24582922/laravel-get-route-name-from-given-url
            class MyRouter extends \Illuminate\Routing\Router {
                public function resolveRouteFromUrl($url) {
                    return $this->findRoute(\Illuminate\Http\Request::create($url));
                }
            }
            $myRouter = new MyRouter(new \Illuminate\Events\Dispatcher());
            $route = null;
            $route = $myRouter->resolveRouteFromUrl(\Illuminate\Support\Facades\Route::getCurrentRoute());
            dd($route);

            // So, just do this more manually:
            // But I'm worried about security, and such.



            */
            $arrParts = $arrPartsOrig = explode('/', $innerModalPath);
            $numParts = count($arrParts);
            $shortenedViewPath = $innerModalPath;
            $arrParams = [];
            foreach ($arrParts as $slot=>$part) {
                $arrPath = array_slice($arrPartsOrig,0,$numParts-$slot );
                $shortenedViewPath = implode('/',$arrPath);
                if (view()->exists($shortenedViewPath)) {
                    $arrParams =  array_slice($arrPartsOrig,$numParts-$slot );
                    break;
                }
            }
            // I think this is OBE 8/20'




            @endphp
            <div @click.away="close()"
                class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all   max-h-full  overflow-y-scroll w-full md:w-8/12 lg:w-6/12 "
                role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <button   type="button" @click="close()" class="altCloser float-right  pr-1 pt-1 ">
                    <x-heroicon-o-x class="{{$icon_cssClasses}}" stroke="currentColor"/>
                </button>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left  w-full ">
                            <h3 class="text-2xl leading-6 font-bold text-gray-900" id="modal-headline">
                                {{$modalTitle}}
                            </h3>
                            <div class="mt-2  w-full ">
                                <p class="text-sm leading-5 text-gray-500">
                                @if (empty($innerModalPath))
                                    <div>Loaded content is not yet set.
                                    JJ - If this is showing up, set the script to default to 'false' line ~9 resources/views/livewire/the-modal-box.blade.php</div>
                                @else
                                    @php

                                    @endphp
{{--                                    @include($shortenedViewPath,['arrParams'=>$arrParams])--}}
                                    {!! $innerHtml !!}
                                {{--                                <div class="loader"></div> see default in controller--}}
                                @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                {{--                Bottom Buttons --}}
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex  sm:flex-row-reverse ">

                        {{--  I totally couldn't get this to work - it has something to do with the ordering.  When not shown, and if before the 'Cancel' it died.
                        I tried null, and '', but that was the wrong route.  As of now, 'na' is magic.
                        I think there is some alipine/livewire foo going on here.

                        I feel like I saw some old code, in lwip?, that told alpine to reparse... we'll be more elegant later

                        --}}
                       @php
                            $buttonNoLongerNeededHack = '';
                            if($primaryName_elseZeroLength == '' ) {
                                $buttonNoLongerNeededHack = 'hidden';
                            }

                            $appearPrimary   = "border border-transparent text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700   font-medium ";
                            $appearSecondary = "border border-gray-300  text-base  font-medium text-gray-700 hover:text-gray-500  focus:border-blue-300 bg-white sm:text-sm";

                             #$enumCancelOkClose = 'Cancel';
                            $secondaryButtonText = $enumCancelOkClose;

                            if ($enumCancelOkClose == 'Cancel') {
                                #$primaryName_elseZeroLength = $primaryName_elseZeroLength;
                                #assert($primaryName_elseZeroLength != '', "primaryName_elseZeroLength($primaryName_elseZeroLength)");
                                $secondaryButtonText = 'Cancel';
                                $closeAppearance = $appearSecondary;
                                $primaryAppearance = $appearPrimary;
                            } elseif ($enumCancelOkClose == 'Close') {
                                #assert($primaryName_elseZeroLength == '');
                                $primaryName_elseZeroLength = $secondaryButtonText = 'Close';
                                $closeAppearance = $appearPrimary;
                                $primaryAppearance = 'hidden';
                            } elseif ($enumCancelOkClose == 'Ok') {
                                #assert($primaryName_elseZeroLength == '');
                                $primaryName_elseZeroLength = $secondaryButtonText = 'Ok';
                                $closeAppearance = $appearPrimary;
                                $primaryAppearance = 'hidden';
                            } elseif ($enumCancelOkClose == 'tbd') {
                                // fresh page load
                                $primaryName_elseZeroLength = $secondaryButtonText = 'tbd';
                                   $closeAppearance = 'hidden';
                                $primaryAppearance = 'hidden';
                            } elseif ($enumCancelOkClose == 'None') {
                                // fresh page load
                                $primaryName_elseZeroLength = $secondaryButtonText = 'tbd';
                                   $closeAppearance = 'hidden';
                                $primaryAppearance = 'hidden';
                         } else {
                                assert(0, "enumCancelOkClose($enumCancelOkClose)");
                            }

                         @endphp


                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto {{ $buttonNoLongerNeededHack }}">
                            <button
                                class="{{$primaryAppearance}} inline-flex justify-center w-full rounded-md  px-4 py-2  leading-6 shadow-sm focus:outline-none transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                              {{$primaryName_elseZeroLength}}
                            </button>
                        </span>
                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                        <button type="button" @click="close()"
                                class="{{$closeAppearance}} inline-flex justify-center w-full rounded-md px-4 py-2  leading-6shadow-sm focus:outline-none focus:shadow-outline-blue transition ease-in-out duration-150  sm:leading-5">
                          {{$secondaryButtonText}}
                        </button>
                    </span>



                </div>
            </div>
        </div>
    </div>


</div>
