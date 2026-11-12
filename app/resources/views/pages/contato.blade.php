@extends('layouts.app')

@section('title', 'Chapecoense Futsal - Contato e Localização')
@section('description', 'Entre em contato com a Associação Chapecoense de Futsal. Endereço, telefone, e-mail e formulário de contato.')

@push('head')
    <style>
        /* contato.html: estilos locais (tokens de css/index.css) */
        .visually-hidden { position: absolute; width: 1px; height: 1px; margin: -1px; padding: 0; overflow: hidden; clip: rect(0 0 0 0); white-space: nowrap; border: 0; }
        .skip-link { position: absolute; left: var(--space-4); top: -100px; z-index: 1000; padding: var(--space-3) var(--space-4); background: var(--color-green); color: #fff; border-radius: var(--radius-md); font-weight: 600; font-size: var(--font-size-sm); }
        .skip-link:focus { top: var(--space-4); }
        a:focus-visible, button:focus-visible, .form-input:focus-visible, .form-select:focus-visible, .form-textarea:focus-visible { outline: 3px solid var(--color-green); outline-offset: 2px; }

        .contact-wrap { max-width: 900px; margin: 0 auto; }
        .contact-list { display: grid; grid-template-columns: 1fr; gap: var(--space-4); }
        @media (min-width: 768px) { .contact-list { grid-template-columns: 1fr 1fr; gap: var(--space-5); } }
        .contact-info-card { min-width: 0; }
        .contact-info-card address { font-style: normal; }
        .contact-info-card__body { min-width: 0; font-size: var(--font-size-sm); color: var(--color-text-secondary); line-height: 1.5; overflow-wrap: anywhere; }
        .contact-info-card__title { font-size: var(--font-size-sm); font-weight: 700; margin: 0 0 var(--space-1); color: var(--color-text); }
        .contact-link { display: inline-flex; align-items: center; min-height: 44px; font-size: var(--font-size-base); font-weight: 600; color: var(--color-green); text-decoration: underline; text-underline-offset: 3px; text-decoration-thickness: 1px; overflow-wrap: anywhere; }
        .contact-link:hover { color: var(--color-green-dark); text-decoration-thickness: 2px; }
        .contact-note { display: block; margin-top: var(--space-1); font-size: var(--font-size-sm); color: var(--color-text-muted); }

        /* Formulario (oculto por enquanto): alvos de 48px, 16px no iOS, estados de erro */
        .form-input, .form-select, .form-textarea { font-family: inherit; font-size: 1rem; min-height: 48px; }
        .form-textarea { min-height: 140px; }
        .form-input::placeholder, .form-textarea::placeholder { color: var(--color-text-muted); }
        .form-input:user-invalid, .form-select:user-invalid, .form-textarea:user-invalid { border-color: var(--color-error); box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12); }
        .form-select { padding-right: var(--space-10); background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1.5l5 5 5-5' fill='none' stroke='%234a4a4a' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right var(--space-4) center; }

        .form-alert { display: flex; gap: var(--space-3); align-items: flex-start; padding: var(--space-4); border-radius: var(--radius-md); margin-bottom: var(--space-6); font-size: var(--font-size-sm); line-height: 1.5; }
        .form-alert ul { margin: var(--space-1) 0 0; padding-left: var(--space-5); list-style: disc; }
        .form-alert--success { background: var(--color-green-10); color: var(--color-green-dark); border: 1px solid var(--color-green); }
        .form-alert--error { background: rgba(220, 38, 38, 0.08); color: var(--color-error); border: 1px solid var(--color-error); }
        .form-input.is-invalid, .form-select.is-invalid, .form-textarea.is-invalid { border-color: var(--color-error); }
        .form-error { font-size: var(--font-size-sm); color: var(--color-error); }

        .social-actions { display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap; }
    </style>
@endpush

@section('content')

    <!-- HERO -->
    <main id="conteudo">
    <section class="hero hero--compact">
        <div class="hero__bg">
            <img src="{{ asset('images/fotos/contato-banner.webp') }}" alt="" fetchpriority="high"
                style="width:100%;height:100%;object-fit:cover;object-position:center 35%;">
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
        <div class="hero__content"
            style="text-align:center;max-width:100%;position:relative;z-index:2;padding-top:var(--space-20);padding-bottom:var(--space-12);">
            <h1 class="hero__title"
                style="max-width:100%;margin:0 auto var(--space-4);text-shadow: 0 4px 12px rgba(0,0,0,0.5);">Fale
                Conosco</h1>
            <p class="hero__subtitle" style="max-width:700px;margin:0 auto;font-weight:400;opacity:1;">Estamos prontos
                para atender você. Entre em
                contato para dúvidas sobre ingressos, sócio torcedor ou parcerias.</p>
        </div>
    </section>

    <!-- FORMULÁRIO + INFORMAÇÕES -->
    <section class="section">
        <div class="container">
            <div class="contact-wrap">

                <!-- Formulário -->
                <div data-animate id="formulario" style="margin-bottom:var(--space-12);">
                    <div class="section-header" style="margin-bottom:var(--space-8);">
                        <div class="section-header__label">Mensagem</div>
                        <h2 class="section-header__title">Envie sua mensagem</h2>
                    </div>

                    @if (session('sucesso'))
                        <div class="form-alert form-alert--success" role="status">
                            <span class="material-icons-outlined" aria-hidden="true">check_circle</span>
                            {{ session('sucesso') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="form-alert form-alert--error" role="alert">
                            <span class="material-icons-outlined" aria-hidden="true">error_outline</span>
                            <div>
                                Verifique os campos abaixo:
                                <ul>
                                    @foreach ($errors->all() as $erro)
                                        <li>{{ $erro }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form id="contact-form" method="POST" action="{{ route('contato.store') }}" style="display:flex;flex-direction:column;gap:var(--space-5);">
                        @csrf

                        <div class="form-group">
                            <label for="contact-name">Nome completo</label>
                            <input type="text" id="contact-name" name="nome" class="form-input @error('nome') is-invalid @enderror" placeholder="Seu nome" autocomplete="name" value="{{ old('nome') }}" maxlength="120" required>
                            @error('nome')<span class="form-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="contact-email">E-mail</label>
                            <input type="email" id="contact-email" name="email" class="form-input @error('email') is-invalid @enderror" placeholder="seu@email.com"
                                autocomplete="email" inputmode="email" autocapitalize="none" spellcheck="false" value="{{ old('email') }}" maxlength="160" required>
                            @error('email')<span class="form-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="contact-subject">Assunto</label>
                            <select id="contact-subject" name="assunto" class="form-select @error('assunto') is-invalid @enderror">
                                <option value="">Selecione um assunto</option>
                                @foreach (['Ingressos', 'Sócio Torcedor', 'Parceria / Patrocínio', 'Imprensa', 'Outro'] as $assunto)
                                    <option value="{{ $assunto }}" @selected(old('assunto') === $assunto)>{{ $assunto }}</option>
                                @endforeach
                            </select>
                            @error('assunto')<span class="form-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="contact-message">Mensagem</label>
                            <textarea id="contact-message" name="mensagem" class="form-textarea @error('mensagem') is-invalid @enderror" rows="5" maxlength="5000"
                                placeholder="Escreva sua mensagem aqui..." required>{{ old('mensagem') }}</textarea>
                            @error('mensagem')<span class="form-error">{{ $message }}</span>@enderror
                        </div>

                        <button type="submit" class="btn btn--primary btn--lg btn--mobile-full"
                            style="align-self:flex-start;">
                            <span class="material-icons-outlined" style="font-size:20px;" aria-hidden="true">send</span>
                            Enviar Mensagem
                        </button>
                    </form>
                </div>

                <!-- Informações -->
                <div data-animate data-delay="200">
                    <div class="section-header" style="margin-bottom:var(--space-8);">
                        <div class="section-header__label">Informações</div>
                        <h2 class="section-header__title">Informações de Contato</h2>
                    </div>

                    <div class="contact-list">
                        <!-- Telefone -->
                        <div class="contact-info-card">
                            <div class="contact-info-card__icon">
                                <span class="material-icons-outlined" aria-hidden="true">phone</span>
                            </div>
                            <div class="contact-info-card__body">
                                <h3 class="contact-info-card__title">Telefone</h3>
                                <a class="contact-link" href="tel:+5549988348459">(49) 9 8834-8459</a>
                            </div>
                        </div>

                        <!-- E-mail -->
                        <div class="contact-info-card">
                            <div class="contact-info-card__icon">
                                <span class="material-icons-outlined" aria-hidden="true">email</span>
                            </div>
                            <div class="contact-info-card__body">
                                <h3 class="contact-info-card__title">E-mail</h3>
                                <a class="contact-link" href="mailto:juridico@chapefutsal.com.br">juridico@chapefutsal.com.br</a>
                            </div>
                        </div>

                        <!-- Endereço -->
                        <div class="contact-info-card">
                            <div class="contact-info-card__icon">
                                <span class="material-icons-outlined" aria-hidden="true">place</span>
                            </div>
                            <div class="contact-info-card__body">
                                <h3 class="contact-info-card__title">Endereço</h3>
                                <address>
                                    Rua Guaporé, nº 1.454 D<br>
                                    Bairro Presidente Médici<br>
                                    Chapecó - SC, CEP: 89.805-070
                                </address>
                                <a class="contact-link" href="https://www.google.com/maps/search/?api=1&query=Gin%C3%A1sio+Pl%C3%ADnio+Arlindo+De+Nes+Chapec%C3%B3+SC"
                                    target="_blank" rel="noopener">
                                    Ver no mapa<span class="visually-hidden"> (abre em nova aba)</span> →
                                </a>
                            </div>
                        </div>

                        <!-- Horário -->
                        <div class="contact-info-card">
                            <div class="contact-info-card__icon">
                                <span class="material-icons-outlined" aria-hidden="true">schedule</span>
                            </div>
                            <div class="contact-info-card__body">
                                <h3 class="contact-info-card__title">Horário de Atendimento</h3>
                                Segunda a Sexta: 14h00 às 17h00
                                <em class="contact-note">Em dias de jogos, o horário pode sofrer alterações.</em>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MAPA -->
    <section class="section section--alt">
        <div class="container">
            <div class="section-header section-header--center" data-animate>
                <div class="section-header__label" style="justify-content:center;">Localização</div>
                <h2 class="section-header__title">Nossa Casa</h2>
            </div>

            <div class="map-wrapper" data-animate>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3547.0!2d-52.6367!3d-27.0975!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjfCsDA1JzUxLjAiUyA1MsKwMzgnMTIuMSJX!5e0!3m2!1spt-BR!2sbr!4v1"
                    width="100%" height="400" style="border:0;" allowfullscreen loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade" title="Mapa do Ginásio Plínio Arlindo De Nes, Chapecó (SC)">
                </iframe>
            </div>

            <div style="text-align:center;margin-top:var(--space-6);" data-animate>
                <a href="https://www.google.com/maps/search/?api=1&query=Gin%C3%A1sio+Pl%C3%ADnio+Arlindo+De+Nes+Chapec%C3%B3+SC" target="_blank"
                    rel="noopener" class="btn btn--secondary">
                    <span class="material-icons-outlined" style="font-size:18px;" aria-hidden="true">map</span>
                    Abrir no Google Maps<span class="visually-hidden"> (abre em nova aba)</span>
                </a>
            </div>
        </div>
    </section>

    <!-- REDES SOCIAIS -->
    <section class="section">
        <div class="container text-center">
            <div class="section-header section-header--center" data-animate>
                <div class="section-header__label" style="justify-content:center;">Conecte-se</div>
                <h2 class="section-header__title">Siga a Chape nas redes</h2>
            </div>

            <div class="social-actions" data-animate>
                <a href="https://www.instagram.com/achapefutsal/" target="_blank" rel="noopener"
                    class="btn btn--secondary btn--lg btn--mobile-full">
                    <span class="material-icons-outlined" style="font-size:20px;" aria-hidden="true">photo_camera</span>
                    Instagram<span class="visually-hidden"> (abre em nova aba)</span>
                </a>
                <a href="https://www.youtube.com/@ChapeFutsal" target="_blank" rel="noopener"
                    class="btn btn--secondary btn--lg btn--mobile-full">
                    <span class="material-icons-outlined" style="font-size:20px;" aria-hidden="true">play_circle</span>
                    YouTube<span class="visually-hidden"> (abre em nova aba)</span>
                </a>
            </div>
        </div>
    </section>

    </main>
@endsection
