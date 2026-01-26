FROM serversideup/php:8.2-fpm-nginx

WORKDIR /var/www/html

COPY --chown=webuser:webgroup . .

RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build