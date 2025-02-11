setup:
	@make docker-up-build
	@make composer-install
	@make npm-install-build
	@make set-permissions
	@make setup-env
	@make generate-key
	@make migrate-fresh-seed

docker-stop:
	docker compose stop

docker-up-build:
	docker compose up -d --build

composer-install:
	docker exec ecommerce-app bash -c "composer install"

composer-update:
	docker exec ecommerce-app bash -c "composer update"

set-permissions:
	sudo chmod -R 775 /var/www/html/ecommerce-management
	docker exec ecommerce-nginx bash -c "chmod -R 777 /var/www"
	docker exec ecommerce-app bash -c "chmod -R 777 /var/www/storage"
	docker exec ecommerce-app bash -c "chmod -R 777 /var/www/bootstrap"

setup-env:
	docker exec ecommerce-app bash -c "cp .env-docker.example .env"

npm-install-build:
	docker exec ecommerce-node bash -c "npm install"
	docker exec ecommerce-node bash -c "npm run build:docker"

npm-run-dev:
	docker exec ecommerce-node bash -c "npm run dev:docker"

npm-run-build:
	docker exec ecommerce-node bash -c "npm run build:docker"

generate-key:
	docker exec ecommerce-app bash -c "php artisan key:generate"

migrate-fresh-seed:
	docker exec ecommerce-app bash -c "php artisan migrate:fresh --seed"
