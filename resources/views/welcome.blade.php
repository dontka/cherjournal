<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Cher Journal</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans text-stone-800">
        <div class="min-h-screen px-4 py-6 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <header class="cj-shell">
                    <div class="flex items-center justify-between px-6 py-5 sm:px-8">
                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-rose-200 via-orange-100 to-emerald-100 text-lg font-bold text-stone-700 shadow-inner">C</div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-stone-500">Cher Journal</p>
                                <h1 class="text-lg font-semibold text-stone-800">Journal intime &amp; bienveillance</h1>
                            </div>
                        </div>

                        @if (Route::has('login'))
                            <livewire:welcome.navigation />
                        @endif
                    </div>
                </header>

                <main class="mt-8 space-y-8">
                    <section class="cj-shell overflow-hidden">
                        <div class="grid gap-8 px-6 py-8 sm:px-8 lg:grid-cols-[1.2fr_0.8fr] lg:items-center lg:px-12 lg:py-12">
                            <div>
                                <span class="cj-pill">Espace de paix • sécurité • anonymat</span>
                                <h2 class="mt-6 text-4xl font-extrabold tracking-tight text-stone-900 sm:text-5xl">
                                    Écris pour te libérer, sans pression, sans jugement.
                                </h2>
                                <p class="mt-5 max-w-xl text-lg leading-8 text-stone-600">
                                    Cher Journal aide chacun à exprimer ses émotions, raconter ses journées, trouver du soutien dans une communauté bienveillante et rester maître de son anonymat.
                                </p>

                                <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-full bg-stone-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-stone-900/10 transition hover:bg-stone-700">
                                            Créer mon journal
                                        </a>
                                    @endif
                                    @if (Route::has('login'))
                                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full border border-stone-300 bg-white px-6 py-3 text-sm font-semibold text-stone-700 transition hover:border-stone-400 hover:bg-stone-50">
                                            Je me connecte
                                        </a>
                                    @endif
                                </div>

                                <div class="mt-8 flex flex-wrap gap-4 text-sm text-stone-600">
                                    <span class="rounded-full bg-rose-50 px-3 py-2">💬 Écriture libre</span>
                                    <span class="rounded-full bg-emerald-50 px-3 py-2">🫶 Soutien bienveillant</span>
                                    <span class="rounded-full bg-violet-50 px-3 py-2">🔒 Anonymat maîtrisé</span>
                                </div>
                            </div>

                            <div class="relative">
                                <div class="relative overflow-hidden rounded-[2rem] border border-rose-100 bg-gradient-to-br from-rose-100 via-white to-emerald-100 p-5 shadow-[0_30px_80px_rgba(145,125,116,0.18)]">
                                    <div class="rounded-[1.5rem] bg-white/85 p-5 shadow-sm ring-1 ring-stone-200/80">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-11 w-11 items-center justify-center rounded-full bg-gradient-to-br from-rose-200 to-orange-100 text-sm font-bold text-stone-700">LV</div>
                                                <div>
                                                    <p class="font-semibold text-stone-900">La vie en douceur</p>
                                                    <p class="text-xs text-stone-500">Aujourd’hui • 09:42</p>
                                                </div>
                                            </div>
                                            <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.2em] text-emerald-700">Public</span>
                                        </div>

                                        <div class="mt-5 space-y-4 text-sm leading-7 text-stone-600">
                                            <p>« J’ai eu une journée lourde, mais j’ai réussi à respirer un peu. Je veux garder cette trace pour me rappeler que je peux aller plus loin que je ne le pense. »</p>
                                            <div class="flex flex-wrap gap-2">
                                                <span class="rounded-full bg-rose-50 px-2.5 py-1 text-xs text-rose-700">#fatigue</span>
                                                <span class="rounded-full bg-violet-50 px-2.5 py-1 text-xs text-violet-700">#soulagement</span>
                                                <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs text-emerald-700">#reprise</span>
                                            </div>
                                        </div>

                                        <div class="mt-5 flex items-center justify-between border-t border-stone-200 pt-4 text-xs text-stone-500">
                                            <span>❤ 124</span>
                                            <span>💬 18</span>
                                            <span>🔒 anonyme</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="grid gap-6 md:grid-cols-3">
                        <article class="cj-card">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-100 text-2xl">✍️</div>
                            <h3 class="text-xl font-semibold text-stone-900">Journal personnel</h3>
                            <p class="mt-3 text-sm leading-6 text-stone-600">
                                Garde une trace de tes pensées, de tes émotions et de tes progrès au fil du temps.
                            </p>
                        </article>

                        <article class="cj-card">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-2xl">🫶</div>
                            <h3 class="text-xl font-semibold text-stone-900">Soutien bienveillant</h3>
                            <p class="mt-3 text-sm leading-6 text-stone-600">
                                Reçois des encouragements et des réactions respectueuses, sans exposer ta vie privée.
                            </p>
                        </article>

                        <article class="cj-card">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-violet-100 text-2xl">🔒</div>
                            <h3 class="text-xl font-semibold text-stone-900">Anonymat maîtrisé</h3>
                            <p class="mt-3 text-sm leading-6 text-stone-600">
                                Contrôle ce que tu montres, ce que tu gardes privé et qui peut voir tes écrits.
                            </p>
                        </article>
                    </section>

                    <section class="cj-shell px-6 py-8 sm:px-8 lg:px-12">
                        <div class="grid gap-8 lg:grid-cols-2 lg:items-center">
                            <div>
                                <span class="cj-pill">Pourquoi Cher Journal</span>
                                <h3 class="mt-5 text-3xl font-bold tracking-tight text-stone-900">Un espace pensé pour respirer, raconter et tenir.</h3>
                                <ul class="mt-6 space-y-4 text-stone-600">
                                    <li class="flex gap-3"><span class="mt-1 text-rose-500">•</span><span>Des écrits sans jugement, dans un cadre calme et rassurant.</span></li>
                                    <li class="flex gap-3"><span class="mt-1 text-rose-500">•</span><span>Une communauté qui encourage la gentillesse, le respect et la solidarité.</span></li>
                                    <li class="flex gap-3"><span class="mt-1 text-rose-500">•</span><span>Des outils de confidentialité pour protéger ton identité et ton espace intime.</span></li>
                                </ul>
                            </div>

                            <div class="rounded-[2rem] bg-gradient-to-br from-stone-900 via-stone-800 to-stone-700 p-6 text-stone-100 shadow-[0_30px_80px_rgba(41,35,34,0.25)]">
                                <div class="rounded-2xl bg-white/5 p-5 ring-1 ring-white/10">
                                    <p class="text-xs uppercase tracking-[0.25em] text-stone-300">Aujourd’hui</p>
                                    <h4 class="mt-4 text-2xl font-semibold">« Je peux rester honnête avec moi-même. »</h4>
                                    <div class="mt-6 flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-sm font-semibold">A</div>
                                        <div>
                                            <p class="font-medium">Anonyme</p>
                                            <p class="text-sm text-stone-300">Entrée publique</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </main>
            </div>
        </div>
    </body>
</html>
