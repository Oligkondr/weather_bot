restart: stop up

env:
	cp .env.example .env
composer-install:
	docker-compose exec --user=1000 laravel.test bash -c "composer install"
npm-install:
	docker-compose exec --user=1000 laravel.test bash -c "npm install"
data:
	docker-compose exec --user=1000 laravel.test bash -c "php artisan data:refresh"

optimize:
	docker-compose exec --user=1000 laravel.test bash -c "php artisan optimize"
key-generate:
	docker-compose exec --user=1000 laravel.test bash -c "php artisan key:generate"
migrate:
	docker-compose exec --user=1000 laravel.test bash -c "php artisan migrate"
route-list:
	docker-compose exec --user=1000 laravel.test bash -c "php artisan route:list"

up:
	docker-compose up -d
up-fresh:
	docker-compose up -d --build --force-recreate
stop:
	docker-compose stop
down:
	docker-compose down
shell:
	docker-compose exec --user=1000 laravel.test bash
shell-root:
	docker-compose exec laravel.test bash
dev:
	npm run dev
build:
	npm run build
