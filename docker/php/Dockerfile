FROM php:8.2.3-fpm-alpine

RUN apk update && \
	apk add --no-cache $PHPIZE_DEPS bash git zip unzip libzip-dev icu-dev

# PHP extensions
RUN docker-php-ext-configure intl && \
	docker-php-ext-install opcache pdo_mysql mysqli zip intl && \
	docker-php-ext-enable opcache
#

WORKDIR /var/www/blog

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#

# Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony
#

RUN rm -rf /var/cache/apk/*

CMD rm -rf public/build public/bundles && \
	composer install && \
	php-fpm --nodaemonize
