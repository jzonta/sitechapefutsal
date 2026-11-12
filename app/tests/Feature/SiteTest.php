<?php

namespace Tests\Feature;

use App\Mail\ContatoMail;
use App\Models\Noticia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use RefreshDatabase;

    private function noticia(array $attrs = []): Noticia
    {
        return Noticia::create($attrs + [
            'legacy_id' => 1, 'slug' => 'teste', 'titulo' => 'Notícia de teste', 'resumo' => 'Resumo',
            'categoria' => 'Copa SC', 'corpo' => '<p>Corpo</p>', 'imagem' => 'images/noticias/x.jpg',
            'publicado_em' => now(),
        ]);
    }

    public function test_paginas_principais_respondem(): void
    {
        $this->noticia();
        foreach (['/', '/o-clube', '/elenco', '/competicoes', '/transparencia', '/contato', '/noticias'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_home_funciona_sem_noticias(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_noticia_e_redirect_legado(): void
    {
        $n = $this->noticia();
        $this->get('/noticias/teste')->assertOk()->assertSee('Notícia de teste');
        $this->get('/noticia1.html')->assertRedirect(route('noticias.show', $n))->assertStatus(301);
        $this->get('/noticia999.html')->assertNotFound();
    }

    public function test_noticia_despublicada_da_404(): void
    {
        $this->noticia(['publicado' => false]);
        $this->get('/noticias/teste')->assertNotFound();
    }

    public function test_contato_envia_email(): void
    {
        Mail::fake();
        $this->post('/contato', ['nome' => 'Ana', 'email' => 'ana@example.com', 'mensagem' => 'Olá'])
            ->assertSessionHas('sucesso');
        Mail::assertSent(ContatoMail::class);
    }

    public function test_contato_valida(): void
    {
        $this->post('/contato', [])->assertSessionHasErrors(['nome', 'email', 'mensagem']);
    }
}
