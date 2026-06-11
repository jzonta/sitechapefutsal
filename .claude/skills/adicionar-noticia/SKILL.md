---
name: adicionar-noticia
description: Adiciona uma nova notícia ao site da Chapecoense Futsal — cria a página noticiaXX.html seguindo o template existente, processa/otimiza as imagens e atualiza index.html e noticias.html. Use quando o usuário pedir para adicionar/publicar uma notícia, matéria ou post no site.
---

# Adicionar Notícia ao Site da Chapecoense Futsal

Site estático em HTML puro. Cada notícia é uma página `noticiaXX.html` na raiz, com imagens em `images/noticias/`. As notícias aparecem em dois lugares: o grid de "Últimas Notícias" no `index.html` (sempre **6 cards**) e a listagem completa em `noticias.html` (todas as notícias).

## Entradas necessárias

Antes de começar, garanta que você tem:
- **Título** (h1) e **subtítulo/linha-fina** (uma frase resumo)
- **Corpo** da notícia (parágrafos) — copie o texto exatamente como fornecido, sem reescrever
- **Tag/categoria** — uma das que já existem: `Série Ouro`, `Copa SC`, `Comissão Técnica`, etc. Escolha a que melhor se encaixa.
- **Data** da publicação (ex: "10 de junho de 2026")
- **Imagens** — caminho dos arquivos (geralmente em `~/Downloads`). A 1ª imagem é a capa/hero.
- **Crédito das fotos** (ex: `@rogersilva_fotografia/@achapefutsal`)

Se algo estiver faltando, pergunte antes de prosseguir.

## Passos

### 1. Determinar o próximo número

```bash
cd /Users/joaozonta/Code/sitechapefutsal
ls noticia[0-9]*.html | sed -E 's/noticia0*([0-9]+)\.html/\1/' | sort -n | tail -1
```

O próximo é esse número + 1 (ex: 17 → 18). Use sempre dois dígitos para 1–9? **Não** — as páginas a partir da 12 usam número sem zero à esquerda (`noticia12.html` … `noticia17.html`). Siga o padrão da última página existente. As imagens seguem `noticiaXX-1.jpg`, `noticiaXX-2.jpg`, etc.

### 2. Processar as imagens

As imagens originais costumam ser grandes (vários MB). Redimensione para no máx. 1600px e comprima para JPEG qualidade ~60, mirando ~200–300KB por arquivo (padrão das notícias recentes). Use `sips` (nativo do macOS):

```bash
cd /Users/joaozonta/Code/sitechapefutsal/images/noticias
# Repita para cada imagem; ajuste o caminho de origem
sips -Z 1600 -s format jpeg -s formatOptions 60 "/caminho/origem.jpeg" --out "noticiaXX-1.jpg" >/dev/null 2>&1
ls -la noticiaXX-*.jpg   # confirme tamanhos
```

Não mova nem apague os arquivos originais de `~/Downloads`.

### 3. Criar a página `noticiaXX.html`

Copie a estrutura de uma página recente como referência (`noticia17.html` é um bom modelo para pré-jogo; `noticia16.html` para pós-jogo com placar). Use `templates/noticia-template.html` deste skill como base e substitua os marcadores `{{...}}`.

Pontos de atenção ao preencher:
- `<title>` = `{{TÍTULO}} — Chapecoense Futsal`
- `<meta name="description">` e `hero__subtitle` = subtítulo
- `og:image` e `hero__bg img` = `images/noticias/noticiaXX-1.jpg`
- Tag e data no `article-meta` do hero **e** nos cards
- Intercale as imagens 2 e 3 no corpo com `<figure>` (veja o template)
- **Sidebar**: adapte os boxes ao tipo de notícia:
  - Pós-jogo com resultado → Competição, Resultado (placar), Gols da Chape, Data e Local, Próximo Jogo
  - Pré-jogo / institucional → Competição, situação, Próximo Jogo, Premiação, etc.
- Bloco "Outras notícias" na sidebar: aponte para as **2 notícias imediatamente anteriores**
- Linha de crédito das fotos ao final do corpo
- Header e footer são idênticos em todas as páginas — copie sem alterar

### 4. Atualizar `index.html` (grid de 6 cards)

Localize o `<div class="grid grid-3 gap-8">` na seção "ÚLTIMAS NOTÍCIAS". Insira o card da nova notícia como **primeiro** (mais recente) e **remova o card mais antigo** para manter exatamente 6. Os `data-delay` ciclam `100/200/300` — renumere se necessário. Modelo do card:

```html
<a href="noticiaXX.html" class="card" data-animate data-delay="100" style="text-decoration: none; display: block; color: inherit;">
  <img class="card__image" src="images/noticias/noticiaXX-1.jpg"
    alt="{{TÍTULO}}" style="object-position: center;">
  <div class="card__body">
    <span class="card__tag">{{TAG}}</span>
    <div class="card__date">{{DATA}}</div>
    <h3 class="card__title">{{TÍTULO}}</h3>
    <p class="card__text">{{SUBTÍTULO}}</p>
    <span class="card__link">
      Ler matéria completa
      <span class="material-icons-outlined" style="font-size:16px;">arrow_forward</span>
    </span>
  </div>
</a>
```

### 5. Atualizar `noticias.html` (listagem completa)

Insira o **mesmo card** como primeiro item do grid `<div class="grid grid-3 gap-8">`, com indentação de 4 espaços (padrão do arquivo). **Não remova** nada aqui — esta página lista todas as notícias.

### 6. (Opcional) Banner principal

Se a notícia for sobre um jogo e o usuário pedir, atualize o `result-banner` no topo do `index.html` (escudos, data, local, placar). Quando a Chape joga **fora de casa**, o mandante vem primeiro (à esquerda) e a Chape depois. Escudos em `images/escudos/`.

### 7. Verificar

```bash
cd /Users/joaozonta/Code/sitechapefutsal
grep -c 'class="card" data-animate' index.html   # deve ser 6
for f in $(grep -o 'noticiaXX-[0-9].jpg' noticiaXX.html | sort -u); do test -f "images/noticias/$f" && echo "OK $f" || echo "FALTA $f"; done
```

### 8. Commit

Só faça commit/push se o usuário pedir. Mensagem em português, ex: `Adicionada notícia XX`. Inclua a página, as imagens e os dois arquivos atualizados.

## Regra de ouro

**Não altere o texto da notícia** fornecido pelo usuário e **siga o padrão visual já existente** — copie de uma página recente em vez de inventar marcação nova.
