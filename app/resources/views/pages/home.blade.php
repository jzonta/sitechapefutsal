@extends('layouts.app')

@section('title', 'Chapecoense Futsal | Site oficial do Verdão das Quadras')
@section('description', 'Site oficial da Associação Chapecoense de Futsal. Acompanhe notícias, elenco, competições e muito mais do Verdão das Quadras.')

@push('head')
    <meta name="theme-color" content="#006b3f">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:description" content="Notícias, jogos, ingressos e conquistas da Associação Chapecoense de Futsal, o Verdão das Quadras.">
    <meta name="twitter:card" content="summary">
    @if ($destaque?->imagem)
    <link rel="preload" as="image" href="{{ asset($destaque->imagem) }}" fetchpriority="high">
    @endif
  <style>
    /* ===== Ajustes da home (escopo desta página) ===== */

    /* Foco visível para teclado */
    a:focus-visible,
    button:focus-visible {
      outline: 3px solid var(--color-green);
      outline-offset: 3px;
      border-radius: var(--radius-md);
    }
    .home-hero:focus-visible,
    .honors-strip a:focus-visible {
      outline-color: #fff;
      outline-offset: -6px;
    }
    .mobile-toggle { background: none; border: 0; }

    /* Banner da última notícia */
    .hero-banner__wrapper { max-width: 100%; margin: 0; }
    .home-hero { cursor: pointer; display: flex; text-decoration: none; color: inherit; }
    .home-hero .hero__bg img { object-position: center; transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1); }
    .home-hero .hero__overlay {
      background: linear-gradient(to top, rgba(0,30,15,0.92) 0%, rgba(0,50,30,0.6) 60%, rgba(0,0,0,0.2) 100%);
    }
    .home-hero .hero__content { padding-bottom: var(--space-16); }
    .home-hero .article-meta { margin-bottom: var(--space-4); }
    .home-hero .card__tag {
      background: rgba(255,255,255,0.15);
      color: #fff;
      border: 1px solid rgba(255,255,255,0.3);
    }
    .home-hero__date {
      color: rgba(255,255,255,0.88);
      font-size: var(--font-size-sm);
      margin-left: var(--space-3);
    }
    .home-hero .hero__title {
      max-width: 850px;
      font-size: clamp(2rem, 1.2rem + 3.4vw, 3.5rem);
      line-height: 1.12;
      text-wrap: balance;
    }
    .home-hero .hero__subtitle {
      max-width: 650px;
      margin-bottom: var(--space-6);
      opacity: 1;
      font-weight: 400;
      text-wrap: pretty;
    }
    .home-hero .card__link {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      color: #fff;
      font-weight: 700;
      transition: gap 0.2s ease;
    }
    .card__arrow { font-size: 16px; }
    .btn__arrow { font-size: 18px; }
    @media (hover: hover) {
      .home-hero:hover .hero__bg img { transform: scale(1.04); }
      .home-hero:hover .card__link { gap: 0.7rem; }
    }
    @media (max-width: 768px) {
      .home-hero .hero__content { padding: var(--space-8) var(--space-6) var(--space-10); }
    }
    @media (max-width: 480px) {
      .home-hero .hero__content { padding-inline: var(--space-4); }
    }

    /* Próximo jogo sempre em primeiro (esquerda no desktop, topo no mobile) */
    .game-card--upcoming { order: -1; }

    /* Conquistas: texto secundário legível sobre o verde */
    .honor__year { color: rgba(255,255,255,0.88); }
    .honor__badge { font-size: var(--font-size-xs); }

    /* Notícias: títulos longos não quebram o card */
    .card--news .card__title { text-wrap: balance; }
    .section-header__title { text-wrap: balance; }

    .section-cta { margin-top: 3.5rem; }
    [hidden] { display: none !important; }
    .footer-column__title { opacity: 0.8; }

    /* Patrocinadores */
    .sponsors-title { justify-content: center; margin-bottom: var(--space-8); }

    /* Movimento reduzido */
    @media (prefers-reduced-motion: reduce) {
      html { scroll-behavior: auto; }
      *, *::before, *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
      }
      [data-animate] { opacity: 1 !important; }
      .home-hero:hover .hero__bg img,
      .card:hover,
      .game-card:hover,
      a.honor:hover { transform: none; }
    }
  </style>
