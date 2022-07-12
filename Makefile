#!/bin/bash

OS := $(shell uname)

ifeq ($(OS),Linux)
	UID = $(shell id -u)
else
	UID = 1000
endif

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

build: ## Rebuilds all the containers
	U_ID=${UID} docker build -t database ./infrastructure/docker/database/
	U_ID=${UID} docker build . -t php -f ./infrastructure/docker/php/Dockerfile
	U_ID=${UID} docker-compose -f infrastructure/docker-compose.yml build

run: ## Start the containers
	U_ID=${UID} docker-compose -f infrastructure/docker-compose.yml up -d

stop: ## Stop the containers
	U_ID=${UID} docker-compose -f infrastructure/docker-compose.yml down -v

lint:
	docker exec -i php sh -c './vendor/bin/phplint ./'
	docker exec -i php sh -c './vendor/bin/phpstan analyse src tests -c phpstant.neon'
	docker exec -i php sh -c './vendor/bin/psalm'

test: migrations
	docker exec -i php sh -c './vendor/phpunit/phpunit/phpunit'

composer-install:
	docker exec -i php sh -c 'composer install'

composer-validate:
	docker exec -i php sh -c 'composer validate --strict'

migrations:
	docker exec -i database sh -c 'exec mysql -uuser -p"password"  --database="database"' --default-character-set=utf8mb4 < ./infrastructure/docker/database/auth-test-data.sql

.PHONY: build