DC = docker compose
APP = $(DC) exec app

.PHONY: up down build logs shell artisan composer npm test fresh install

install: build ## Primeira subida: build, dependências, key, migrations e import
	$(DC) up -d db app
	$(DC) run --rm composer install
	$(DC) run --rm node sh -c "npm install && npm run build"
	$(APP) php artisan key:generate --force
	$(APP) php artisan migrate --force
	$(APP) php artisan storage:link || true
	$(APP) php artisan noticias:importar
	$(DC) up -d

build:
	$(DC) build

up:
	$(DC) up -d

down:
	$(DC) down

logs:
	$(DC) logs -f

shell:
	$(APP) sh

artisan:
	$(APP) php artisan $(cmd)

composer:
	$(DC) run --rm composer $(cmd)

npm:
	$(DC) run --rm node npm $(cmd)

test:
	$(APP) php artisan test

fresh:
	$(APP) php artisan migrate:fresh --force && $(APP) php artisan noticias:importar