@endpush

@section('content')
  <!-- HERO BANNER - ÚLTIMA NOTÍCIA -->
  <main id="conteudo">
  @if ($destaque)
  <div class="hero-banner__wrapper">
    <a href="{{ $destaque->url() }}" class="hero hero--compact home-hero">
      <div class="hero__bg">
        @if ($destaque->imagem)
        <img src="{{ asset($destaque->imagem) }}"
          alt="{{ $destaque->imagem_alt ?? $destaque->titulo }}"
          fetchpriority="high" decoding="async">
        @endif
      </div>
      <div class="hero__overlay"></div>
      <div class="hero__content">
        <div class="article-meta">
          @if ($destaque->categoria)<span class="card__tag">{{ $destaque->categoria }}</span>@endif
          @if ($destaque->publicado_em)<span class="home-hero__date">{{ $destaque->publicado_em->locale('pt_BR')->translatedFormat('j \d\e F \d\e Y') }}</span>@endif
        </div>
        <h1 class="hero__title">{{ $destaque->titulo }}</h1>
        @if ($destaque->resumo)<p class="hero__subtitle">{{ $destaque->resumo }}</p>@endif
        <span class="card__link">
          Ler matéria completa
          <span aria-hidden="true" class="material-icons-outlined card__arrow">arrow_forward</span>
        </span>
      </div>
    </a>
  </div>
  @endif

  <!-- JOGOS -->
  <section class="section">
    <div class="container">
      <div class="section-header section-header--center" data-animate>
        <h2 class="section-header__title">Calendário de Jogos</h2>
      </div>

      <div class="games-grid" data-animate>
        <!-- Último Jogo -->
        <article class="game-card game-card--result">
          <div class="game-card__top">
            <span class="game-card__eyebrow">
              <span aria-hidden="true" class="material-icons-outlined">emoji_events</span>
              Último Jogo
            </span>
            <span class="game-card__chip">
              <span aria-hidden="true" class="material-icons-outlined">flight_takeoff</span>
              Fora de casa
            </span>
          </div>

          <div class="game-card__comp">Copa Santa Catarina · Semifinal (ida)</div>
          <div class="game-card__date">
            <span aria-hidden="true" class="material-icons-outlined">event</span>
            07 Nov 2026 · 17h00
          </div>

          <div class="game-card__match">
            <div class="game-card__team">
              <div class="game-card__team-logo"><img src="{{ asset('images/escudos/criciuma-futsal.png') }}" alt="Escudo do Criciúma Futsal" width="240" height="240" loading="lazy" decoding="async"></div>
              <span class="game-card__team-name">Criciúma</span>
            </div>
            <div class="game-card__score">
              <span class="game-card__goals">2</span>
              <span class="game-card__score-sep">×</span>
              <span class="game-card__goals">2</span>
            </div>
            <div class="game-card__team">
              <div class="game-card__team-logo game-card__team-logo--chape"><img
                  src="{{ asset('images/escudos/chapecoense.webp') }}" alt="Escudo da Chapecoense Futsal" width="128" height="128" loading="lazy" decoding="async"></div>
              <span class="game-card__team-name">Chapecoense</span>
            </div>
          </div>

          <div class="game-card__result-tag game-card__result-tag--draw">
            <span aria-hidden="true" class="material-icons-outlined">remove</span>
            Empate
          </div>

          <div class="game-card__footer">
            <span class="game-card__meta">
              <span aria-hidden="true" class="material-icons-outlined">place</span>
              Ginásio Irmão Walmir Antônio Orsi · Criciúma, SC
            </span>
            <a class="game-card__cta game-card__cta--ghost" href="{{ url('/noticia103.html') }}">
              Ver relato da partida
              <span aria-hidden="true" class="material-icons-outlined">arrow_forward</span>
            </a>
          </div>
        </article>

        <!-- Próximo Jogo (Fora) -->
        <article class="game-card game-card--upcoming">
          <div class="game-card__top">
            <span class="game-card__eyebrow">
              <span aria-hidden="true" class="material-icons-outlined">sports_soccer</span>
              Próximo Jogo
            </span>
            <span class="game-card__chip game-card__chip--home">
              <span aria-hidden="true" class="material-icons-outlined">home</span>
              Em casa
            </span>
          </div>

          <div class="game-card__comp">Copa Santa Catarina · Semifinal (volta)</div>
          <div class="game-card__date">
            <span aria-hidden="true" class="material-icons-outlined">event</span>
            13 Nov 2026 · 20h00
          </div>

          <div class="game-card__match">
            <div class="game-card__team">
              <div class="game-card__team-logo game-card__team-logo--chape"><img
                  src="{{ asset('images/escudos/chapecoense.webp') }}" alt="Escudo da Chapecoense Futsal" width="128" height="128" loading="lazy" decoding="async"></div>
              <span class="game-card__team-name">Chapecoense</span>
            </div>
            <div class="game-card__score">
              <span class="game-card__vs-badge">VS</span>
            </div>
            <div class="game-card__team">
              <div class="game-card__team-logo"><img src="{{ asset('images/escudos/criciuma-futsal.png') }}" alt="Escudo do Criciúma Futsal" width="240" height="240" loading="lazy" decoding="async"></div>
              <span class="game-card__team-name">Criciúma</span>
            </div>
          </div>

          <div class="game-card__countdown" data-countdown="2026-11-13T20:00:00-03:00">
            <span aria-hidden="true" class="material-icons-outlined">hourglass_top</span>
            <span class="game-card__countdown-text">Faltam <strong>1 dia</strong></span>
          </div>

          <div class="game-card__footer">
            <span class="game-card__meta">
              <span aria-hidden="true" class="material-icons-outlined">place</span>
              Ginásio Plínio Arlindo De Nes (SER Aurora) · Chapecó, SC
            </span>
            <a class="game-card__cta game-card__cta--green" href="https://ingressojogo.com.br/jogos/34/ingressos" target="_blank" rel="noopener">
              <span aria-hidden="true" class="material-icons-outlined">confirmation_number</span>
              Comprar ingresso
            </a>
          </div>
        </article>
      </div>

      <div hidden data-animate>
        <a href="{{ route('competicoes') }}" class="btn btn--secondary">
          Ver todos os jogos
          <span aria-hidden="true" class="material-icons-outlined btn__arrow">arrow_forward</span>
        </a>
      </div>

    </div>
  </section>

  <!-- CONQUISTAS -->
  <section class="honors-strip">
    <div class="container">
      <div class="honors-strip__header" data-animate>
        <h2 class="honors-strip__title">Conquistas do Verdão das Quadras</h2>
      </div>
      <div class="honors-strip__list" data-animate>
        <a class="honor honor--new" href="{{ url('/noticia81.html') }}">
          <span class="honor__badge">Novo</span>
          <span class="material-icons-outlined honor__icon" aria-hidden="true">emoji_events</span>
          <span class="honor__year">2026</span>
          <span class="honor__title">Copa Sul (CBFS)</span>
          <span class="honor__place">Vice-campeã</span>
        </a>
        <div class="honor">
          <span class="material-icons-outlined honor__icon" aria-hidden="true">military_tech</span>
          <span class="honor__year">2025</span>
          <span class="honor__title">Campeonato Brasileiro</span>
          <span class="honor__place">3º lugar</span>
        </div>
        <div class="honor">
          <span class="material-icons-outlined honor__icon" aria-hidden="true">emoji_events</span>
          <span class="honor__year">2022</span>
          <span class="honor__title">Recopa da Liga Catarinense</span>
          <span class="honor__place">Campeã</span>
        </div>
        <div class="honor">
          <span class="material-icons-outlined honor__icon" aria-hidden="true">emoji_events</span>
          <span class="honor__year">2021</span>
          <span class="honor__title">Copa da Liga Catarinense</span>
          <span class="honor__place">Campeã</span>
        </div>
        <div class="honor">
          <span class="material-icons-outlined honor__icon" aria-hidden="true">emoji_events</span>
          <span class="honor__year">2012</span>
          <span class="honor__title">Copa SC (FCF)</span>
          <span class="honor__place">Campeã</span>
        </div>
      </div>
    </div>
  </section>

  <!-- ÚLTIMAS NOTÍCIAS -->
  <section class="section section--alt">
    <div class="container">
      <div class="section-header" data-animate>
        <h2 class="section-header__title">Últimas Notícias</h2>
      </div>

      <div class="grid grid-3 gap-8">
        @foreach ($ultimas->take(5) as $noticia)
        <a href="{{ $noticia->url() }}" class="card card--news" data-animate data-delay="{{ ($loop->index % 3 + 1) * 100 }}">
          @if ($noticia->imagem)
          <img class="card__image" src="{{ asset($noticia->imagem) }}"
            alt="{{ $noticia->imagem_alt ?? $noticia->titulo }}" loading="lazy" decoding="async">
          @endif
          <div class="card__body">
            @if ($noticia->categoria)<span class="card__tag">{{ $noticia->categoria }}</span>@endif
            @if ($noticia->publicado_em)<div class="card__date">{{ $noticia->publicado_em->locale('pt_BR')->translatedFormat('j \d\e F \d\e Y') }}</div>@endif
            <h3 class="card__title">{{ $noticia->titulo }}</h3>
            @if ($noticia->resumo)<p class="card__text">{{ $noticia->resumo }}</p>@endif
            <span class="card__link">
              Ler matéria completa
              <span aria-hidden="true" class="material-icons-outlined card__arrow">arrow_forward</span>
            </span>
          </div>
        </a>
        @endforeach
      </div>

      <div class="text-center section-cta" data-animate>
        <a href="{{ route('noticias.index') }}" class="btn btn--secondary">Ver todas as notícias</a>
      </div>
    </div>
  </section>

  <!-- NEWSLETTER -->
  <section class="section" hidden>
    <div class="container">
      <div class="newsletter" data-animate>
        <div class="newsletter__content">
          <h2 class="newsletter__title">Receba novidades da Chape</h2>
          <p class="newsletter__text">Inscreva-se na nossa newsletter oficial. Fique por dentro de contratações,
            resultados e promoções exclusivas para torcedores.</p>
          <form class="newsletter__form">
            <input type="email" class="newsletter__input" placeholder="Seu melhor e-mail" required>
            <button type="submit" class="btn btn--white">Inscrever-se</button>
          </form>
          <p class="newsletter__privacy">Nós nos preocupamos com a proteção dos seus dados. Leia nossa <a
              href="#">Política de Privacidade</a>.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- PATROCINADORES -->
  <section class="section section--alt">
    <div class="container text-center">
      <div class="section-header section-header--center" data-animate>
        <h2 class="section-header__label sponsors-title">Patrocinadores Oficiais</h2>
      </div>
      <div class="sponsors" data-animate>
        <div class="sponsor-card">
          <img src="{{ asset('images/patrocinadores/patrocinador01.avif') }}" alt="Patrocinador oficial" width="157" height="62" loading="lazy" decoding="async">
        </div>
        <div class="sponsor-card">
          <img src="{{ asset('images/patrocinadores/patrocinador02.avif') }}" alt="Patrocinador oficial" width="157" height="62" loading="lazy" decoding="async">
        </div>
        <div class="sponsor-card">
          <img src="{{ asset('images/patrocinadores/patrocinador03.avif') }}" alt="UNO Chapecó" width="109" height="62" loading="lazy" decoding="async">
        </div>
        <div class="sponsor-card">
          <img src="{{ asset('images/patrocinadores/patrocinador04.avif') }}" alt="Sicoob" width="132" height="38" loading="lazy" decoding="async">
        </div>
        <div class="sponsor-card">
          <img src="{{ asset('images/patrocinadores/patrocinador05.avif') }}" alt="Apti" width="109" height="47" loading="lazy" decoding="async">
        </div>
      </div>
    </div>
  </section>

  </main>
@endsection
