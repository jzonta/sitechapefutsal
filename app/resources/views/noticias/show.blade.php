@extends('layouts.app')

@section('title', $noticia->titulo.' — Chapecoense Futsal')
@section('description', $noticia->resumo)
@section('og_image', '/'.$noticia->imagem)

@section('content')
    <!-- HERO DA NOTÍCIA -->
    <section class="hero hero--compact hero--article">
        <div class="hero__bg">
            <img src="{{ asset($noticia->imagem) }}" alt="{{ $noticia->imagem_alt }}"
                style="object-position: {{ $noticia->imagem_posicao ?? 'center' }};">
        </div>
        <div class="hero__overlay"
            style="background:linear-gradient(to top, rgba(0,30,15,0.92) 0%, rgba(0,50,30,0.55) 60%, rgba(0,0,0,0.2) 100%);">
        </div>
        <div class="hero__content" style="padding-bottom:var(--space-16);">
            <div class="article-meta" style="margin-bottom:var(--space-4);">
                <span class="card__tag"
                    style="background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.3);">{{ $noticia->categoria }}</span>
                <span style="color:rgba(255,255,255,0.7);font-size:var(--font-size-sm);margin-left:var(--space-3);">{{ $noticia->publicado_em->translatedFormat('j \d\e F \d\e Y') }}</span>
            </div>
            <h1 class="hero__title" style="max-width:850px;">{{ $noticia->titulo }}</h1>
            <p class="hero__subtitle" style="max-width:650px;">{{ $noticia->resumo }}</p>
        </div>
    </section>

    <!-- CONTEÚDO DA NOTÍCIA -->
    <section class="section">
        <div class="container">
            <div style="display:grid;grid-template-columns:1fr 340px;gap:var(--space-16);align-items:start;"
                class="article-grid">

                <article class="article-body">
                    <a href="{{ route('noticias.index') }}" class="article-back"
                        style="display:inline-flex;align-items:center;gap:var(--space-2);color:var(--color-green);font-size:var(--font-size-sm);font-weight:600;margin-bottom:var(--space-8);text-decoration:none;">
                        <span class="material-icons-outlined" style="font-size:18px;" aria-hidden="true">arrow_back</span>
                        Voltar às notícias
                    </a>

                    {!! $noticia->corpo !!}
                </article>

                <aside class="article-sidebar">
                    {!! $noticia->sidebar_html !!}
                    @if ($relacionadas->isNotEmpty())
                    <div style="margin-top:var(--space-8);">
                        <div
                            style="font-size:var(--font-size-xs);font-weight:600;text-transform:uppercase;letter-spacing:0.08em;color:var(--color-text-muted);margin-bottom:var(--space-4);">
                            Outras notícias</div>
                        @foreach ($relacionadas as $r)
                        <a href="{{ $r->url() }}" class="article-related">
                            <img src="{{ asset($r->imagem) }}" alt="" loading="lazy">
                            <span>{{ $r->titulo }}</span>
                        </a>
                        @endforeach
                    </div>
                    @endif
                </aside>
            </div>
        </div>
    </section>
@endsection
