FROM serversideup/php:8.2-fpm-nginx

USER root

WORKDIR /var/www/html

RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

COPY --chown=www-data:www-data . .

RUN mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache

RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

USER www-data

RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build