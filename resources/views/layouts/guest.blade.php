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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col items-center justify-center" style="background-color: #efefef">
        <div class="text-center mb-6">
            <a href="/" class="flex justify-center">
                <img src="{{ asset('logo/grow-logo.png') }}" alt="Grow Logo" class="h-16 w-auto" style="margin-top: 20px">
            </a>
        </div>

        <!-- Slot will now allow wider content -->
        <div class="w-full max-w-6xl px-6">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
