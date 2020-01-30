.PHONY: init up down restart help test phpcs ssh-app

help: ## Show this help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

init: ## Init services and install dependencies
	@make build
	@make up
	@make migrate
	@make npm

build: ## Build containers
	docker-compose build

up: ## Run services
	docker-compose up -d

down: ## Stop services and remove containers
	docker-compose down --remo

test: ## Run tests
	docker-compose exec app php vendor/bin/phpunit

phpcs: ## Run phpcs
	docker-compose exec app php vendor/bin/phpcs --standard=phpcs.xml --extensions=php . -p

eslint: ## Run eslint
	docker run --rm -v $(PWD):/app -v ~/.ssh:/root/.ssh -w /app node:lts npm run-script eslint

npm: ## Install npm dependencies
	docker run --rm -v $(PWD):/app -v ~/.ssh:/root/.ssh -w /app node:lts npm i

npm-watch: ## Watch npm watch (dev)
	docker run --rm -v $(PWD):/app -v ~/.ssh:/root/.ssh -w /app node:lts npm run-script watch

npm-build: ## Watch npm build
	docker run --rm -v $(PWD):/app -v ~/.ssh:/root/.ssh -w /app node:lts npm run-script build

prune: ## Rune system from docker-trash
	@docker system prune -f --volumes

restart: ## Restart services
	@make -s down
	@make -s up

ssh-app: ## Shortcut to get inside app container
	docker-compose exec app bash

%:
	@:
