.DEFAULT_GOAL := help
help: ## Print this help
help:
help:
	@grep -hE '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
# @see https://stackoverflow.com/questions/6273608/how-to-pass-argument-to-makefile-from-command-line/6273809#6273809
%: # hack to make arguments with targets - use with $(filter-out $@,$(MAKECMDGOALS))
       @:

.PHONY: help %
.PHONY: install
.PHONY: start stop
.PHONY: test ci phpcs phpmd phpstan phpunit behat

run_php = docker-compose run --rm php

##
## Basic, Simple
## ----------------------
##

install: ## Install all you need to begin the project
	docker run --rm --interactive --tty --volume $(PWD):/app --user $(USER_ID):$(GROUP_ID) composer install

start: ## Start the project to be able to use it
	docker-compose up -d --remove-orphans

stop: ## Stop the project (not uninstall)
	@docker-compose stop

##
## Tests & CI
## ----------------------
##
test: ## Run all tests
test: phpcs phpunit behat

phpcs: ## Execute PHPCS analyses
phpcs: start
	$(run_php) ./vendor/bin/phpcs

phpunit: ## Execute PHP Unit tests
phpunit: start
	$(run_php) ./vendor/bin/phpunit

behat: ## Execute Behat tests
behat: start
	$(run_php) ./vendor/bin/behat
