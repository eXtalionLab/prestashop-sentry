
module_name=extsentry
module_dir=$(CURDIR)/../$(module_name)
build_dir=$(module_name)
version=$(shell grep '\->version =' $(module_name).php | grep -oe "[0-9]\+\.[0-9]\+\.[0-9]\+")

phpcs:
	vendor/bin/phpcs

phpcs-fix:
	vendor/bin/phpcbf

phpmd:
	#phpmd config,controllers,sql,src,upgrade,views,$(module_name).php text phpmd.xml.dist
	phpmd config,sql,src,upgrade,views,$(module_name).php text phpmd.xml.dist

php-cs-fixer:
	php vendor/bin/php-cs-fixer fix

composer-dev:
	composer install --prefer-dist --no-progress --no-interaction
	composer dump-autoload

composer-prod:
	composer install --prefer-dist --no-progress --no-dev --no-scripts
	composer dump-autoload --classmap-authoritative --no-dev

autoindex: composer-dev
	vendor/bin/autoindex prestashop:add:index $(build_dir)

clean:
	rm -rf $(build_dir)

build: composer-prod
	$(MAKE) clean
	mkdir -p $(build_dir)
	rsync -a \
		--exclude=*.swp \
		--exclude=.arcconfig \
		--exclude=.git \
		--exclude=.gitignore \
		--exclude=.php-cs-fixer.* \
		--exclude=.phpcs* \
		--exclude=composer.* \
		--exclude=config.xml \
		--exclude=phpcs.xml* \
		--exclude=phpmd.xml* \
		--exclude=phpstan.neon \
		--exclude=$(build_dir) \
		--exclude=$(module_name).zip \
		--exclude=Makefile \
		--exclude=sentry.json \
		$(module_dir)/ $(build_dir)

archive:
	rm -rf $(module_name).zip
	zip $(module_name).zip $(build_dir) -r

release: build autoindex archive clean

release-git:
	@echo "Version: ${version}"
	git add $(module_name).php
	git commit -m "release: $(version)"
	git tag -a $(version) -m "release: $(version)"
