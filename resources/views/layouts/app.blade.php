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
    <body data-cj-theme="{{ auth()->user()->profile?->theme ?: 'rose' }}" class="font-sans antialiased text-stone-800">
        <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(246,215,208,0.35),_transparent_25%),linear-gradient(180deg,_#fffaf7_0%,_#f7f3f0_30%,_#f1f5f3_100%)]">
            <livewire:layout.navigation />

            <main class="pb-8">
                @if (isset($header))
                    <div class="mx-auto max-w-[1380px] px-2 pt-6 sm:px-3 lg:px-4">
                        <div class="rounded-[1.75rem] border border-white/70 bg-white/80 px-5 py-4 shadow-[0_16px_40px_rgba(89,72,67,0.08)] backdrop-blur-sm sm:px-6">
                            {{ $header }}
                        </div>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </body>
</html>
