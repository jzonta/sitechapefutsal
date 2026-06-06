/* =============================================
   CHAPEFUTSAL - Main JavaScript
   ============================================= */

document.addEventListener('DOMContentLoaded', () => {
    initHeader();
    initMobileMenu();
    initFAQ();
    initNewsletterForm();
    initContactForm();
    initScrollAnimations();
    setActiveNav();
    initBannerCycle();
});

/* ---------- Banner animation cycle ---------- */
function initBannerCycle() {
    const layers = document.querySelectorAll('.hero-banner__layer');
    const cta = document.querySelector('.hero-banner__cta');
    if (!layers.length) return;

    const VISIBLE_DURATION = 8000;  // 8s visible
    const EXIT_DURATION = 1000;     // 1s for exit animations to complete

    // First entrance
    layers.forEach(layer => layer.classList.add('animate-in'));
    if (cta) cta.classList.add('animate-in');

    // After CTA finishes entrance (~3.3s), mark it as permanently visible
    if (cta) {
        setTimeout(() => {
            cta.classList.remove('animate-in');
            cta.classList.add('visible');
        }, 3500);
    }

    // Start the cycling loop
    setTimeout(() => {
        cycleBanner(layers, VISIBLE_DURATION, EXIT_DURATION);
    }, VISIBLE_DURATION);
}

function cycleBanner(layers, visibleDuration, exitDuration) {
    // Trigger exit — layers stay at opacity 1 via .animate-out CSS
    layers.forEach(layer => {
        layer.classList.remove('animate-in');
        layer.classList.add('animate-out');
    });

    // After exit completes, reset and re-enter
    setTimeout(() => {
        layers.forEach(layer => {
            layer.classList.remove('animate-out');
            layer.style.opacity = '0';
            // Force reflow to restart animation
            void layer.offsetWidth;
            layer.classList.add('animate-in');
        });

        // Schedule next cycle
        setTimeout(() => {
            cycleBanner(layers, visibleDuration, exitDuration);
        }, visibleDuration);
    }, exitDuration);
}

/* ---------- Header scroll effect ---------- */
function initHeader() {
    const header = document.querySelector('.site-header');
    if (!header) return;

    const onScroll = () => {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}

/* ---------- Mobile menu ---------- */
function initMobileMenu() {
    const toggle = document.querySelector('.mobile-toggle');
    const nav = document.querySelector('.nav-links');
    if (!toggle || !nav) return;

    toggle.addEventListener('click', () => {
        toggle.classList.toggle('open');
        nav.classList.toggle('open');
        document.body.style.overflow = nav.classList.contains('open') ? 'hidden' : '';
    });

    // Close on link click
    nav.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            toggle.classList.remove('open');
            nav.classList.remove('open');
            document.body.style.overflow = '';
        });
    });

    // Close on outside click
    document.addEventListener('click', (e) => {
        if (!nav.contains(e.target) && !toggle.contains(e.target) && nav.classList.contains('open')) {
            toggle.classList.remove('open');
            nav.classList.remove('open');
            document.body.style.overflow = '';
        }
    });
}

/* ---------- FAQ Accordion ---------- */
function initFAQ() {
    const faqItems = document.querySelectorAll('.faq-item');
    if (!faqItems.length) return;

    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        if (!question) return;

        question.addEventListener('click', () => {
            const isActive = item.classList.contains('active');

            // Close all
            faqItems.forEach(i => i.classList.remove('active'));

            // Toggle current
            if (!isActive) {
                item.classList.add('active');
            }
        });
    });
}

/* ---------- Newsletter form ---------- */
function initNewsletterForm() {
    const form = document.querySelector('.newsletter__form');
    if (!form) return;

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const input = form.querySelector('.newsletter__input');
        const email = input ? input.value.trim() : '';

        if (!email || !isValidEmail(email)) {
            showToast('Por favor, insira um e-mail válido.', 'error');
            return;
        }

        showToast('Inscrição realizada com sucesso! 🎉', 'success');
        if (input) input.value = '';
    });
}

/* ---------- Contact form ---------- */
function initContactForm() {
    const form = document.getElementById('contact-form');
    if (!form) return;

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const name = form.querySelector('#contact-name');
        const email = form.querySelector('#contact-email');
        const message = form.querySelector('#contact-message');

        if (!name?.value.trim()) {
            showToast('Por favor, informe seu nome.', 'error');
            return;
        }

        if (!email?.value.trim() || !isValidEmail(email.value)) {
            showToast('Por favor, insira um e-mail válido.', 'error');
            return;
        }

        if (!message?.value.trim()) {
            showToast('Por favor, escreva uma mensagem.', 'error');
            return;
        }

        showToast('Mensagem enviada com sucesso! Entraremos em contato em breve. ✉️', 'success');
        form.reset();
    });
}

/* ---------- Scroll animations ---------- */
function initScrollAnimations() {
    const elements = document.querySelectorAll('[data-animate]');
    if (!elements.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const delay = entry.target.dataset.delay || 0;
                setTimeout(() => {
                    entry.target.classList.add('animate-fade-in-up');
                    entry.target.style.opacity = '1';
                }, delay);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    elements.forEach(el => {
        el.style.opacity = '0';
        observer.observe(el);
    });
}

/* ---------- Active nav link ---------- */
function setActiveNav() {
    const path = window.location.pathname;
    const filename = path.split('/').pop() || 'index.html';

    document.querySelectorAll('.nav-links a').forEach(link => {
        const href = link.getAttribute('href');
        if (href === filename || (filename === '' && href === 'index.html')) {
            link.classList.add('active');
        }
    });
}

/* ---------- Helpers ---------- */
function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function showToast(message, type = 'success') {
    // Remove existing toasts
    document.querySelectorAll('.toast').forEach(t => t.remove());

    const toast = document.createElement('div');
    toast.className = `toast toast--${type}`;
    toast.textContent = message;

    Object.assign(toast.style, {
        position: 'fixed',
        bottom: '24px',
        right: '24px',
        padding: '14px 24px',
        borderRadius: '8px',
        color: '#fff',
        fontFamily: 'var(--font-family)',
        fontSize: '14px',
        fontWeight: '600',
        zIndex: '10000',
        animation: 'fadeInUp 0.3s ease',
        maxWidth: '400px',
        boxShadow: '0 8px 24px rgba(0,0,0,0.2)',
        background: type === 'success' ? '#16a34a' : '#dc2626',
    });

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}
