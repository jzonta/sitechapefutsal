@extends('layouts.app')

@section('title', 'Transparência e FAQ | Chapecoense Futsal')
@section('description', 'Acesso público aos documentos, relatórios financeiros e informações institucionais da Associação Chapecoense de Futsal.')

@push('head')
    <style>
        .doc-card--list { align-self: start; }
        .doc-card--list:hover { transform: none; box-shadow: none; border-color: var(--color-border); }
        .doc-card__head { display: flex; align-items: center; gap: var(--space-4); }
        .doc-card__head .doc-card__icon { width: 48px; height: 48px; font-size: 24px; }
        .doc-list { list-style: none; margin: 0; padding: 0; border-top: 1px solid var(--color-border-light); }
        .doc-list__group { padding: var(--space-4) 0 var(--space-1); font-size: var(--font-size-xs); font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: var(--color-text-muted); border-top: 1px solid var(--color-border-light); }
        .doc-list__group:first-child { border-top: 0; padding-top: var(--space-3); }
        .doc-list li { border-bottom: 1px solid var(--color-border-light); }
        .doc-list li:last-child { border-bottom: 0; }
        .doc-link { display: flex; align-items: center; gap: var(--space-3); min-height: 44px; padding: var(--space-3) var(--space-2); margin: 0 calc(var(--space-2) * -1); border-radius: var(--radius-md); font-size: var(--font-size-sm); font-weight: 500; color: var(--color-text); text-decoration: none; transition: background-color var(--transition-fast, 150ms) ease, color var(--transition-fast, 150ms) ease; }
        .doc-link .material-icons-outlined { font-size: 20px; color: var(--color-green); flex-shrink: 0; }
        .doc-link__name { flex: 1; min-width: 0; overflow-wrap: anywhere; }
        .doc-link__tag { flex-shrink: 0; font-size: var(--font-size-xs); font-weight: 600; letter-spacing: 0.05em; color: var(--color-green); background: var(--color-green-bg); border-radius: 9999px; padding: 2px var(--space-2); }
        .doc-link:hover { background: var(--color-green-bg); color: var(--color-green); }
        .doc-link:focus-visible, .faq-q:focus-visible { outline: 2px solid var(--color-green); outline-offset: 2px; }
        .sr-only { position: absolute; width: 1px; height: 1px; margin: -1px; padding: 0; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0; }
        .docs-grid { max-width: 900px; margin: 0 auto; align-items: start; }
        /* FAQ nativo (details/summary): teclado e leitores de tela sem JS */
        .faq-d { border: 1px solid var(--color-border); border-radius: var(--radius-md); background: var(--color-surface); margin-bottom: var(--space-3); overflow: hidden; }
        .faq-d:hover, .faq-d[open] { border-color: var(--color-green); }
        .faq-q { list-style: none; display: flex; align-items: center; justify-content: space-between; gap: var(--space-4); min-height: 44px; padding: var(--space-5) var(--space-6); cursor: pointer; font-weight: 600; color: var(--color-text); }
        .faq-q::-webkit-details-marker { display: none; }
        .faq-q:hover { background: var(--color-bg-alt); }
        .faq-q .icon { color: var(--color-green); font-size: 20px; flex-shrink: 0; transition: transform 250ms cubic-bezier(0.16, 1, 0.3, 1); }
        .faq-d[open] .faq-q .icon { transform: rotate(180deg); }
        .faq-a { padding: 0 var(--space-6) var(--space-6); font-size: var(--font-size-sm); color: var(--color-text-muted); line-height: 1.7; max-width: 65ch; }
        .faq-a a { color: var(--color-green); text-decoration: underline; text-underline-offset: 2px; }
        @media (prefers-reduced-motion: reduce) { .faq-q .icon, .doc-link { transition: none; } }
        @media (max-width: 480px) {
            .faq-q { padding: var(--space-4); }
            .faq-a { padding: 0 var(--space-4) var(--space-4); }
        }
    </style>
@endpush

