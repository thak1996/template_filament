FROM serversideup/php:8.2-fpm-nginx

WORKDIR /var/www/html

# O TRUQUE ESTÁ AQUI: --chown=webuser:webgroup
# Isso copia os arquivos já dando permissão para o usuário do servidor
COPY --chown=webuser:webgroup . .

# Instala dependências do PHP (agora sem erro de permissão)
RUN composer install --no-dev --optimize-autoloader

# Instala dependências do Node e compila o front-end
RUN npm install && npm run build