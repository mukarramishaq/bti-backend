FROM php:8.0-fpm

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

WORKDIR /var/www/symfony_docker

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony
COPY . .
RUN mv .env.sample .env
RUN composer install
RUN php bin/console doctrine:database:create -n
RUN php bin/console doctrine:migration:migrate -n
RUN php bin/console doctrine:fixtures:load -n
EXPOSE ${PORT:-8000}
CMD symfony server:start --port=${PORT:-8000}