{{-- Not sure of the history here.
copy this into /resources/views/layouts
10/1
--}}
        I think this (vendor/tallandsassy/tallandsassy/PageGuide/page-guide/resources/views/layouts/app.blade.php) is OBE
Use vendor/tallandsassy/tallandsassy/PageGuide/page-guide/resources/views/components/page-_base.blade.php instead
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
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <!-- Code highlighting 1 of 2-->
    <link href="/css/prism.css" rel="stylesheet" />
</head>
<body class="font-sans antialiased">
<x-jet-banner />

<div class="min-h-screen bg-gray-100">
    @livewire('navigation-menu')

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
@endif

<!-- Page Content -->
    <main class="FYImodules/TallAndSassy/PageGuide/page-guide/resources/views/layouts/app.blade.php">
        {{ $slot }}
    </main>
</div>

@stack('modals')

@livewireScripts
<!-- Code highlighting 2 of 2 -->
<script src="/js/prism.js"></script>
</body>
</html>
