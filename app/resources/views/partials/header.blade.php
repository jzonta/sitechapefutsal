<header class="site-header" id="site-header">
    <div class="header-inner">
        <a href="{{ route('home') }}" class="header-logo">
            <img src="{{ asset('images/logomarca.webp') }}" alt="Chapecoense Futsal" width="40" height="40">
            <span>Chapecoense Futsal</span>
        </a>
        <nav class="nav-links" id="nav-links">
            <a href="{{ route('home') }}">Início</a>
            <a href="{{ route('historia') }}">O Clube</a>
            <a href="{{ route('elenco') }}" style="display:none;">Elenco</a>
            <a href="{{ route('competicoes') }}">Competições</a>
            <a href="{{ route('transparencia') }}">Transparência</a>
            <a href="{{ route('contato') }}">Contato</a>
            <a href="https://chapefutsal.socioclube.com.br/associe-se.aspx" target="_blank" rel="noopener"
                class="btn btn--primary btn--sm nav-cta">Seja Sócio</a>
        </nav>
        <div class="mobile-toggle" id="mobile-toggle" aria-label="Menu">
            <span></span><span></span><span></span>
        </div>
    </div>
</header>
