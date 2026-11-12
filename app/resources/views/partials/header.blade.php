<header class="site-header" id="site-header">
    <div class="header-inner">
        <a href="{{ route('home') }}" class="header-logo">
            <img src="{{ asset('images/logomarca.webp') }}" alt="Chapecoense Futsal" width="40" height="40">
            <span>Chapecoense Futsal</span>
        </a>
        <nav class="nav-links" id="nav-links" aria-label="Principal">
            <a href="{{ route('home') }}" @class(['active' => request()->routeIs('home')]) @if (request()->routeIs('home')) aria-current="page" @endif>Início</a>
            <a href="{{ route('historia') }}" @class(['active' => request()->routeIs('historia')]) @if (request()->routeIs('historia')) aria-current="page" @endif>O Clube</a>
            <a href="{{ route('elenco') }}" @class(['active' => request()->routeIs('elenco')]) @if (request()->routeIs('elenco')) aria-current="page" @endif style="display:none;">Elenco</a>
            <a href="{{ route('competicoes') }}" @class(['active' => request()->routeIs('competicoes')]) @if (request()->routeIs('competicoes')) aria-current="page" @endif>Competições</a>
            <a href="{{ route('transparencia') }}" @class(['active' => request()->routeIs('transparencia')]) @if (request()->routeIs('transparencia')) aria-current="page" @endif>Transparência</a>
            <a href="{{ route('contato') }}" @class(['active' => request()->routeIs('contato')]) @if (request()->routeIs('contato')) aria-current="page" @endif>Contato</a>
            <a href="https://chapefutsal.socioclube.com.br/associe-se.aspx" target="_blank" rel="noopener"
                class="btn btn--primary btn--sm nav-cta">Seja Sócio</a>
        </nav>
        <button type="button" class="mobile-toggle" id="mobile-toggle" aria-label="Abrir menu" aria-controls="nav-links">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>