@section('content')

    <!-- HERO -->
    <section class="hero hero--compact">
        <div class="hero__bg">
            <img src="{{ asset('images/fotos/IMG_8041.webp') }}" alt=""
                style="width:100%;height:100%;object-fit:cover;object-position:center 65%;">
        </div>
        <!-- overlay verde com granulado -->
        <div style="position:absolute;inset:0;z-index:1;">
            <div
                style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(0,77,45,0.65) 0%,rgba(0,107,63,0.45) 100%);">
            </div>
            <svg style="position:absolute;inset:0;width:100%;height:100%;mix-blend-mode:overlay;opacity:0.55;"
                xmlns="http://www.w3.org/2000/svg">
                <filter id="grain">
                    <feTurbulence type="fractalNoise" baseFrequency="0.75" numOctaves="4" stitchTiles="stitch" />
                    <feColorMatrix type="saturate" values="0" />
                    <feBlend in="SourceGraphic" mode="multiply" />
                </filter>
                <rect width="100%" height="100%" filter="url(#grain)" opacity="1" />
            </svg>
        </div>
        <div class="hero__overlay" style="background:rgba(0,0,0,0.1);"></div>
        <div class="hero__content" style="text-align:center;max-width:100%;position:relative;z-index:2;">
            <h1 class="hero__title" style="max-width:100%;margin:0 auto var(--space-4);">Transparência e Prestação de
                Contas</h1>
            <p class="hero__subtitle" style="max-width:700px;margin:0 auto;">Acesso público aos documentos, relatórios
                financeiros e informações institucionais da Associação Chapecoense de Futsal.</p>
        </div>
    </section>

    <!-- DOCUMENTOS -->
    <main id="conteudo">
    <section class="section" id="documentos">
        <div class="container">
            <div class="section-header section-header--center" data-animate>
                <h2 class="section-header__title">Acesso à Informação</h2>
            </div>

            <div class="grid grid-2 gap-8 docs-grid">
                <div class="doc-card doc-card--list" data-animate data-delay="100">
                    <div class="doc-card__head">
                        <div class="doc-card__icon" aria-hidden="true"><span class="material-icons-outlined" aria-hidden="true">handshake</span></div>
                        <h3 class="doc-card__title">Convênios</h3>
                    </div>
                    <p class="doc-card__text">Acesse os termos de fomento, parcerias e convênios firmados.</p>
                    <ul class="doc-list">
                            <li><a class="doc-link" href="uploads/transparencia/portaria-dou-chapecoense-futsal-ano1.pdf" target="_blank" rel="noopener">
                                <span class="material-icons-outlined" aria-hidden="true">description</span>
                                <span class="doc-link__name">Portaria DOU - Chapecoense Futsal Ano 1<span class="sr-only"> (PDF, abre em nova aba)</span></span>
                                <span class="doc-link__tag" aria-hidden="true">PDF</span></a></li>
                            <li><a class="doc-link" href="uploads/transparencia/termo-fomento-2025-prefeitura.pdf" target="_blank" rel="noopener">
                                <span class="material-icons-outlined" aria-hidden="true">description</span>
                                <span class="doc-link__name">Termo de Fomento 2025 - Prefeitura<span class="sr-only"> (PDF, abre em nova aba)</span></span>
                                <span class="doc-link__tag" aria-hidden="true">PDF</span></a></li>
                            <li><a class="doc-link" href="uploads/transparencia/portaria-dou-futsal-por-toda-chapeco.pdf" target="_blank" rel="noopener">
                                <span class="material-icons-outlined" aria-hidden="true">description</span>
                                <span class="doc-link__name">Portaria DOU - Futsal por Toda Chapecó<span class="sr-only"> (PDF, abre em nova aba)</span></span>
                                <span class="doc-link__tag" aria-hidden="true">PDF</span></a></li>
                            <li><a class="doc-link" href="uploads/transparencia/termo-fomento-2024-prefeitura.pdf" target="_blank" rel="noopener">
                                <span class="material-icons-outlined" aria-hidden="true">description</span>
                                <span class="doc-link__name">Termo de Fomento 2024 - Prefeitura<span class="sr-only"> (PDF, abre em nova aba)</span></span>
                                <span class="doc-link__tag" aria-hidden="true">PDF</span></a></li>
                    </ul>
                </div>

                <div class="doc-card doc-card--list" data-animate data-delay="200">
                    <div class="doc-card__head">
                        <div class="doc-card__icon" aria-hidden="true"><span class="material-icons-outlined" aria-hidden="true">groups</span></div>
                        <h3 class="doc-card__title">Diretoria</h3>
                    </div>
                    <p class="doc-card__text">Lista completa dos membros da diretoria e conselho fiscal atual.</p>
                    <ul class="doc-list">
                            <li><a class="doc-link" href="uploads/transparencia/membros-diretoria-2024-2028.pdf" target="_blank" rel="noopener">
                                <span class="material-icons-outlined" aria-hidden="true">description</span>
                                <span class="doc-link__name">Membros Diretoria 2024-2028<span class="sr-only"> (PDF, abre em nova aba)</span></span>
                                <span class="doc-link__tag" aria-hidden="true">PDF</span></a></li>
                            <li><a class="doc-link" href="uploads/transparencia/organograma-diretoria-2024-2028.pdf" target="_blank" rel="noopener">
                                <span class="material-icons-outlined" aria-hidden="true">description</span>
                                <span class="doc-link__name">Organograma Diretoria 2024-2028<span class="sr-only"> (PDF, abre em nova aba)</span></span>
                                <span class="doc-link__tag" aria-hidden="true">PDF</span></a></li>
                            <li><a class="doc-link" href="uploads/transparencia/ata-eleicao-posse-2024-2028.pdf" target="_blank" rel="noopener">
                                <span class="material-icons-outlined" aria-hidden="true">description</span>
                                <span class="doc-link__name">Ata Eleição e Posse 2024-2028<span class="sr-only"> (PDF, abre em nova aba)</span></span>
                                <span class="doc-link__tag" aria-hidden="true">PDF</span></a></li>
                    </ul>
                </div>

                <div class="doc-card doc-card--list" data-animate data-delay="300">
                    <div class="doc-card__head">
                        <div class="doc-card__icon" aria-hidden="true"><span class="material-icons-outlined" aria-hidden="true">gavel</span></div>
                        <h3 class="doc-card__title">Estatuto</h3>
                    </div>
                    <p class="doc-card__text">Regulamento interno e estatuto social da associação em vigor.</p>
                    <ul class="doc-list">
                            <li><a class="doc-link" href="uploads/transparencia/1a-alteracao-estatuto.pdf" target="_blank" rel="noopener">
                                <span class="material-icons-outlined" aria-hidden="true">description</span>
                                <span class="doc-link__name">1ª Alteração Estatuto<span class="sr-only"> (PDF, abre em nova aba)</span></span>
                                <span class="doc-link__tag" aria-hidden="true">PDF</span></a></li>
                            <li><a class="doc-link" href="uploads/transparencia/2a-alteracao-estatuto.pdf" target="_blank" rel="noopener">
                                <span class="material-icons-outlined" aria-hidden="true">description</span>
                                <span class="doc-link__name">2ª Alteração Estatuto<span class="sr-only"> (PDF, abre em nova aba)</span></span>
                                <span class="doc-link__tag" aria-hidden="true">PDF</span></a></li>
                    </ul>
                </div>

                <div class="doc-card doc-card--list" data-animate data-delay="400">
                    <div class="doc-card__head">
                        <div class="doc-card__icon" aria-hidden="true"><span class="material-icons-outlined" aria-hidden="true">account_balance</span></div>
                        <h3 class="doc-card__title">Financeiro</h3>
                    </div>
                    <p class="doc-card__text">Balanços patrimoniais, demonstrações contábeis e relatórios anuais.</p>
                    <ul class="doc-list">
                            <li class="doc-list__group" role="presentation">Exercício 2024</li>
                            <li><a class="doc-link" href="uploads/transparencia/balanco-patrimonial-2024.pdf" target="_blank" rel="noopener">
                                <span class="material-icons-outlined" aria-hidden="true">description</span>
                                <span class="doc-link__name">Balanço Patrimonial 2024<span class="sr-only"> (PDF, abre em nova aba)</span></span>
                                <span class="doc-link__tag" aria-hidden="true">PDF</span></a></li>
                            <li><a class="doc-link" href="uploads/transparencia/dre-2024.pdf" target="_blank" rel="noopener">
                                <span class="material-icons-outlined" aria-hidden="true">description</span>
                                <span class="doc-link__name">DRE 2024<span class="sr-only"> (PDF, abre em nova aba)</span></span>
                                <span class="doc-link__tag" aria-hidden="true">PDF</span></a></li>
                            <li><a class="doc-link" href="uploads/transparencia/relatorio-gestao-execucao-2024.pdf" target="_blank" rel="noopener">
                                <span class="material-icons-outlined" aria-hidden="true">description</span>
                                <span class="doc-link__name">Relatório Gestão e Execução 2024<span class="sr-only"> (PDF, abre em nova aba)</span></span>
                                <span class="doc-link__tag" aria-hidden="true">PDF</span></a></li>
                            <li><a class="doc-link" href="uploads/transparencia/relatorio-atividades-2024.pdf" target="_blank" rel="noopener">
                                <span class="material-icons-outlined" aria-hidden="true">description</span>
                                <span class="doc-link__name">Relatório de Atividades 2024<span class="sr-only"> (PDF, abre em nova aba)</span></span>
                                <span class="doc-link__tag" aria-hidden="true">PDF</span></a></li>
                            <li><a class="doc-link" href="uploads/transparencia/parecer-conselho-fiscal-2024.pdf" target="_blank" rel="noopener">
                                <span class="material-icons-outlined" aria-hidden="true">description</span>
                                <span class="doc-link__name">Parecer Conselho Fiscal 2024<span class="sr-only"> (PDF, abre em nova aba)</span></span>
                                <span class="doc-link__tag" aria-hidden="true">PDF</span></a></li>
                            <li><a class="doc-link" href="uploads/transparencia/ata-prestacao-contas-2024.pdf" target="_blank" rel="noopener">
                                <span class="material-icons-outlined" aria-hidden="true">description</span>
                                <span class="doc-link__name">Ata Prestação de Contas 2024<span class="sr-only"> (PDF, abre em nova aba)</span></span>
                                <span class="doc-link__tag" aria-hidden="true">PDF</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="section section--alt" id="faq">
        <div class="container container--narrow">
            <div class="section-header section-header--center" data-animate>
                <h2 class="section-header__title">Perguntas Frequentes (FAQ)</h2>
            </div>

            <div data-animate>
                <details class="faq-d">
                    <summary class="faq-q">
                        <span>Quem é a Chapecoense Futsal?</span>
                        <span class="material-icons-outlined icon" aria-hidden="true">expand_more</span>
                    </summary>
                    <div class="faq-a">A Chapecoense Futsal é um clube da modalidade de futsal, que tem representatividade nas
                            principais competições do país, contemplando crianças, adolescentes e adultos por meio da
                            equipe principal, das categorias de base e dos núcleos de iniciação. Além de incentivar a
                            prática esportiva e despertar o interesse pela modalidade, o projeto visa promover a
                            inclusão social e mais qualidade de vida.</div>
                </details>

                <details class="faq-d">
                    <summary class="faq-q">
                        <span>Como faço para praticar futsal na Chapecoense Futsal?</span>
                        <span class="material-icons-outlined icon" aria-hidden="true">expand_more</span>
                    </summary>
                    <div class="faq-a">Para praticar futsal na Chapecoense Futsal o interessado deverá buscar orientações
                            diretamente nos locais de treinamento com a comissão técnica ou ligar para <a href="tel:+5549988348459">(49) 9 8834-8459</a>.</div>
                </details>

                <details class="faq-d">
                    <summary class="faq-q">
                        <span>Quais os locais e horários de treinamento?</span>
                        <span class="material-icons-outlined icon" aria-hidden="true">expand_more</span>
                    </summary>
                    <div class="faq-a">Ginásio do SESC — Rua Brasília, nº 475-D, bairro Jardim Itália, Chapecó/SC, CEP:
                            89.802-320.<br>
                            Segunda a Sexta: 09h00 às 11h00 e das 16h00 às 18h00.</div>
                </details>

                <details class="faq-d">
                    <summary class="faq-q">
                        <span>Qual a faixa etária e categorias?</span>
                        <span class="material-icons-outlined icon" aria-hidden="true">expand_more</span>
                    </summary>
                    <div class="faq-a">A Chapecoense Futsal atende em suas categorias de base, beneficiários na faixa etária dos 14
                            aos 17 anos e também trabalha com uma equipe de rendimento com os adultos, que disputam o
                            campeonato estadual e o Campeonato Brasileiro de Clubes.</div>
                </details>

                <details class="faq-d">
                    <summary class="faq-q">
                        <span>Existe alguma exigência ou obrigação para participar das atividades?</span>
                        <span class="material-icons-outlined icon" aria-hidden="true">expand_more</span>
                    </summary>
                    <div class="faq-a">A única exigência para participar das atividades das escolinhas é estar matriculado e
                            cursando regularmente a escola.</div>
                </details>
            </div>
        </div>
    </section>

    <!-- CTA CONTATO -->
    <section class="section">
        <div class="container">
            <div style="background:var(--color-surface);border-radius:var(--radius-xl);padding:var(--space-12);text-align:center;border:1px solid var(--color-border);max-width:700px;margin:0 auto;"
                data-animate>
                <h3 style="font-size:var(--font-size-2xl);margin-bottom:var(--space-3);">Ainda tem dúvidas?</h3>
                <p style="color:var(--color-text-muted);margin-bottom:var(--space-6);line-height:1.6;">
                    Nossa equipe está pronta para atender você. Entre em contato através de nossos canais oficiais.
                </p>
                <a href="{{ route('contato') }}" class="btn btn--primary btn--lg">
                    <span class="material-icons-outlined" style="font-size:20px;" aria-hidden="true">email</span>
                    Fale Conosco
                </a>
            </div>
        </div>
    </section>

    </main>
@endsection
