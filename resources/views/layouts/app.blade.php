<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[#0b0b0e] text-gray-100">

<div class="flex h-screen overflow-hidden bg-[#0b0b0e]">

    <!-- SIDEBAR -->
    @include('layouts.navigation')

    <!-- CONTENIDO -->
    <div class="flex-1 flex flex-col overflow-hidden bg-[#12141a]">

        @isset($header)
            <header class="bg-[#12141a] border-b border-white/5">
                <div class="py-6 px-6">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="flex-1 overflow-y-auto p-6 bg-[#12141a] relative">

            <!-- Glow rojo -->
            <div class="absolute inset-0 -z-10 flex justify-center items-center pointer-events-none">
                <div class="w-[85%] h-[85%] bg-red-600/30 blur-[140px] rounded-full"></div>
                <div class="absolute w-[55%] h-[55%] bg-red-500/20 blur-[100px] rounded-full"></div>
            </div>

            {{ $slot }}

        </main>
    </div>

</div>

</body>
</html>