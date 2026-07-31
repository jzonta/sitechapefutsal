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

### 7. Atualizar os cards de jogo (seção "Calendário de Jogos")

Só se aplica quando a notícia **muda a situação dos jogos** — pós-jogo com resultado ou confirmação/mudança do próximo confronto. Notícia institucional pura pode pular este passo.

A seção `<!-- JOGOS -->` do `index.html` tem **dois cards** (`.games-grid`):

- **Último Jogo** — `<article class="game-card game-card--result">`
- **Próximo Jogo** — `<article class="game-card game-card--upcoming">`

Num **pós-jogo**, o fluxo normal é: mover o confronto que era "Próximo Jogo" para "Último Jogo" com o placar, e colocar o **próximo confronto** no card de "Próximo Jogo".

**Card "Último Jogo"** — o que trocar:
- **Chip casa/fora** (canto direito do topo): fora → `<span class="material-icons-outlined">flight_takeoff</span> Fora de casa`; casa → adicione a classe `game-card__chip--home` e use `<span class="material-icons-outlined">home</span> Em casa`.
- `game-card__comp` → `Campeonato ... · Xª Rodada`.
- `game-card__date` → `DD Mmm AAAA · HHhMM` (ex: `30 Jul 2026 · 19h30`).
- Escudos e nomes dos dois times (o **mandante fica à esquerda**). O escudo da Chape usa a `<div class="game-card__team-logo game-card__team-logo--chape">`; o adversário usa `game-card__team-logo` sem a modificadora.
- **Placar**: dois `game-card__goals`; adicione `game-card__goals--win` no gol **do vencedor** (realça; o perdedor fica esmaecido). Em empate, não use `--win` em nenhum.
- **Pill de resultado** (`game-card__result-tag`), do ponto de vista da Chape:
  - Vitória → `game-card__result-tag--win`, ícone `check_circle`, texto `Vitória`
  - Empate → `game-card__result-tag--draw`, ícone `remove`, texto `Empate`
  - Derrota → `game-card__result-tag--loss`, ícone `cancel`, texto `Derrota`
- **Rodapé**: `game-card__meta` com o ginásio/cidade e o CTA fantasma `game-card__cta--ghost` **"Ver relato da partida"** apontando para a `noticiaXX.html` recém-criada (o relato daquele jogo).

**Card "Próximo Jogo"** — o que trocar:
- Chip casa/fora (mesma regra acima).
- `game-card__comp`, `game-card__date`, escudos e nomes (Chape à esquerda quando mandante).
- **Contador regressivo** — o atributo **`data-countdown`** do `<div class="game-card__countdown" ...>` é o que alimenta o JS ([initGameCountdown() em js/main.js](../../js/main.js)). Coloque a data/hora do jogo em ISO com fuso de Brasília: `data-countdown="AAAA-MM-DDTHH:MM:00-03:00"` (ex: `2026-08-08T19:30:00-03:00`). O texto `Faltam X dias` dentro de `.game-card__countdown-text` é só fallback — o JS o sobrescreve com o valor real —, mas atualize-o para um número plausível.
- **Rodapé**: `game-card__meta` com o local e o CTA verde `game-card__cta--green` **"Comprar ingresso"** (ícone `confirmation_number`) apontando para o link de ingressos daquele jogo. Se o usuário não passar o link, **pergunte** ou remova o botão — não invente URL.

**Escudos novos**: se o adversário ainda não tiver escudo em `images/escudos/`, peça/gere o arquivo (`.webp` ou `.png`) e referencie-o, como já é feito para o banner. Nomeie em minúsculas com hífen (ex: `sorriso.png`, `america-mg.webp`).

### 8. Verificar

```bash
cd /Users/joaozonta/Code/sitechapefutsal
grep -c 'class="card" data-animate' index.html   # deve ser 6
for f in $(grep -o 'noticiaXX-[0-9].jpg' noticiaXX.html | sort -u); do test -f "images/noticias/$f" && echo "OK $f" || echo "FALTA $f"; done
```

### 9. Preview — abra e confira ANTES de publicar

Nunca faça commit/push direto. Primeiro abra a página no navegador local para o usuário revisar:

```bash
open /Users/joaozonta/Code/sitechapefutsal/noticiaXX.html
open /Users/joaozonta/Code/sitechapefutsal/index.html
```

Então **pergunte explicitamente**: "Conferido. Posso publicar (commit + push)?" e liste em uma linha o que será enviado (página nova, imagens `noticiaXX-*.jpg`, `index.html`, `noticias.html`). **Espere a confirmação.** Se o usuário pedir ajustes, corrija e abra o preview de novo.

### 10. Publicar (só após o "sim")

Um `git push` já atualiza o site no ar (servidor puxa via git) — então publicar = commit + push. Mensagem em português no padrão dos commits anteriores, descrevendo a notícia:

```bash
cd /Users/joaozonta/Code/sitechapefutsal
git add noticiaXX.html images/noticias/noticiaXX-*.jpg index.html noticias.html
git commit -m "Adicionada notícia XX (resumo curto) e atualizadas listagens da home e de notícias"
git push
```

Confirme ao usuário que foi publicado e que o site atualiza sozinho em instantes.

## Cache do Cloudflare — versão dos assets (`?v=`)

O site fica atrás do **Cloudflare**, que **cacheia `css/*.css` e `js/*.js` por 4 horas** (`max-age=14400`). As páginas `.html` **não** são cacheadas (`cf-cache-status: DYNAMIC`), então mudança em HTML aparece na hora — mas mudança em **CSS ou JS** ficaria "presa" no cache antigo por horas.

Por isso todas as páginas carregam os assets com um selo de versão:

```html
<link rel="stylesheet" href="css/index.css?v=20260730">
<link rel="stylesheet" href="css/components.css?v=20260730">
<script src="js/main.js?v=20260730"></script>
```

Como o HTML é sempre fresco, trocar o número do `?v=` faz o navegador/Cloudflare baixarem o arquivo novo **imediatamente**.

- **Adicionar notícia (fluxo normal): NÃO precisa bumpar.** Você mexe só em HTML e imagens — o CSS/JS não mudam, então o cache deles pode continuar.
- **Se você alterar qualquer arquivo em `css/` ou `js/`**, incremente o `?v=` (use a data do dia, `AAAAMMDD`) em **todas** as páginas e no template, com um comando só:

```bash
cd /Users/joaozonta/Code/sitechapefutsal
OLD=20260730; NEW=$(date +%Y%m%d)   # ou o número atual → novo
perl -0777 -pi -e "s/\\?v=$OLD\"/?v=$NEW\"/g" *.html .claude/skills/adicionar-noticia/templates/noticia-template.html
grep -c "v=$NEW" index.html   # confere que aplicou
```

Alternativa quando o cache já está velho e você quer resolver na hora sem bumpar: **purgar o cache no painel do Cloudflare** (Caching → Purge Cache → Purge Everything).

## Regra de ouro

**Não altere o texto da notícia** fornecido pelo usuário e **siga o padrão visual já existente** — copie de uma página recente em vez de inventar marcação nova.
