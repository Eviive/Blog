FROM php:8.2.3-fpm-alpine

RUN apk update && \
	apk add --no-cache $PHPIZE_DEPS bash git zip unzip libzip-dev

# PHP extensions
RUN docker-php-ext-install opcache pdo_mysql mysqli zip && \
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

CMD composer install && \
	symfony console doctrine:database:create & \
	symfony console doctrine:migrations:migrate && \
	php-fpm --nodaemonize