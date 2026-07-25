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
- **Imagens** — ficam em `~/Downloads` (vindas do WhatsApp). Não peça o caminho de cada uma: liste as recentes no **Passo 0** e confirme quais entram. A 1ª imagem é a capa/hero.
- **Crédito das fotos** (ex: `@rogersilva_fotografia/@achapefutsal`)

Se algo estiver faltando, pergunte antes de prosseguir.

## Passos

### 0. Localizar as fotos novas no Downloads

As fotos chegam pelo WhatsApp e o usuário salva em `~/Downloads`. Em vez de pedir o caminho de cada uma, liste as imagens mais recentes e confirme quais são as desta notícia:

```bash
ls -lt ~/Downloads/ | grep -iE '\.(jpg|jpeg|png|heic)$' | head -20
```

Mostre a lista ao usuário e pergunte **quais arquivos** entram (e em que ordem — a 1ª é a capa/hero). Se ele já disse quais são, siga direto. Não mova nem apague os originais.

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

### 6. Banner principal (última notícia)

O banner no topo do `index.html` — `<a class="hero hero--compact home-hero">` dentro de `.hero-banner__wrapper` — sempre reflete a **última notícia**. A cada notícia nova, atualize-o para a matéria recém-criada:

- `href` do `<a>` → `noticiaXX.html`
- `hero__bg` `<img>` → uma foto **diferente** da capa da notícia interna (que usa a `-1`). Escolha outra imagem de ação da matéria — normalmente `images/noticias/noticiaXX-2.jpg` — e ajuste o `alt` para descrevê-la
- `card__tag` → {{TAG}} e a data ao lado → {{DATA}}
- `hero__title` → {{TÍTULO}}
- `hero__subtitle` → {{SUBTÍTULO}}

Título, tag, data e subtítulo são os mesmos do primeiro card da home (Passo 4); só a **foto de fundo do banner deve diferir** da capa (`-1`) usada no hero interno.

### 7. Verificar

```bash
cd /Users/joaozonta/Code/sitechapefutsal
grep -c 'class="card" data-animate' index.html   # deve ser 6
for f in $(grep -o 'noticiaXX-[0-9].jpg' noticiaXX.html | sort -u); do test -f "images/noticias/$f" && echo "OK $f" || echo "FALTA $f"; done
```

### 8. Preview — abra e confira ANTES de publicar

Nunca faça commit/push direto. Primeiro abra a página no navegador local para o usuário revisar:

```bash
open /Users/joaozonta/Code/sitechapefutsal/noticiaXX.html
open /Users/joaozonta/Code/sitechapefutsal/index.html
```

Então **pergunte explicitamente**: "Conferido. Posso publicar (commit + push)?" e liste em uma linha o que será enviado (página nova, imagens `noticiaXX-*.jpg`, `index.html`, `noticias.html`). **Espere a confirmação.** Se o usuário pedir ajustes, corrija e abra o preview de novo.

### 9. Publicar (só após o "sim")

Um `git push` já atualiza o site no ar (servidor puxa via git) — então publicar = commit + push. Mensagem em português no padrão dos commits anteriores, descrevendo a notícia:

```bash
cd /Users/joaozonta/Code/sitechapefutsal
git add noticiaXX.html images/noticias/noticiaXX-*.jpg index.html noticias.html
git commit -m "Adicionada notícia XX (resumo curto) e atualizadas listagens da home e de notícias"
git push
```

Confirme ao usuário que foi publicado e que o site atualiza sozinho em instantes.

## Regra de ouro

**Não altere o texto da notícia** fornecido pelo usuário e **siga o padrão visual já existente** — copie de uma página recente em vez de inventar marcação nova.
