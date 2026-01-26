FROM serversideup/php:8.2-fpm-nginx

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos do projeto
COPY . .

# Instala dependências do PHP
RUN composer install --no-dev --optimize-autoloader

# Instala dependências do Node e compila o front-end (Vite)
RUN npm install && npm run build

# Corrige permissões para o usuário do container
RUN chown -R webuser:webgroup /var/www/html