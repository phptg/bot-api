.DEFAULT_GOAL := help

zizmor: ARGS ?= --persona auditor --color always
zizmor: ## Run zizmor security audit (1.25.2)
	docker run \
      --volume .:/project:ro \
      --rm \
      ghcr.io/zizmorcore/zizmor@sha256:14ea7f5cc7c67933394a35b5a38a277397818d232602635edb2010b313afb110 \
      $(ARGS) /project

scaffolder: ## Run scaffolder
	docker run \
      --volume .:/project \
      --user $(shell id -u):$(shell id -g) \
      --interactive --tty --rm --init \
      ghcr.io/phptg/scaffolder@sha256:c732b78955ce8cfc21e9bb86c6cbcd3d46147ceed07894b71dcfad7fa317e14e \
      $(ARGS)

# Output the help for each task, see https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)
