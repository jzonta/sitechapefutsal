@extends('layouts.app')

@section('title', 'Nossa História | Chapecoense Futsal')
@section('description', 'Conheça a trajetória da Associação Chapecoense de Futsal: fundação em 2011, títulos estaduais, JASC, terceiro lugar no Brasileiro 2025, Supercopa do Brasil e vice da Copa Sul em 2026.')

@push('head')
    <style>
        /* ===== historia.html: ajustes locais (tokens do sistema) ===== */
        .skip-link {
            position: absolute;
            left: var(--space-4);
            top: -100px;
            z-index: 1100;
            padding: var(--space-3) var(--space-5);
            background: var(--color-green);
            color: #fff;
            border-radius: var(--radius-md);
            font-weight: 600;
        }

        .skip-link:focus {
            top: var(--space-4);
        }

        :focus-visible {
            outline: 3px solid var(--color-green);
            outline-offset: 3px;
            border-radius: var(--radius-sm);
        }

        button.mobile-toggle {
            background: none;
            border: 0;
            padding: 0;
            font: inherit;
            cursor: pointer;
        }

        ::selection {
            background: var(--color-green);
            color: #fff;
        }

        /* Hero */
        .hist-hero__img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center 65%;
        }

        .hist-hero__tint {
            position: absolute;
            inset: 0;
            z-index: 1;
            background: linear-gradient(180deg, rgba(0, 77, 45, 0.72) 0%, rgba(0, 107, 63, 0.55) 100%);
        }

        .hist-hero__grain {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            mix-blend-mode: overlay;
            opacity: 0.55;
            pointer-events: none;
        }

        .hist-hero .hero__content {
            text-align: center;
            max-width: 100%;
        }

        .hist-hero .hero__title {
            max-width: 100%;
            margin: 0 auto var(--space-4);
            text-wrap: balance;
        }

        .hist-hero .hero__subtitle {
            max-width: 40rem;
            margin: 0 auto;
            font-weight: 400;
            opacity: 1;
            text-wrap: pretty;
            text-shadow: 0 1px 12px rgba(0, 0, 0, 0.35);
        }

        /* Origens: texto + painel lateral */
        .hist-origins {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(300px, 380px);
            gap: var(--space-16);
            align-items: start;
        }

        .hist-prose {
            max-width: 68ch;
        }

        .hist-prose p {
            color: var(--color-text-secondary);
            line-height: 1.75;
            margin-bottom: var(--space-5);
            text-wrap: pretty;
        }

        .hist-prose p:last-child {
            margin-bottom: 0;
        }

        .hist-prose .hist-lead {
            font-size: var(--font-size-lg);
            color: var(--color-text);
        }

        .hist-prose .section-header {
            margin-bottom: var(--space-6);
        }

        .hist-prose .section-header__title,
        .hist-timeline-head .section-header__title {
            text-wrap: balance;
        }

        .hist-aside {
            position: sticky;
            top: calc(var(--header-height) + var(--space-6));
            display: grid;
            gap: var(--space-6);
        }

        .hist-aside .origins-logo-box {
            height: auto;
            aspect-ratio: 1 / 1;
            max-height: 340px;
            margin: 0 auto;
            width: 100%;
        }

        .hist-trophies {
            background: var(--color-primary-bg);
            border: 1px solid var(--color-border-light);
            border-top: 4px solid var(--color-primary-lighter);
            border-radius: var(--radius-lg);
            padding: var(--space-6);
        }

        .hist-trophies__title {
            font-size: var(--font-size-lg);
            font-weight: 700;
            color: var(--color-primary);
            margin-bottom: var(--space-4);
        }

        .hist-trophies ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .hist-trophies li {
            padding: var(--space-3) 0;
            border-top: 1px solid var(--color-border);
            font-size: var(--font-size-sm);
            line-height: 1.5;
            color: var(--color-text-secondary);
        }

        .hist-trophies li:first-child {
            border-top: 0;
            padding-top: 0;
        }

        .hist-trophies li:last-child {
            padding-bottom: 0;
        }

        .hist-trophies strong {
            display: block;
            color: var(--color-text);
            font-weight: 600;
        }

        /* Foto */
        .hist-figure {
            margin: 0;
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-card);
            background: var(--color-green-dark);
        }

        .hist-figure img {
            display: block;
            width: 100%;
            height: auto;
            aspect-ratio: 21 / 9;
            object-fit: cover;
            object-position: center 62%;
        }

        /* Linha do tempo */
        .hist-timeline-head {
            margin-bottom: var(--space-12);
        }

        .hist-timeline {
            max-width: 48rem;
            margin: 0 auto;
        }

        .hist-timeline .timeline-item {
            margin-bottom: var(--space-10);
        }

        .hist-timeline .timeline-item:last-child {
            margin-bottom: 0;
        }

        .hist-timeline .timeline-item::before {
            border-color: var(--color-bg-alt);
        }

        .hist-timeline .timeline-item__title {
            font-size: var(--font-size-xl);
            line-height: 1.3;
            text-wrap: balance;
        }

        .tl-year {
            display: block;
            font-size: var(--font-size-sm);
            font-weight: 700;
            letter-spacing: 0.05em;
            color: var(--color-green);
            margin-bottom: var(--space-1);
            font-variant-numeric: tabular-nums;
        }

        .hist-timeline .timeline-item__text {
            font-size: var(--font-size-base);
            line-height: 1.7;
            color: var(--color-text-secondary);
            max-width: 65ch;
            text-wrap: pretty;
        }

        .section--tight-top {
            padding-top: 0;
        }

        @media (max-width: 1024px) {
            .hist-origins {
                grid-template-columns: 1fr;
                gap: var(--space-12);
            }

            .hist-aside {
                position: static;
                grid-template-columns: minmax(0, 1fr) minmax(0, 1.2fr);
                align-items: start;
            }

            .hist-aside .origins-logo-box {
                max-height: none;
            }
        }

        @media (max-width: 640px) {
            .hist-aside {
                grid-template-columns: 1fr;
            }

            .hist-aside .origins-logo-box {
                max-width: 240px;
            }

            .hist-figure img {
                aspect-ratio: 4 / 3;
            }

            .hist-prose .hist-lead {
                font-size: var(--font-size-base);
            }

            .hist-timeline-head {
                margin-bottom: var(--space-8);
            }

            .hist-timeline .timeline-item__title {
                font-size: var(--font-size-lg);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            [data-animate] {
                animation: none !important;
            }
        }
    </style>
@endpush

@section('content')

    <main id="conteudo">
    <!-- HERO -->
    <section class="hero hero--compact hist-hero">
        <div class="hero__bg">
            <img class="hist-hero__img" src="{{ asset('images/fotos/IMG_4728.webp') }}" alt="" width="1920" height="1280"
                fetchpriority="high" decoding="async">
        </div>
        <div class="hist-hero__tint" aria-hidden="true">
            <svg class="hist-hero__grain" xmlns="http://www.w3.org/2000/svg" focusable="false">
                <filter id="grain">
                    <feTurbulence type="fractalNoise" baseFrequency="0.75" numOctaves="4" stitchTiles="stitch" />
                    <feColorMatrix type="saturate" values="0" />
                    <feBlend in="SourceGraphic" mode="multiply" />
                </filter>
                <rect width="100%" height="100%" filter="url(#grain)" />
            </svg>
        </div>
        <div class="hero__overlay" style="background:rgba(0,0,0,0.1);" aria-hidden="true"></div>
        <div class="hero__content">
            <h1 class="hero__title">Nossa História</h1>
            <p class="hero__subtitle">Mais do que um time, uma paixão que une gerações. Conheça a trajetória da
                Associação Chapecoense de Futsal.</p>
        </div>
    </section>

    <!-- ORIGENS -->
    <section class="section" aria-labelledby="titulo-origens">
        <div class="container">
            <div class="hist-origins" data-animate>
                <div class="hist-prose">
                    <div class="section-header">
                        <div class="section-header__label">Nossas Raízes</div>
                        <h2 class="section-header__title" id="titulo-origens">As Origens e a Fundação</h2>
                    </div>
                    <p class="hist-lead">
                        A Associação Chapecoense de Futsal foi fundada oficialmente em 18 de abril de 2011, com a
                        criação do CNPJ, mas o
                        trabalho existe desde 2009. Porém, nas duas primeiras temporadas, a equipe estava vinculada à
                        Associação Chapecoense de Futebol. O projeto surgiu para recolocar Chapecó no cenário do futsal
                        masculino adulto, após um ano sem
                        disputar competições oficiais.
                    </p>
                    <p>
                        Durante toda esta trajetória, o Verdão das Quadras conquistou
                        resultados importantes para a cidade. Destaque para os títulos da Copa SC 2012, da Federação
                        Catarinense de Futsal, a Copa 2021 e a
                        Recopa 2022, ambas da Liga Catarinense. Nos Jogos Abertos de Santa Catarina (JASC), foram cinco
                        medalhas representando o município: prata em 2009 e 2013 e bronze em 2011, 2022 e 2024.
                    </p>
                    <p>
                        No quadro universitário, a Chape Futsal se sagrou campeã brasileira da LDU e do Zonal
                        Sul/Sudeste/Centro-Oeste da LDU, além do tricampeonato dos JUC's. A agremiação também levantou
                        troféus nas categorias de base e em torneios regionais.
                    </p>
                    <p>
                        Em 2025, o clube disputou pela primeira vez o Campeonato Brasileiro de Futsal e conquistou um
                        histórico terceiro lugar. Nesse ano, a Chapecoense também ficou na terceira posição na Série
                        Ouro do Catarinense, o seu melhor desempenho na competição em todos os tempos.
                    </p>
                    <p>
                        A temporada de 2026 marcou um novo capítulo na Chapecoense Futsal: a inédita participação na
                        Supercopa do Brasil, a disputa mais importante da história do clube, graças à grande campanha no
                        Campeonato Brasileiro. O torneio reuniu os melhores times do País e premiou o campeão com uma
                        vaga à Taça Libertadores da América.
                    </p>
                </div>

                <aside class="hist-aside" aria-label="Conquistas em resumo">
                    <div class="origins-logo-box">
                        <img src="{{ asset('images/logomarca.webp') }}" alt="Escudo da Chapecoense Futsal" width="220" height="220"
                            loading="lazy" decoding="async">
                    </div>
                    <div class="hist-trophies">
                        <h3 class="hist-trophies__title">Conquistas em resumo</h3>
                        <ul>
                            <li><strong>Copa SC 2012</strong>Federação Catarinense de Futsal</li>
                            <li><strong>Copa 2021 e Recopa 2022</strong>Liga Catarinense</li>
                            <li><strong>Universitário (LDU)</strong>Campeã brasileira e do Zonal
                                Sul/Sudeste/Centro-Oeste; tricampeã dos JUC's</li>
                            <li><strong>JASC: cinco medalhas</strong>Prata em 2009 e 2013; bronze em 2011, 2022 e 2024
                            </li>
                            <li><strong>Campeonato Brasileiro 2025</strong>Terceiro lugar na estreia</li>
                            <li><strong>Série Ouro do Catarinense 2025</strong>Terceiro lugar, a melhor campanha do
                                clube</li>
                            <li><strong>Copa Sul 2026</strong>Vice-campeã</li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <!-- FOTO -->
    <section class="section section--tight-top" aria-label="Foto da equipe">
        <div class="container">
            <figure class="hist-figure" data-animate>
                <img src="{{ asset('images/fotos/IMG_4373.webp') }}"
                    alt="Jogadores e comissão técnica da Chapecoense Futsal posam com a bandeira de Chapecó diante da torcida, na quadra"
                    width="1920" height="1280" loading="lazy" decoding="async">
            </figure>
        </div>
    </section>

    <!-- MOMENTOS MARCANTES -->
    <section class="section section--alt" aria-labelledby="titulo-momentos">
        <div class="container">
            <div class="section-header section-header--center hist-timeline-head" data-animate>
                <div class="section-header__label" style="justify-content:center;">Trajetória</div>
                <h2 class="section-header__title" id="titulo-momentos">Momentos Marcantes</h2>
            </div>

            <div class="hist-timeline">
                <div class="timeline">
                    <div class="timeline-item" data-animate>
                        <h3 class="timeline-item__title"><span class="tl-year">2009</span>O Início</h3>
                        <p class="timeline-item__text">Início do trabalho com o futsal em Chapecó, vinculado à
                            Associação Chapecoense de Futebol. Conquista da medalha de prata nos Jogos Abertos de Santa
                            Catarina (JASC).</p>
                    </div>

                    <div class="timeline-item" data-animate>
                        <h3 class="timeline-item__title"><span class="tl-year">2011</span>Fundação Oficial</h3>
                        <p class="timeline-item__text">Criação da Associação Chapecoense de Futsal com registro de CNPJ
                            em abril de 2011. Medalha de bronze no JASC.</p>
                    </div>

                    <div class="timeline-item" data-animate>
                        <h3 class="timeline-item__title"><span class="tl-year">2012</span>Primeiro Grande Título</h3>
                        <p class="timeline-item__text">Conquista do título da Copa SC pela Federação Catarinense de
                            Futsal, consolidando a equipe no cenário estadual.</p>
                    </div>

                    <div class="timeline-item" data-animate>
                        <h3 class="timeline-item__title"><span class="tl-year">2021–2022</span>Domínio Catarinense
                        </h3>
                        <p class="timeline-item__text">Conquista da Copa 2021 e da Recopa 2022, ambas da Liga
                            Catarinense. Bronze no JASC 2022. No quadro universitário, a Chape Futsal se sagrou campeã
                            brasileira da LDU e do Zonal Sul/Sudeste/Centro-Oeste, além do tricampeonato dos JUC's.</p>
                    </div>

                    <div class="timeline-item" data-animate>
                        <h3 class="timeline-item__title"><span class="tl-year">2025</span>Campeonato Brasileiro</h3>
                        <p class="timeline-item__text">Marco histórico: pela primeira vez, o clube disputou o
                            Campeonato Brasileiro de Futsal e conquistou um histórico terceiro lugar. Também ficou na
                            terceira posição na Série Ouro do Catarinense, o seu melhor desempenho na competição em
                            todos os tempos.</p>
                    </div>

                    <div class="timeline-item" data-animate>
                        <h3 class="timeline-item__title"><span class="tl-year">2026</span>Supercopa do Brasil</h3>
                        <p class="timeline-item__text">Um novo capítulo: a inédita participação na Supercopa do Brasil,
                            a disputa mais importante da história do clube, graças à grande campanha no Campeonato
                            Brasileiro. O torneio reuniu os melhores times do País e premiou o campeão com uma vaga à
                            Taça Libertadores da América.</p>
                    </div>

                    <div class="timeline-item" data-animate>
                        <h3 class="timeline-item__title"><span class="tl-year">2026</span>Vice-campeã da Copa Sul</h3>
                        <p class="timeline-item__text">Pela primeira vez, o clube chegou a uma final de competição
                            promovida pela Confederação Brasileira de Futsal (CBFS). Na decisão da Copa Sul, disputada
                            na Arena Ivo Sguissardi, em Xanxerê, o Verdão das Quadras foi superado pelo Campo Mourão
                            (PR) e ficou com o vice-campeonato.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- VALORES - OCULTO -->
    <section class="section" style="display:none;">
        <div class="container">
            <div class="section-header section-header--center" data-animate>
                <div class="section-header__label" style="justify-content:center;">Nossos Pilares</div>
                <h2 class="section-header__title">O que nos move</h2>
            </div>

            <div class="grid grid-3 gap-8">
                <div class="value-card" data-animate data-delay="100">
                    <div class="value-card__icon">
                        <span class="material-icons-outlined" aria-hidden="true">favorite</span>
                    </div>
                    <h3 class="value-card__title">Paixão</h3>
                    <p class="value-card__text">A energia que move nossa torcida e nossos atletas em cada lance, em cada
                        gol e em cada vitória.</p>
                </div>

                <div class="value-card" data-animate data-delay="200">
                    <div class="value-card__icon"
                        style="background:var(--color-primary-bg);color:var(--color-primary);">
                        <span class="material-icons-outlined" aria-hidden="true">groups</span>
                    </div>
                    <h3 class="value-card__title">Comunidade</h3>
                    <p class="value-card__text">Mais que um clube, somos a representação de Chapecó. Trabalhamos para
                        orgulhar nossa gente.</p>
                </div>

                <div class="value-card" data-animate data-delay="300">
                    <div class="value-card__icon">
                        <span class="material-icons-outlined" aria-hidden="true">star</span>
                    </div>
                    <h3 class="value-card__title">Excelência</h3>
                    <p class="value-card__text">A busca incessante pela vitória com ética, respeito ao adversário e
                        dedicação total.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- GALERIA - OCULTO -->
    <section class="section section--alt" style="display:none;">
        <div class="container">
            <div class="section-header section-header--center" data-animate>
                <div class="section-header__label" style="justify-content:center;">Memórias</div>
                <h2 class="section-header__title">Galeria Histórica</h2>
            </div>

            <div class="gallery-grid" data-animate>
                <div class="gallery-item">
                    <div
                        style="width:100%;height:100%;background:linear-gradient(135deg,#006b3f,#008a51);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,0.4);">
                        <span class="material-icons-outlined" style="font-size:48px;" aria-hidden="true">photo_camera</span>
                    </div>
                    <div class="gallery-item__caption">A Força da Torcida</div>
                </div>
                <div class="gallery-item">
                    <div
                        style="width:100%;height:100%;background:linear-gradient(135deg,#7d540d,#c4891d);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,0.4);">
                        <span class="material-icons-outlined" style="font-size:48px;" aria-hidden="true">emoji_events</span>
                    </div>
                    <div class="gallery-item__caption">Conquistas Memoráveis</div>
                </div>
                <div class="gallery-item">
                    <div
                        style="width:100%;height:100%;background:linear-gradient(135deg,#004d2d,#006b3f);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,0.4);">
                        <span class="material-icons-outlined" style="font-size:48px;" aria-hidden="true">sports_soccer</span>
                    </div>
                    <div class="gallery-item__caption">Tradição nas Quadras</div>
                </div>
            </div>
        </div>
    </section>

    </main>

@endsection
