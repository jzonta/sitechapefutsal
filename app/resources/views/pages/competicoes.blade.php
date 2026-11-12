@extends('layouts.app')

@section('title', 'Competições 2026 | Chapecoense Futsal')
@section('description', 'Conheça as competições que a Chapecoense Futsal disputa em 2026: Campeonato Brasileiro de Futsal, Catarinense Série Ouro e Copa Santa Catarina, com links para tabelas e sites oficiais.')

@push('head')
    <style>
        /* Página Competições: refinamentos locais, usando os tokens do site */
        .skip-link { position: absolute; left: var(--space-4); top: -100px; z-index: 1000; padding: var(--space-2) var(--space-4); background: var(--color-green); color: #fff; border-radius: var(--radius-md); font-weight: 600; }
        .skip-link:focus { top: var(--space-2); }
        a:focus-visible, .mobile-toggle:focus-visible { outline: 3px solid var(--color-green); outline-offset: 3px; border-radius: var(--radius-md); }
        .hero a:focus-visible, .newsletter a:focus-visible { outline-color: #fff; }
        ::selection { background: var(--color-green); color: #fff; }

        .comp-hero__fx { position: absolute; inset: 0; z-index: 1; }
        .comp-hero__tint { position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0,77,45,0.72) 0%, rgba(0,107,63,0.5) 100%); }
        .comp-hero__grain { position: absolute; inset: 0; width: 100%; height: 100%; mix-blend-mode: overlay; opacity: 0.55; }
        .hero__bg img { object-position: center 15%; }
        .comp-hero__content { text-align: center; max-width: 100%; position: relative; z-index: 2; }
        .comp-hero__content .hero__badge { margin: 0 auto var(--space-6); }
        .comp-hero__content .hero__title { max-width: 100%; margin: 0 auto var(--space-4); text-wrap: balance; }
        .comp-hero__content .hero__subtitle { max-width: 700px; margin: 0 auto; opacity: 1; text-wrap: pretty; }

        .comp-intro { max-width: 680px; text-wrap: pretty; }

        .comp-list { list-style: none; margin: 0; padding: 0; }
        .comp-list > li { display: flex; }
        .comp-list > li > .comp-card { flex: 1; }
        .comp-card__head { display: flex; align-items: center; justify-content: space-between; gap: var(--space-3); }
        .comp-card__icon { width: 56px; height: 56px; flex: none; border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; color: #fff; background: var(--gradient-green); }
        .comp-card__icon--gold { background: var(--gradient-gold); }
        .comp-card__badge--green { background: var(--color-green-bg); color: var(--color-green); }
        .comp-card .btn { align-self: flex-start; }
        .comp-card .btn .material-icons-outlined { font-size: 16px; }

        .comp-cta { background: var(--gradient-green); }
        .comp-cta .newsletter__content { max-width: 600px; }
        .comp-cta .newsletter__title { font-size: var(--font-size-3xl); text-wrap: balance; }
        .comp-cta .newsletter__text { font-size: var(--font-size-base); opacity: 0.92; max-width: 55ch; }

        @media (max-width: 1024px) and (min-width: 641px) {
            .comp-list > li:last-child:nth-child(odd) { grid-column: 1 / -1; }
        }
        @media (max-width: 640px) {
            .comp-card .btn { align-self: stretch; justify-content: center; }
            .comp-cta { padding: var(--space-8) var(--space-6); }
            .comp-cta .newsletter__title { font-size: var(--font-size-2xl); }
        }
        @media (prefers-reduced-motion: reduce) {
            .comp-card, .comp-card:hover { transform: none; transition: none; }
        }
    </style>
@endpush

@section('content')

    <main id="conteudo">
    <!-- HERO -->
    <section class="hero hero--compact">
        <div class="hero__bg">
            <img src="{{ asset('images/fotos/IMG_4346.webp') }}" alt="" fetchpriority="high" decoding="async">
        </div>
        <!-- overlay verde com granulado -->
        <div class="comp-hero__fx" aria-hidden="true">
            <div class="comp-hero__tint"></div>
            <svg class="comp-hero__grain" xmlns="http://www.w3.org/2000/svg">
                <filter id="grain">
                    <feTurbulence type="fractalNoise" baseFrequency="0.75" numOctaves="4" stitchTiles="stitch" />
                    <feColorMatrix type="saturate" values="0" />
                    <feBlend in="SourceGraphic" mode="multiply" />
                </filter>
                <rect width="100%" height="100%" filter="url(#grain)" opacity="1" />
            </svg>
        </div>
        <div class="hero__overlay" style="background:rgba(0,0,0,0.1);"></div>
        <div class="hero__content comp-hero__content">
            <div class="hero__badge">
                <span class="material-icons-outlined" style="font-size:16px;" aria-hidden="true">emoji_events</span>
                Temporada 2026
            </div>
            <h1 class="hero__title">Competições Ativas</h1>
            <p class="hero__subtitle">Conheça os campeonatos que a Chapecoense Futsal disputa em 2026 e acompanhe
                tabelas e classificações nos sites oficiais.</p>
        </div>
    </section>

    <!-- COMPETIÇÕES -->
    <section class="section" aria-labelledby="titulo-competicoes">
        <div class="container">
            <div class="section-header section-header--center" data-animate>
                <h2 class="section-header__title" id="titulo-competicoes">Nossos Desafios</h2>
                <p class="section-header__subtitle comp-intro">Em 2026, a equipe principal da Chape Futsal disputa o
                    Campeonato Brasileiro de Futsal, o Campeonato Catarinense Série Ouro e a Copa Santa Catarina. As
                    categorias de base também têm as suas próprias competições.</p>
            </div>

            <ul class="grid grid-3 gap-8 comp-list">
                <!-- Brasileiro -->
                <li data-animate data-delay="100">
                    <article class="comp-card">
                        <div class="comp-card__head">
                            <div class="comp-card__icon comp-card__icon--gold" aria-hidden="true">
                                <span class="material-icons-outlined" style="font-size:28px;" aria-hidden="true">emoji_events</span>
                            </div>
                            <span class="comp-card__badge">Nacional</span>
                        </div>
                        <h3 class="comp-card__title">Campeonato Brasileiro de Futsal</h3>
                        <p class="comp-card__text">Pela primeira vez na história, a Chape Futsal disputa o Campeonato
                            Brasileiro de Futsal, enfrentando as melhores equipes do país.</p>
                        <a href="https://www.cbfs.com.br/" target="_blank" rel="noopener" class="btn btn--secondary">
                            Acessar Site Oficial
                            <span class="sr-only">(CBFS, abre em nova aba)</span>
                            <span class="material-icons-outlined" aria-hidden="true">open_in_new</span>
                        </a>
                    </article>
                </li>

                <!-- Catarinense -->
                <li data-animate data-delay="200">
                    <article class="comp-card">
                        <div class="comp-card__head">
                            <div class="comp-card__icon" aria-hidden="true">
                                <span class="material-icons-outlined" style="font-size:28px;" aria-hidden="true">shield</span>
                            </div>
                            <span class="comp-card__badge comp-card__badge--green">Estadual</span>
                        </div>
                        <h3 class="comp-card__title">Catarinense Série Ouro</h3>
                        <p class="comp-card__text">A elite do futsal de Santa Catarina. Disputa acirrada entre as
                            potências do estado para definir o campeão catarinense.</p>
                        <a href="https://futsalsc.com.br/" target="_blank" rel="noopener" class="btn btn--secondary">
                            Ver Tabela
                            <span class="sr-only">do Catarinense Série Ouro (abre em nova aba)</span>
                            <span class="material-icons-outlined" aria-hidden="true">open_in_new</span>
                        </a>
                    </article>
                </li>

                <!-- Copa SC -->
                <li data-animate data-delay="300">
                    <article class="comp-card">
                        <div class="comp-card__head">
                            <div class="comp-card__icon" aria-hidden="true">
                                <span class="material-icons-outlined" style="font-size:28px;" aria-hidden="true">military_tech</span>
                            </div>
                            <span class="comp-card__badge comp-card__badge--green">Estadual</span>
                        </div>
                        <h3 class="comp-card__title">Copa Santa Catarina</h3>
                        <p class="comp-card__text">Competição estadual que reúne as principais equipes catarinenses em
                            confrontos emocionantes pela taça.</p>
                        <a href="https://www.futsalsc.com.br/" target="_blank" rel="noopener" class="btn btn--secondary">
                            Acompanhar Jogos
                            <span class="sr-only">da Copa Santa Catarina (abre em nova aba)</span>
                            <span class="material-icons-outlined" aria-hidden="true">open_in_new</span>
                        </a>
                    </article>
                </li>
            </ul>
        </div>
    </section>

    <!-- SÓCIO TORCEDOR -->
    <section class="section" aria-labelledby="titulo-socio">
        <div class="container">
            <div class="newsletter comp-cta" data-animate>
                <div class="newsletter__content">
                    <h2 class="newsletter__title" id="titulo-socio">Seja Sócio Torcedor</h2>
                    <p class="newsletter__text">
                        Apoie a Chapecoense Futsal em todas as competições e tenha acesso a benefícios exclusivos e
                        descontos em ingressos.
                    </p>
                    <a href="https://chapefutsal.socioclube.com.br/associe-se.aspx" target="_blank" rel="noopener"
                        class="btn btn--white btn--lg">
                        <span class="material-icons-outlined" style="font-size:20px;" aria-hidden="true">card_membership</span>
                        Quero ser Sócio
                        <span class="sr-only">(abre em nova aba)</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    </main>
@endsection
