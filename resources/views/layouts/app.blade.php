<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" href="{{ asset('/img/favicon-agenda.png') }}" type="image/x-icon">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if (isset($styles))
        {{ $styles }}
    @endif
    <!-- Scripts específicos por vista -->
    @yield('head-scripts')
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-pzrimary-light dark:bg-gray-900 pt-[80px] relative">
        @include('layouts.navigation')

        @include('components.loader')

        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 mt-5 rounded">
                {{ $header }}
            </header>
        @endif

        <!-- Page Content -->
        <main class="pb-5">
            {{ $slot }}
        </main>

        {{-- @include('layouts.footer') --}}

    </div>

</body>

</html>
