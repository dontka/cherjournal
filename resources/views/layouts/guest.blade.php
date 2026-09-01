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
    <body class="font-sans text-stone-800 antialiased">
        <div class="min-h-screen bg-[#f8f4ef] px-4 py-10 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-5xl">
                <div class="rounded-[2rem] border border-stone-200 bg-white/80 shadow-[0_20px_60px_rgba(50,38,34,0.06)] backdrop-blur-sm">
                    <div class="grid min-h-[720px] lg:grid-cols-[1.1fr_0.9fr]">
                        <div class="hidden items-center justify-center border-r border-stone-200 bg-[#f3eee7] p-10 lg:flex">
                            <div class="max-w-md">
                                <div class="mb-6 flex items-center gap-3">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-stone-900 text-lg font-semibold text-white">C</div>
                                    <div>
                                        <p class="text-[10px] font-semibold uppercase tracking-[0.24em] text-stone-500">Cher Journal</p>
                                        <p class="text-lg font-semibold text-stone-800">Journal intime</p>
                                    </div>
                                </div>
                                <h2 class="text-4xl font-semibold leading-tight text-stone-900">Un espace pour écrire ce que l’on ressent sans pression.</h2>
                                <p class="mt-5 text-base leading-7 text-stone-600">Des pensées, des jours, des émotions, un lieu calme où l’on peut respirer et se redonner de la douceur.</p>
                                <div class="mt-8 space-y-3 text-sm text-stone-700">
                                    <div class="flex items-center gap-3"><span class="inline-block h-2.5 w-2.5 rounded-full bg-stone-900"></span> Écriture libre et respectueuse</div>
                                    <div class="flex items-center gap-3"><span class="inline-block h-2.5 w-2.5 rounded-full bg-stone-900"></span> Anonymat maîtrisé</div>
                                    <div class="flex items-center gap-3"><span class="inline-block h-2.5 w-2.5 rounded-full bg-stone-900"></span> Un cadre rassurant</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-center p-5 sm:p-8 lg:p-10">
                            <div class="w-full max-w-md">
                                <div class="mb-8 text-center lg:text-left">
                                    <a href="/" wire:navigate class="inline-flex items-center gap-3 text-stone-800">
                                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-stone-900 to-stone-700 text-base font-semibold text-white">C</div>
                                        <span class="text-sm font-medium uppercase tracking-[0.2em] text-stone-500">Cher Journal</span>
                                    </a>
                                </div>
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
