@extends('layouts.app')

@section('title', 'Chapecoense Futsal - Elenco 2026')
@section('description', 'Conheça os atletas que vestem o manto da Chapecoense Futsal na temporada 2026. Elenco completo e estatísticas na Federação Catarinense de Futsal.')

@push('head')
    <style>
        .elenco-hero__img { width: 100%; height: 100%; object-fit: cover; object-position: center 85%; }
        .elenco-hero__tint { position: absolute; inset: 0; z-index: 1; }
        .elenco-hero__wash { position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0, 77, 45, 0.65) 0%, rgba(0, 107, 63, 0.45) 100%); }
        .elenco-hero__grain { position: absolute; inset: 0; width: 100%; height: 100%; mix-blend-mode: overlay; opacity: 0.55; }
        .elenco-hero__content { text-align: center; max-width: 100%; position: relative; z-index: 2; }
        .elenco-hero__content .hero__title { max-width: 100%; margin: 0 auto var(--space-4); text-wrap: balance; }
        .elenco-hero__content .hero__subtitle { max-width: 700px; margin: 0 auto; text-wrap: balance; }

        .elenco-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-xl);
            padding: var(--space-12);
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }
        .elenco-card__title { font-size: var(--font-size-2xl); margin-bottom: var(--space-4); text-wrap: balance; }
        .elenco-card__text { color: var(--color-text-muted); margin: 0 auto var(--space-8); max-width: 60ch; line-height: 1.7; }
        .elenco-cta { white-space: normal; text-align: center; line-height: 1.3; }
        .elenco-cta .material-icons-outlined { font-size: 20px; }
        .elenco-cta:focus-visible { outline: 3px solid var(--color-green); outline-offset: 3px; }

        @media (max-width: 640px) {
            .elenco-card { padding: var(--space-8) var(--space-5); }
            .elenco-cta { width: 100%; justify-content: center; padding: var(--space-4); font-size: var(--font-size-sm); }
        }
    </style>
@endpush

@section('content')

    <!-- HERO -->
    <section class="hero hero--compact">
        <div class="hero__bg">
            <img class="elenco-hero__img" src="{{ asset('images/fotos/IMG_4373.webp') }}" alt="" fetchpriority="high" decoding="async">
        </div>
        <!-- overlay verde com granulado -->
        <div class="elenco-hero__tint" aria-hidden="true">
            <div class="elenco-hero__wash"></div>
            <svg class="elenco-hero__grain" xmlns="http://www.w3.org/2000/svg">
                <filter id="grain">
                    <feTurbulence type="fractalNoise" baseFrequency="0.75" numOctaves="4" stitchTiles="stitch" />
                    <feColorMatrix type="saturate" values="0" />
                    <feBlend in="SourceGraphic" mode="multiply" />
                </filter>
                <rect width="100%" height="100%" filter="url(#grain)" opacity="1" />
            </svg>
        </div>
        <div class="hero__overlay" style="background:rgba(0,0,0,0.1);"></div>
        <div class="hero__content elenco-hero__content">
            <h1 class="hero__title">Elenco 2026</h1>
            <p class="hero__subtitle">Conheça os guerreiros que vestem o manto da Chape Futsal nesta temporada histórica.</p>
        </div>
    </section>

    <!-- ELENCO -->
    <section class="section">
        <div class="container">
            <div class="section-header section-header--center" data-animate>
                <h2 class="section-header__title">Nossos Atletas</h2>
            </div>

            <div class="elenco-card" data-animate>
                <h3 class="elenco-card__title">Elenco Completo 2026</h3>
                <p class="elenco-card__text">
                    Você pode acompanhar detalhes das estatísticas de nossos atletas nas competições organizadas pela
                    Federação Catarinense de Futsal, diretamente no site da entidade, clicando abaixo.
                </p>
                <a href="https://www.futsalsc.com.br/equipe/409044547939847089/chapecoense-futsal" target="_blank"
                    rel="noopener" class="btn btn--primary btn--lg elenco-cta">
                    <span class="material-icons-outlined" aria-hidden="true">groups</span>
                    Ver Elenco e Estatísticas — FCFS
                    <span class="sr-only">(abre em nova aba)</span>
                </a>
            </div>
        </div>
    </section>



    <!-- FOOTER -->
@endsection
