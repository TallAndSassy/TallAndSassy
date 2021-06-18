{{--Stuff all pages need--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TallAndSassyEmptyApp') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
{{--        <link rel="stylesheet" href="{{ asset('css/app.css') }}">--}}
{{--        <script src="https://cdn.jsdelivr.net/npm/@ryangjchandler/spruce@2.x.x/dist/spruce.umd.js"></script>--}}
{{--        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>--}}
        <script src="{{ mix('js/app.js') }}" defer></script>
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
        <!-- Scripts -->
{{--        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js" defer></script>--}}
        @bukStyles
    </head>
    @if  (config('tassy.admin.DoSamples',false))
    <script>
        // test Spruce is working
        // So, I don't get it, yes, but I need to do this code inside app.js
        // console.log('start spruce test');
        // window.Spruce.store('sprucetest_modal', {
        //     open: 'login',
        // });
        // // console.log($store.sprucetest_modal.open);
        // window.Spruce.store('sprucemodal', {
        //     doShowModal: false,
        //     diy: false,
        //     loadingButtonText: 'Close',
        //     loadingButtonClasses: 'bg-gray-300',
        //     loadingButtonContainerClasses: 'bg-gray-50 sm:grid sm:grid-1',
        //     loadingTitle: 'Loading',  //not seeing it passed in ?
        //
        //
        //
        //     renderSource: 'tbd',
        //
        //     'buttonText': 'tbd',
        //     'title': 'tbd',
        //     'buttonClasses':'bg-green-200 hover:bg-green-300',
        //     'isLoaded_buttonClasses':'',
        //     'buttonContainerClasses': '',
        //     'isLoaded': false,
        //
        //     innerHtml: '',
        // })
        // console.log('end spruce test');
    </script>
    @endif
    <body class="font-sans antialiased">
     <div>
         <div id="theOneModal_HideOnPageLoadHacks" class="hidden">                                                      {{--  x-cloak wasn't hiding the modal on pageload, as expected, so class='hidden' is here.  Yuck. HideOnPageLoadHacks--}}
         @livewire('tassy::livewire.the-modal-box')
         </div>
    </div>

        <!-- Page Content -->
            <x-tassy::page-_base-body>

            {{ $slot }}
            </x-tassy::page-_base-body>
        @stack('modals')
        @stack('TassyScripts')
        @livewireScripts
     @bukScripts
    </body>
</html>

