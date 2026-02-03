FROM serversideup/php:8.4-fpm-nginx

USER root

WORKDIR /var/www/html

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions intl bcmath zip gd && \
    apt-get update && \
    apt-get install -y supervisor && \
    curl -sL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --chown=www-data:www-data . .

COPY --chown=www-data:www-data docker/worker.conf /etc/supervisor/conf.d/worker.conf

RUN mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache

RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

USER www-data

RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build