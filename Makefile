init: docker-down-clear docker-build docker-up app-init
validate: cs-check psalm rector-check tests

docker-up:
	docker compose up -d

docker-build:
	docker compose build

docker-down:
	docker compose down --remove-orphans

docker-down-clear:
	docker compose down -v --remove-orphans

app-init: app-clear-var-cache composer-install

app-clear-var-cache:
	docker compose run --rm personal-notifier-php rm -rf /var/www/app/var/cache

psalm:
	docker compose run --rm personal-notifier-php composer psalm

cs-check:
	docker compose run --rm personal-notifier-php composer cs-check

cs-fix:
	docker compose run --rm personal-notifier-php composer cs-fix

rector-check:
	docker compose run --rm personal-notifier-php composer rector-check

rector-fix:
	docker compose run --rm personal-notifier-php composer rector-fix
	docker compose run --rm personal-notifier-php composer cs-fix
	make setown

tests:
	docker compose run --rm personal-notifier-php composer phpunit

bash:
	docker compose exec php bash

composer-install:
	docker compose run --rm -it personal-notifier-php composer install

composer-update:
	docker compose run --rm -it personal-notifier-php composer update

composer-require:
	docker compose run --rm -it personal-notifier-php composer req $(filter-out $@,$(MAKECMDGOALS)) --with-all-dependencies

composer-remove:
	docker compose run --rm -it personal-notifier-php composer rem $(filter-out $@,$(MAKECMDGOALS))

composer-check:
	docker compose run --rm personal-notifier-php composer outdated

command:
	docker compose run --rm -it personal-notifier-php $(filter-out $@,$(MAKECMDGOALS))

console:
	docker compose run --rm -it personal-notifier-php php bin/console $(filter-out $@,$(MAKECMDGOALS))

setown:
	sudo chown -R `id -u`:`id -g` app
