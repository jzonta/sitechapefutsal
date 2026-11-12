    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="footer-brand__logo">
                        <img src="{{ asset('images/logomarca-branco.webp') }}" alt="Chapecoense Futsal">
                        Chapecoense Futsal
                    </div>
                    <p class="footer-brand__text">A força do futsal do oeste catarinense. Tradição, raça e paixão em
                        cada jogada.</p>
                    <div class="footer-social">
                        <a href="https://www.instagram.com/achapefutsal/" target="_blank" rel="noopener" aria-label="Instagram"><span
                                class="material-icons-outlined" aria-hidden="true">photo_camera</span></a>
                        <a href="https://www.youtube.com/@ChapeFutsal" target="_blank" rel="noopener" aria-label="YouTube"><span
                                class="material-icons-outlined" aria-hidden="true">play_circle</span></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h4 class="footer-column__title">Clube</h4>
                    <ul>
                        <li><a href="{{ route('historia') }}">História</a></li>
                        <li><a href="{{ route('transparencia') }}">Diretoria</a></li>
                        <li><a href="{{ route('transparencia') }}">Transparência</a></li>
                        <li><a href="{{ route('contato') }}">Trabalhe Conosco</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4 class="footer-column__title">Torcedor</h4>
                    <ul>
                        <li><a href="https://chapefutsal.socioclube.com.br/associe-se.aspx" target="_blank" rel="noopener">Sócio
                                Torcedor</a></li>
                        <li><a href="#">Ingressos</a></li>
                        <li><a href="{{ route('competicoes') }}">Calendário</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4 class="footer-column__title">Contato</h4>
                    <ul>
                        <li class="footer-contact-item">
                            <span class="material-icons-outlined" aria-hidden="true">place</span>
                            Rua Guaporé, nº 1.454 D<br>Chapecó, SC
                        </li>
                        <li class="footer-contact-item">
                            <span class="material-icons-outlined" aria-hidden="true">email</span>
                            juridico@chapefutsal.com.br
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span>© 2026 Associação Chapecoense de Futsal. Todos os direitos reservados.</span>
                <div class="footer-bottom__links">
                  <span>Desenvolvido por <a href="https://swsis.com.br" target="_blank" rel="noopener">SW Sistemas</a></span>
                </div>
            </div>
        </div>
    </footer>

