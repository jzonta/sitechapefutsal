<?php

namespace App\Console\Commands;

use App\Models\Noticia;
use Carbon\Carbon;
use DOMDocument;
use DOMNode;
use DOMXPath;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportarNoticias extends Command
{
    protected $signature = 'noticias:importar {--dir=/legacy : Pasta com os noticiaXX.html} {--force : Reimporta e sobrescreve existentes}';

    protected $description = 'Importa as notícias do site estático (noticiaXX.html) para o banco';

    private const MESES = [
        'janeiro' => 1, 'fevereiro' => 2, 'março' => 3, 'abril' => 4, 'maio' => 5, 'junho' => 6,
        'julho' => 7, 'agosto' => 8, 'setembro' => 9, 'outubro' => 10, 'novembro' => 11, 'dezembro' => 12,
    ];

    public function handle(): int
    {
        $files = glob(rtrim($this->option('dir'), '/').'/noticia*.html') ?: [];
        if (! $files) {
            $this->error('Nenhum arquivo encontrado em '.$this->option('dir'));

            return self::FAILURE;
        }

        $criadas = $atualizadas = $puladas = 0;

        foreach ($files as $file) {
            if (! preg_match('/noticia(\d+)\.html$/', $file, $m)) {
                continue;
            }
            $legacyId = (int) $m[1];
            $existente = Noticia::where('legacy_id', $legacyId)->first();
            if ($existente && ! $this->option('force')) {
                $puladas++;

                continue;
            }

            $dados = $this->parse($file);
            if (! $dados) {
                $this->warn("Falha ao interpretar {$file}");

                continue;
            }

            $dados['legacy_id'] = $legacyId;
            $dados['slug'] = $existente?->slug ?? $this->slugUnico($dados['titulo'], $legacyId);
            Noticia::updateOrCreate(['legacy_id' => $legacyId], $dados);
            $existente ? $atualizadas++ : $criadas++;
        }

        $this->info("Criadas: {$criadas} | Atualizadas: {$atualizadas} | Já existentes: {$puladas}");

        return self::SUCCESS;
    }

    private function parse(string $file): ?array
    {
        $dom = new DOMDocument;
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">'.file_get_contents($file));
        libxml_clear_errors();
        $xp = new DOMXPath($dom);

        $titulo = $this->texto($xp->query('//h1[contains(@class,"hero__title")]')->item(0));
        $article = $xp->query('//article[contains(@class,"article-body")]')->item(0);
        if (! $titulo || ! $article) {
            return null;
        }

        // Corpo: tudo do <article> exceto o link "Voltar às notícias"
        foreach ($xp->query('.//a[contains(@class,"article-back")]', $article) as $back) {
            $back->parentNode->removeChild($back);
        }
        $corpo = $this->reescrever($this->innerHtml($article));

        // Sidebar: caixas, sem o bloco "Outras notícias" (agora dinâmico)
        $sidebar = '';
        $aside = $xp->query('//aside[contains(@class,"article-sidebar")]')->item(0);
        if ($aside) {
            foreach ($aside->childNodes as $child) {
                if ($child->nodeType !== XML_ELEMENT_NODE) {
                    continue;
                }
                if ($xp->query('.//*[contains(@class,"article-related")]', $child)->length) {
                    continue;
                }
                $sidebar .= $dom->saveHTML($child)."\n";
            }
        }

        $hero = $xp->query('//div[contains(@class,"hero__bg")]/img')->item(0);
        $meta = $xp->query('//meta[@property="og:image"]')->item(0);
        $imagem = $hero?->getAttribute('src') ?: $meta?->getAttribute('content');
        $desc = $xp->query('//meta[@name="description"]')->item(0);

        return [
            'titulo' => $titulo,
            'resumo' => $this->texto($xp->query('//p[contains(@class,"hero__subtitle")]')->item(0)) ?: $desc?->getAttribute('content'),
            'categoria' => $this->texto($xp->query('//div[contains(@class,"article-meta")]/span[contains(@class,"card__tag")]')->item(0)) ?: null,
            'corpo' => trim($corpo),
            'imagem' => $imagem ? ltrim($imagem, '/') : null,
            'imagem_alt' => $hero?->getAttribute('alt') ?: null,
            'imagem_posicao' => $this->posicao($hero?->getAttribute('style')),
            'sidebar_html' => trim($this->reescrever($sidebar)) ?: null,
            'publicado_em' => $this->data($xp),
            'publicado' => true,
        ];
    }

    private function data(DOMXPath $xp): ?Carbon
    {
        $span = $xp->query('//div[contains(@class,"article-meta")]/span[not(contains(@class,"card__tag"))]')->item(0);
        $t = mb_strtolower($this->texto($span));
        if (preg_match('/(\d{1,2})\s+de\s+(\p{L}+)\s+de\s+(\d{4})/u', $t, $m) && isset(self::MESES[$m[2]])) {
            return Carbon::create((int) $m[3], self::MESES[$m[2]], (int) $m[1], 12);
        }

        return null;
    }

    private function posicao(?string $style): ?string
    {
        return $style && preg_match('/object-position:\s*([^;]+)/', $style, $m) ? trim($m[1]) : null;
    }

    private function texto(?DOMNode $n): string
    {
        return $n ? trim(preg_replace('/\s+/u', ' ', $n->textContent)) : '';
    }

    private function innerHtml(DOMNode $n): string
    {
        $html = '';
        foreach ($n->childNodes as $c) {
            $html .= $n->ownerDocument->saveHTML($c);
        }

        return $html;
    }

    /** Caminhos relativos do site antigo -> absolutos do Laravel. */
    private function reescrever(string $html): string
    {
        $html = preg_replace('/(src|href)="images\//', '$1="/images/', $html);
        $html = preg_replace('/href="noticia(\d+)\.html"/', 'href="/noticia$1.html"', $html);
        $html = preg_replace('/href="(index|historia|competicoes|contato|elenco|transparencia)\.html/', 'href="/$1.html', $html);

        return $html;
    }

    private function slugUnico(string $titulo, int $legacyId): string
    {
        $base = Str::slug(Str::limit($titulo, 100, ''));
        $slug = $base;
        if (Noticia::where('slug', $slug)->where('legacy_id', '!=', $legacyId)->exists()) {
            $slug = "{$base}-{$legacyId}";
        }

        return $slug;
    }
}
