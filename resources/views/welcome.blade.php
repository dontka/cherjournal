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
        <div class="min-h-screen bg-[#f5efe9] text-stone-800">
            <div class="mx-auto max-w-[1460px] px-4 pb-10 pt-5 sm:px-6 lg:px-8">
                <header class="sticky top-4 z-50 mx-auto max-w-[1280px] rounded-[0.7rem] border border-stone-200 bg-white/75 px-3 py-3 shadow-[0_14px_35px_rgba(70,54,48,0.06)] backdrop-blur-sm sm:px-4">
                    <div class="flex items-center justify-between gap-2 sm:gap-3">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-[0.7rem] bg-[#1c1a18] text-sm font-semibold text-white sm:h-10 sm:w-10 sm:text-base">C</div>
                            <div>
                                <p class="text-[9px] font-semibold uppercase tracking-[0.2em] text-stone-500 sm:text-[10px]">Cher Journal</p>
                                <p class="text-xs font-medium text-stone-700 sm:text-sm">Journal intime</p>
                            </div>
                        </div>

                        <nav class="hidden items-center gap-2 md:flex">
                            <a href="#mission" class="rounded-md px-3 py-2 text-sm text-stone-600 transition duration-200 hover:bg-stone-100 hover:text-stone-900">Le produit</a>
                            <a href="#process" class="rounded-md px-3 py-2 text-sm text-stone-600 transition duration-200 hover:bg-stone-100 hover:text-stone-900">Fonctionnement</a>
                            <a href="#impact" class="rounded-md px-3 py-2 text-sm text-stone-600 transition duration-200 hover:bg-stone-100 hover:text-stone-900">Impact</a>
                        </nav>

                        <div class="flex items-center gap-2">
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="hidden rounded-md border border-stone-300 bg-white px-3 py-2 text-xs font-medium text-stone-700 transition duration-200 hover:border-stone-400 sm:inline-flex sm:px-4 sm:text-sm">Connexion</a>
                            @endif
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex rounded-md bg-stone-900 px-3 py-2 text-xs font-semibold text-white transition duration-200 hover:bg-stone-700 sm:px-4 sm:text-sm">Créer mon journal</a>
                            @endif
                        </div>
                    </div>
                </header>

                <main class="mx-auto max-w-[1280px] pt-8">
                    <section id="mission" class="overflow-hidden rounded-[0.9rem] border border-stone-200 bg-[#f3eee8] shadow-[0_20px_60px_rgba(60,49,44,0.08)]">
                        <div class="grid gap-6 px-4 py-5 sm:px-8 lg:grid-cols-[1.08fr_0.92fr] lg:gap-10 lg:px-10 lg:py-10 xl:px-12">
                            <div class="flex flex-col justify-center">
                                <span class="inline-flex w-fit items-center rounded-md border border-stone-200 bg-white/80 px-3 py-1.5 text-[10px] font-semibold uppercase tracking-[0.22em] text-stone-600">
                                    Un espace de parole sans jugement
                                </span>

                                <h1 class="mt-5 max-w-[620px] text-[2.3rem] font-black leading-[0.96] tracking-[-0.06em] text-stone-900 sm:text-5xl lg:text-[5rem]">
                                    Le journal intime que l’on partage avec douceur.
                                </h1>

                                <p class="mt-4 max-w-xl text-sm leading-7 text-stone-600 sm:text-base sm:leading-8 lg:text-lg">
                                    Cher Journal aide chacun à raconter son quotidien, ses émotions et ses difficultés dans un cadre bienveillant, anonyme et sécurisant, avec la possibilité d’être accompagné, entendu et soutenu.
                                </p>

                                <div class="mt-6 flex flex-col gap-3 sm:mt-8 sm:flex-row">
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-md bg-stone-900 px-5 py-3 text-sm font-semibold text-white transition duration-200 hover:-translate-y-0.5 hover:bg-stone-700 sm:px-6">
                                            Ouvrir mon journal
                                        </a>
                                    @endif
                                    @if (Route::has('login'))
                                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-md border border-stone-300 bg-white px-5 py-3 text-sm font-semibold text-stone-700 transition duration-200 hover:-translate-y-0.5 hover:border-stone-400 hover:bg-stone-50 sm:px-6">
                                            Je me connecte
                                        </a>
                                    @endif
                                </div>

                                <div class="mt-6 flex flex-wrap gap-2 text-[11px] text-stone-600 sm:mt-8 sm:gap-3 sm:text-xs">
                                    <span class="rounded-md border border-stone-200 bg-white/80 px-3 py-2">✍️ Écriture libre</span>
                                    <span class="rounded-md border border-stone-200 bg-white/80 px-3 py-2">🔒 Anonymat maîtrisé</span>
                                    <span class="rounded-md border border-stone-200 bg-white/80 px-3 py-2">💬 Soutien humain</span>
                                </div>
                            </div>

                            <div class="grid gap-3 sm:grid-cols-2 sm:gap-4">
                                <div class="group rounded-[1.15rem] border border-stone-200 bg-white/80 p-4 shadow-[0_18px_40px_rgba(56,45,40,0.05)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_22px_48px_rgba(56,45,40,0.09)] sm:col-span-2">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-stone-500">Aujourd’hui</p>
                                            <h2 class="mt-2 text-xl font-semibold text-stone-900">Vue d’ensemble</h2>
                                        </div>
                                        <span class="rounded-full bg-emerald-100 px-2 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-emerald-700">En ligne</span>
                                    </div>

                                    <div class="mt-5 rounded-[0.9rem] border border-stone-200 bg-[#f9f6f3] p-4">
                                        <div class="flex items-start justify-between gap-3">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-stone-900 text-xs font-semibold text-white">A</div>
                                                <div>
                                                    <p class="text-sm font-semibold text-stone-900">Anonyme</p>
                                                    <p class="text-[11px] text-stone-500">Journal public • 09:42</p>
                                                </div>
                                            </div>
                                            <span class="rounded-full bg-stone-200 px-2 py-1 text-[10px] text-stone-600">Privé par défaut</span>
                                        </div>

                                        <p class="mt-4 text-sm leading-7 text-stone-600">
                                            « J’ai eu une journée lourde. Je ne savais pas comment en parler. Écrire m’a aidé à reprendre le contrôle. »
                                        </p>

                                        <div class="mt-4 flex flex-wrap gap-2 text-[10px]">
                                            <span class="rounded-full bg-rose-50 px-2 py-1 text-rose-700">#fatigue</span>
                                            <span class="rounded-full bg-violet-50 px-2 py-1 text-violet-700">#reconnaissance</span>
                                            <span class="rounded-full bg-emerald-50 px-2 py-1 text-emerald-700">#soulagement</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="group rounded-[1.15rem] border border-stone-200 bg-white/80 p-4 shadow-[0_18px_40px_rgba(56,45,40,0.05)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_22px_48px_rgba(56,45,40,0.09)]">
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-stone-500">Réactions</p>
                                    <div class="mt-4 space-y-3">
                                        <div class="flex items-center justify-between rounded-[0.7rem] bg-[#f7f3ef] p-2.5">
                                            <span class="text-sm text-stone-700">💬 184 messages</span>
                                            <span class="text-xs text-emerald-700">+12%</span>
                                        </div>
                                        <div class="flex items-center justify-between rounded-[0.7rem] bg-[#f7f3ef] p-2.5">
                                            <span class="text-sm text-stone-700">❤️ 1.2k soutien</span>
                                            <span class="text-xs text-emerald-700">+19%</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="group rounded-[1.15rem] border border-stone-200 bg-[#1d1a18] p-4 text-stone-100 shadow-[0_18px_40px_rgba(31,27,24,0.15)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_22px_48px_rgba(31,27,24,0.22)]">
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-400">Soutien</p>
                                    <div class="mt-4 rounded-[0.8rem] border border-white/10 bg-white/5 p-3">
                                        <div class="flex items-center justify-between text-sm">
                                            <span>Campagne</span>
                                            <span class="font-semibold">2,400 €</span>
                                        </div>
                                        <div class="mt-3 h-2.5 overflow-hidden rounded-full bg-white/10">
                                            <div class="h-full w-[72%] rounded-full bg-gradient-to-r from-rose-300 via-amber-200 to-emerald-300"></div>
                                        </div>
                                        <div class="mt-2 flex justify-between text-[10px] text-stone-300">
                                            <span>72% atteint</span>
                                            <span>12 dons</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="group rounded-[1.15rem] border border-stone-200 bg-[#f4e8db] p-4 shadow-[0_18px_40px_rgba(56,45,40,0.05)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_22px_48px_rgba(56,45,40,0.09)]">
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-stone-500">Catégories</p>
                                    <div class="mt-4 flex flex-wrap gap-2 text-[10px]">
                                        <span class="rounded-full bg-white px-2 py-1 text-stone-700">Amour</span>
                                        <span class="rounded-full bg-white px-2 py-1 text-stone-700">Travail</span>
                                        <span class="rounded-full bg-white px-2 py-1 text-stone-700">Famille</span>
                                        <span class="rounded-full bg-white px-2 py-1 text-stone-700">Stress</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <article class="rounded-[0.9rem] border border-stone-200 bg-white/80 p-4 shadow-[0_18px_40px_rgba(80,66,58,0.04)] sm:p-5">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-[0.7rem] bg-[#f5d7d2] text-xl">✍️</div>
                            <h3 class="text-xl font-semibold text-stone-900">Écriture libre</h3>
                            <p class="mt-3 text-sm leading-7 text-stone-600">Partager un texte ou une pensée sans pression ni jugement.</p>
                        </article>

                        <article class="rounded-[0.9rem] border border-stone-200 bg-white/80 p-4 shadow-[0_18px_40px_rgba(80,66,58,0.04)] sm:p-5">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-[0.7rem] bg-[#dfe8df] text-xl">🎧</div>
                            <h3 class="text-xl font-semibold text-stone-900">Podcast</h3>
                            <p class="mt-3 text-sm leading-7 text-stone-600">Exprimer sa voix à travers des témoignages audio plus intimes.</p>
                        </article>

                        <article class="rounded-[0.9rem] border border-stone-200 bg-white/80 p-4 shadow-[0_18px_40px_rgba(80,66,58,0.04)] sm:p-5">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-[0.7rem] bg-[#e9e1ff] text-xl">🤝</div>
                            <h3 class="text-xl font-semibold text-stone-900">Soutien</h3>
                            <p class="mt-3 text-sm leading-7 text-stone-600">Recevoir des messages, des encouragements et de l’empathie.</p>
                        </article>

                        <article class="rounded-[0.9rem] border border-stone-200 bg-white/80 p-4 shadow-[0_18px_40px_rgba(80,66,58,0.04)] sm:p-5">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-[0.7rem] bg-[#f2e6cf] text-xl">💛</div>
                            <h3 class="text-xl font-semibold text-stone-900">Dons</h3>
                            <p class="mt-3 text-sm leading-7 text-stone-600">Aider une personne en difficulté via des contributions bienveillantes.</p>
                        </article>
                    </section>

                    <section id="process" class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        <article class="rounded-[0.9rem] border border-stone-200 bg-white/80 p-4 shadow-[0_18px_40px_rgba(80,66,58,0.04)] transition duration-200 hover:-translate-y-1 sm:p-5">
                            <div class="flex items-center gap-3">
                                <span class="flex h-9 w-9 items-center justify-center rounded-md bg-[#f4d7d0] text-sm font-semibold text-stone-800">01</span>
                                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-stone-500">Publier</p>
                            </div>
                            <h3 class="mt-5 text-2xl font-semibold text-stone-900">Écrire sans pression</h3>
                            <p class="mt-3 text-sm leading-7 text-stone-600">
                                L’utilisateur peut partager un texte ou un podcast dans un cadre pensé pour la sécurité émotionnelle et la confidentialité.
                            </p>
                        </article>

                        <article class="rounded-[0.9rem] border border-stone-200 bg-white/80 p-4 shadow-[0_18px_40px_rgba(80,66,58,0.04)] transition duration-200 hover:-translate-y-1 sm:p-5">
                            <div class="flex items-center gap-3">
                                <span class="flex h-9 w-9 items-center justify-center rounded-md bg-[#dfe8df] text-sm font-semibold text-stone-800">02</span>
                                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-stone-500">Reconnaître</p>
                            </div>
                            <h3 class="mt-5 text-2xl font-semibold text-stone-900">Se retrouver dans les autres</h3>
                            <p class="mt-3 text-sm leading-7 text-stone-600">
                                Les publications sont classées par thèmes pour permettre à chacun de découvrir des histoires proches de son parcours.
                            </p>
                        </article>

                        <article class="rounded-[0.9rem] border border-stone-200 bg-white/80 p-4 shadow-[0_18px_40px_rgba(80,66,58,0.04)] transition duration-200 hover:-translate-y-1 sm:col-span-2 sm:p-5 lg:col-span-1">
                            <div class="flex items-center gap-3">
                                <span class="flex h-9 w-9 items-center justify-center rounded-md bg-[#e9e1ff] text-sm font-semibold text-stone-800">03</span>
                                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-stone-500">Soutenir</p>
                            </div>
                            <h3 class="mt-5 text-2xl font-semibold text-stone-900">Recevoir de la chaleur</h3>
                            <p class="mt-3 text-sm leading-7 text-stone-600">
                                Réactions, messages de soutien et dons viennent renforcer la connexion humaine sans exposer l’identité.
                            </p>
                        </article>
                    </section>

                    <section class="mt-8 rounded-[0.9rem] border border-stone-200 bg-[#f7f1ea] p-4 sm:p-6">
                        <div class="grid gap-5 lg:grid-cols-[1fr_1.4fr] lg:items-center">
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-500">Public cible</p>
                                <h3 class="mt-3 text-2xl font-semibold text-stone-900 sm:text-3xl">Pour ceux qui cherchent une place sûre pour se dire.</h3>
                            </div>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="rounded-[0.8rem] border border-stone-200 bg-white/80 p-4">
                                    <p class="text-sm font-semibold text-stone-900">Adolescents et jeunes adultes</p>
                                    <p class="mt-2 text-sm leading-7 text-stone-600">Cherchent un environnement serein pour exprimer leur vécu.</p>
                                </div>
                                <div class="rounded-[0.8rem] border border-stone-200 bg-white/80 p-4">
                                    <p class="text-sm font-semibold text-stone-900">Personnes en difficulté</p>
                                    <p class="mt-2 text-sm leading-7 text-stone-600">Souhaitent être entendues et reçues sans jugement ni exposition.</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section id="impact" class="mt-8 overflow-hidden rounded-[0.9rem] border border-stone-200 bg-[#1e1b1a] px-5 py-7 text-stone-100 shadow-[0_24px_60px_rgba(31,27,24,0.18)] sm:px-8 lg:px-10">
                        <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-stone-400">Pourquoi ça compte</p>
                                <h2 class="mt-4 max-w-xl text-3xl font-semibold leading-tight text-white sm:text-4xl">
                                    Une plateforme conçue pour faire tomber la solitude, pas le secret.
                                </h2>
                                <p class="mt-4 max-w-lg text-base leading-8 text-stone-300">
                                    Cher Journal ne se limite pas à un blog social. Il crée une rencontre entre écriture, empathie, anonymat et solidarité, avec une attention particulière à la protection de ses utilisateurs.
                                </p>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="rounded-[0.8rem] border border-white/10 bg-white/5 p-4">
                                    <p class="text-sm text-stone-300">Anonymat</p>
                                    <p class="mt-2 text-3xl font-semibold text-white">100%</p>
                                    <p class="mt-2 text-xs text-stone-400">Contrôle sur l’identité et la visibilité</p>
                                </div>
                                <div class="rounded-[0.8rem] border border-white/10 bg-white/5 p-4">
                                    <p class="text-sm text-stone-300">Soutien</p>
                                    <p class="mt-2 text-3xl font-semibold text-white">24/7</p>
                                    <p class="mt-2 text-xs text-stone-400">Réactions, messages et gestes solidaires</p>
                                </div>
                                <div class="rounded-[0.8rem] border border-white/10 bg-white/5 p-4 sm:col-span-2">
                                    <p class="text-sm text-stone-300">Proposition de valeur</p>
                                    <p class="mt-3 text-lg leading-8 text-stone-100">
                                        « Pour que personne ne soit seul dans ses émotions, et pour que chacun puisse trouver un lieu où la parole est respectée. »
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="mt-8 rounded-[0.9rem] border border-stone-200 bg-white/80 px-4 py-6 text-center shadow-[0_18px_40px_rgba(80,66,58,0.04)] sm:px-8 sm:py-8">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-stone-500">Prêt à écrire ?</p>
                        <h3 class="mt-3 text-2xl font-semibold text-stone-900 sm:text-3xl lg:text-4xl">Créez votre espace de vie intérieure.</h3>
                        <p class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-stone-600 sm:text-base sm:leading-8">
                            Rejoignez une communauté où l’on peut s’exprimer, se reconnaître et se soutenir, sans risquer son anonymat ni sa tranquillité.
                        </p>
                        <div class="mt-6 flex flex-col justify-center gap-3 sm:flex-row">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-md bg-stone-900 px-5 py-3 text-sm font-semibold text-white transition duration-200 hover:-translate-y-0.5 hover:bg-stone-700 sm:px-6">Créer mon journal</a>
                            @endif
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-md border border-stone-300 bg-white px-5 py-3 text-sm font-semibold text-stone-700 transition duration-200 hover:-translate-y-0.5 hover:border-stone-400 hover:bg-stone-50 sm:px-6">Connexion</a>
                            @endif
                        </div>
                    </section>
                </main>

                <footer class="mx-auto mt-8 max-w-[1280px] border-t border-stone-200/80 py-8">
                    <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-[0.7rem] bg-stone-900 text-sm font-semibold text-white">C</div>
                            <div>
                                <p class="text-sm font-semibold text-stone-900">Cher Journal</p>
                                <p class="text-sm text-stone-500">Écrire pour se comprendre, respirer et avancer.</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-3 text-sm text-stone-600">
                            <a href="#mission" class="rounded-md px-2.5 py-1.5 transition duration-200 hover:bg-stone-100 hover:text-stone-900">Le produit</a>
                            <a href="#process" class="rounded-md px-2.5 py-1.5 transition duration-200 hover:bg-stone-100 hover:text-stone-900">Fonctionnement</a>
                            <a href="#impact" class="rounded-md px-2.5 py-1.5 transition duration-200 hover:bg-stone-100 hover:text-stone-900">Impact</a>
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="rounded-md px-2.5 py-1.5 transition duration-200 hover:bg-stone-100 hover:text-stone-900">Connexion</a>
                            @endif
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-md bg-stone-900 px-3 py-1.5 text-white transition duration-200 hover:bg-stone-700">S’inscrire</a>
                            @endif
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
