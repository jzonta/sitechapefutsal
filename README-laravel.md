# Chapecoense Futsal — Laravel + Docker

Único requisito na máquina: **Docker** (com Compose v2). Não é preciso PHP, Composer nem Node.

## Subir pela primeira vez
```bash
cp .env.example .env     # ajuste UID/GID se `id -u` não for 1000
make install             # build, composer install, npm build, key, migrate e importação das notícias
```
Site: http://localhost:8080 · E-mails (Mailpit): http://localhost:8025 · MySQL no host: porta 3307.

## Dia a dia
| Comando | O que faz |
|---|---|
| `make up` / `make down` | sobe / derruba os containers |
| `make artisan cmd="migrate"` | roda o Artisan |
| `make composer cmd="require x/y"` | roda o Composer |
| `make npm cmd="run build"` | roda o npm |
| `make test` | testes |
| `make fresh` | recria o banco e reimporta as notícias |
| `docker compose up node` | Vite com hot reload (porta 5173) |

Sem o Vite em execução, o site usa os assets compilados em `app/public/build` (`make npm cmd="run build"`).

## Estrutura
- `app/` aplicação Laravel 13 (Tailwind 4 + Vite; o CSS/JS originais estão em `resources/css/legacy` e `resources/js/legacy-main.js`).
- `docker/` Dockerfile (estágios `dev` e `prod`), nginx e php.ini.
- Os HTML originais na raiz continuam como referência; `noticias:importar` lê deles (montados em `/legacy`).
- URLs antigas (`noticiaNN.html`, `historia.html`…) redirecionam 301 para as novas.

## Notícias
Model `Noticia` (tabela `noticias`). `php artisan noticias:importar --force` reimporta do HTML legado.
Para o fluxo definitivo, novas notícias devem ser criadas direto no banco (futuro painel admin); a skill `adicionar-noticia` ainda gera HTML estático e precisa ser adaptada.
