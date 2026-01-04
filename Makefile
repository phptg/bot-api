.DEFAULT_GOAL := help

scaffolder: ## Run scaffolder
	docker run \
      --volume .:/project \
      --user $(shell id -u):$(shell id -g) \
      --interactive --tty --rm --init \
      ghcr.io/phptg/scaffolder:latest \
      $(RUN_ARGS)

# Output the help for each task, see https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)
