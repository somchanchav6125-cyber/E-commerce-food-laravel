<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token"  content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">

        <!-- Background Container -->
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0
                    bg-gradient-to-br from-indigo-100 via-purple-100 to-pink-100
                    animate-gradient-x relative overflow-hidden">

            <!-- Optional animated floating circles for lively effect -->
            <span class="absolute w-72 h-72 bg-indigo-300 rounded-full opacity-30 top-[-5rem] left-[-5rem] animate-pulse-slow"></span>
            <span class="absolute w-56 h-56 bg-pink-300 rounded-full opacity-20 bottom-[-3rem] right-[-3rem] animate-pulse-slow"></span>

            <!-- Main Card -->
<div class="mx-auto w-full sm:max-w-lg md:max-w-xl lg:max-w-2xl mt-10 px-10 py-12 bg-white/90 backdrop-blur-sm shadow-2xl rounded-3xl border border-gray-100">
    {{ $slot }}
</div>
        </div>

        <!-- Styles for animation -->
        <style>
            /* Gradient background animation */
            @keyframes gradientShift {
                0%{background-position:0% 50%}
                50%{background-position:100% 50%}
                100%{background-position:0% 50%}
            }
            .animate-gradient-x {
                background-size: 200% 200%;
                animation: gradientShift 15s ease infinite;
            }

            /* Slow floating circles animation */
            @keyframes pulse-slow {
                0%,100%{transform: scale(1);}
                50%{transform: scale(1.1);}
            }
            .animate-pulse-slow { animation: pulse-slow 8s ease-in-out infinite; }
        </style>

    </body>
</html>
