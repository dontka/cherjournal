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
        <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(245,214,206,0.45),_transparent_24%),linear-gradient(180deg,_#fffaf7_0%,_#f8f4ef_35%,_#eef2f1_100%)] px-4 py-6 sm:px-6 lg:px-8 lg:py-10">
            <div class="mx-auto max-w-6xl">
                <div class="cj-auth-panel overflow-hidden">
                    <div class="grid min-h-[760px] lg:grid-cols-[1.08fr_0.92fr]">
                        <div class="relative hidden overflow-hidden border-r border-stone-200/80 bg-[linear-gradient(135deg,_#f5ece7_0%,_#f9f5f2_38%,_#edf4f1_100%)] p-8 lg:flex lg:items-end">
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_18%_15%,_rgba(255,255,255,0.8),_transparent_22%),radial-gradient(circle_at_85%_18%,_rgba(215,179,164,0.18),_transparent_28%)]"></div>

                            <div class="relative z-10 w-full max-w-lg">
                                <div class="mb-8 flex items-center gap-3">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-stone-900 text-lg font-semibold text-white shadow-[0_12px_28px_rgba(28,25,23,0.18)]">C</div>
                                    <div>
                                        <p class="text-[10px] font-semibold uppercase tracking-[0.26em] text-stone-500">Cher Journal</p>
                                        <p class="text-lg font-semibold text-stone-800">Le journal intime partagé</p>
                                    </div>
                                </div>

                                <div class="mb-6 flex flex-wrap gap-2">
                                    <span class="cj-pill">Anonymat</span>
                                    <span class="cj-pill">Écoute</span>
                                    <span class="cj-pill">Soutien</span>
                                </div>

                                <h2 class="max-w-md text-4xl font-semibold leading-[1.05] text-stone-900">Un espace pour dire ce que l’on a du mal à exprimer.</h2>
                                <p class="mt-5 max-w-md text-base leading-7 text-stone-600">Des pensées, des ressentis, des jours difficiles et des histoires que l’on ne porte pas toujours seul. Ici, la parole est protégée, la gentleness est prioritaire et les témoignages peuvent aider quelqu’un à retrouver son souffle.</p>

                                <div class="mt-8 grid gap-3 sm:grid-cols-3">
                                    <div class="rounded-[1.4rem] border border-white/60 bg-white/65 p-4 shadow-[0_12px_30px_rgba(49,39,34,0.04)]">
                                        <div class="text-2xl font-semibold text-stone-900">24/7</div>
                                        <div class="mt-1 text-xs uppercase tracking-[0.18em] text-stone-500">écoute</div>
                                    </div>
                                    <div class="rounded-[1.4rem] border border-white/60 bg-white/65 p-4 shadow-[0_12px_30px_rgba(49,39,34,0.04)]">
                                        <div class="text-2xl font-semibold text-stone-900">1.2k</div>
                                        <div class="mt-1 text-xs uppercase tracking-[0.18em] text-stone-500">témoins</div>
                                    </div>
                                    <div class="rounded-[1.4rem] border border-white/60 bg-white/65 p-4 shadow-[0_12px_30px_rgba(49,39,34,0.04)]">
                                        <div class="text-2xl font-semibold text-stone-900">92%</div>
                                        <div class="mt-1 text-xs uppercase tracking-[0.18em] text-stone-500">sérénité</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-center p-5 sm:p-7 lg:p-10">
                            <div class="w-full max-w-md">
                                <div class="mb-8 text-center lg:text-left">
                                    <a href="/" wire:navigate class="inline-flex items-center gap-3 text-stone-800">
                                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-stone-900 via-stone-700 to-stone-500 text-base font-semibold text-white shadow-[0_12px_22px_rgba(28,25,23,0.18)]">C</div>
                                        <span class="text-xs font-semibold uppercase tracking-[0.24em] text-stone-500">Cher Journal</span>
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
