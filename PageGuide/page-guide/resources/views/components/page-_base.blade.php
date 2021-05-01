{{--Stuff all pages need--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js" defer></script>
    </head>
    <body class="font-sans antialiased">
     <div>
         <div id="theOneModal_HideOnPageLoadHacks" class="hidden">                                                      {{--  x-cloak wasn't hiding the modal on pageload, as expected, so class='hidden' is here.  Yuck. HideOnPageLoadHacks--}}
         @livewire('the-modal-box')
         </div>
    </div>

        <!-- Page Content -->
            <x-tassy::page-_base-body>
            {{ $slot }}
            </x-tassy::page-_base-body>
        @stack('modals')
        @stack('TassyScripts')
        @livewireScripts
    </body>
</html>

