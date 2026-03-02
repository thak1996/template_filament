# 🚚 FDS Logística e Terceirização

Sistema web para empresa de mudanças e logística, desenvolvido com Laravel e Docker.

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Docker-20.x-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="TailwindCSS">
</p>

## 📋 Funcionalidades

- 🏠 **Página inicial** com informações da empresa
- 📞 **Formulário de contato** com envio de e-mail
- 💰 **Solicitação de orçamento** para mudanças residenciais e comerciais
- 🗺️ **Busca automática de endereço** via CEP (ViaCEP API)
- 📱 **Design responsivo** com TailwindCSS
- ✉️ **Sistema de envio de e-mails** com Mailpit (desenvolvimento)
- 🔧 **Validação de formulários** com JavaScript modular

## 🛠️ Tecnologias

- **Backend:** Laravel 11.x, PHP 8.2+
- **Frontend:** TailwindCSS, JavaScript (ES6+), Vite
- **Database:** MySQL 8.0
- **Containerização:** Docker + Docker Compose
- **Email Testing:** Mailpit
- **Automação:** NPM Scripts

## 📋 Pré-requisitos

Antes de iniciar, certifique-se de ter instalado:

- [Docker](https://docs.docker.com/get-docker/) 20.x ou superior
- [Docker Compose](https://docs.docker.com/compose/install/) 2.x ou superior
- [Node.js](https://nodejs.org/) 18.x ou superior
- [NPM](https://www.npmjs.com/) 9.x ou superior

## 🚀 Instalação e Configuração

### 1. Clone o repositório

```bash
git clone <url-do-repositorio>
cd site-fds
```

### 2. Configure o arquivo .env

Copie o arquivo de exemplo e configure as variáveis:

```bash
cp .env.example .env
```

### 3. Configure as variáveis no .env

Edite o arquivo `.env` com as seguintes configurações **obrigatórias**:

```properties
# === CONFIGURAÇÕES DA APLICAÇÃO ===
APP_NAME="Template Laravel"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8080

# === CONFIGURAÇÕES DO DOCKER ===
APP_PORT=8080
WWWGROUP=1000
WWWUSER=1000

# === CONFIGURAÇÕES DE IDIOMA ===
APP_LOCALE=pt
APP_FALLBACK_LOCALE=pt
APP_FAKER_LOCALE=pt_BR

# === CONFIGURAÇÕES DO BANCO DE DADOS ===
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password

# === CONFIGURAÇÕES DE EMAIL ===
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_PORT_WEB=8025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="e-mail@exemplo.com"
MAIL_FROM_NAME="FDS Logística"
MAIL_COPY_ADDRESS="seu-email@exemplo.com"

# === CONFIGURAÇÕES DO VITE ===
VITE_APP_NAME="${APP_NAME}"
```

> ⚠️ **Importante:** Altere `MAIL_COPY_ADDRESS` para o seu e-mail para receber cópias dos formulários.

### 4. Instale as dependências Node.js

```bash
npm install
```

### 5. Compile os assets

```bash
npm run build
```

### 6. Inicie os containers Docker

```bash
docker-compose up -d
```

### 7. Configure o Laravel

Execute os comandos dentro do container:

```bash
# Instalar dependências PHP
docker-compose exec app composer install

# Gerar chave da aplicação (se necessário)
docker-compose exec app php artisan key:generate

# Executar migrações
docker-compose exec app php artisan migrate

# Limpar cache
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
```

## 🌐 Acessos

Após a instalação, o sistema estará disponível em:

| Serviço | URL | Descrição |
|---------|-----|-----------|
| **Site Principal** | [http://localhost:8080](http://localhost:8080) | Aplicação FDS Logística |
| **Mailpit** | [http://localhost:8025](http://localhost:8025) | Interface para visualizar e-mails enviados |

## 🛠️ Comandos de Desenvolvimento

### NPM Scripts

```bash
# Compilar assets para produção
npm run build

# Compilar assets e observar mudanças
npm run dev

# Observar mudanças nos arquivos JS/CSS
npm run watch
```

### Docker Commands

```bash
# Iniciar containers
docker-compose up -d

# Parar containers
docker-compose down

# Ver logs
docker-compose logs -f

# Executar comandos Laravel
docker-compose exec app php artisan [comando]

# Acessar container Laravel
docker-compose exec app bash
```

### Laravel Artisan

```bash
# Limpar caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Executar migrações
php artisan migrate

# Verificar rotas
php artisan route:list
```

### Filas (Queue) com Docker

```bash
# Subir o worker de filas junto com os demais serviços
docker-compose up -d laravel.worker

# Ver logs do worker
docker-compose logs -f laravel.worker

# Reiniciar worker após deploy/config changes
docker-compose restart laravel.worker
```

> Pré-requisitos: `QUEUE_CONNECTION=database` no `.env` e migrações executadas (`jobs` e `failed_jobs`).

#### Teste rápido da fila

```bash
# Disparar job de teste via CLI
./vendor/bin/sail artisan queue:health-check

# Acompanhar processamento no worker
docker compose logs -f laravel.worker
```

Em ambiente local, também é possível disparar via navegador: `GET /dev/queue-test`.

## 📁 Estrutura do Projeto

```
site-fds/
├── app/
│   ├── Http/Controllers/     # Controllers da aplicação
│   └── Models/              # Modelos Eloquent
├── resources/
│   ├── js/                  # Scripts JavaScript modulares
│   │   ├── app.js          # Arquivo principal
│   │   ├── modals.js       # Funções de modais
│   │   ├── form-validation.js # Validação de formulários
│   │   ├── cep-lookup.js   # Busca de CEP
│   │   └── quote.js        # Funcionalidades de orçamento
│   ├── css/                # Estilos CSS
│   └── views/              # Templates Blade
├── routes/
│   └── web.php             # Rotas da aplicação
├── docker-compose.yml      # Configuração Docker
├── package.json           # Dependências Node.js
└── vite.config.js         # Configuração Vite
```

## 🧪 Testando Funcionalidades

### 1. Formulário de Contato

- Acesse: [http://localhost:8080/contato](http://localhost:8080/contato)
- Preencha e envie o formulário
- Verifique o e-mail em: [http://localhost:8025](http://localhost:8025)

### 2. Solicitação de Orçamento

- Acesse: [http://localhost:8080/orcamento](http://localhost:8080/orcamento)
- Teste a busca automática de CEP
- Envie uma solicitação de orçamento

### 3. Busca de CEP

- Digite qualquer CEP válido (ex: 01310-100)
- O endereço deve ser preenchido automaticamente

## 🔧 Solução de Problemas

### Erro: "Permission denied"

```bash
sudo chown -R $USER:$USER .
chmod -R 755 storage bootstrap/cache
```

### Erro: "Port already in use"

```bash
# Altere APP_PORT no .env para outra porta (ex: 8081)
APP_PORT=8081
```

### Assets não carregam

```bash
# Recompile os assets
npm run build

# Limpe o cache do Laravel
docker-compose exec app php artisan view:clear
```

### E-mails não chegam

- Verifique se o Mailpit está rodando: [http://localhost:8025](http://localhost:8025)
- Confirme as configurações de e-mail no `.env`

## 📝 Variáveis de Ambiente Importantes

| Variável | Descrição | Exemplo |
|----------|-----------|---------|
| `APP_PORT` | Porta da aplicação | `8080` |
| `MAIL_FROM_ADDRESS` | E-mail remetente | `exemplo@exemplo.com` |
| `MAIL_COPY_ADDRESS` | E-mail para receber cópias | `seu-email@exemplo.com` |
| `DB_HOST` | Host do banco (Docker) | `mysql` |
| `MAIL_HOST` | Host do e-mail (Docker) | `mailpit` |

## 🤝 Contribuição

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/nova-funcionalidade`)
3. Commit suas mudanças (`git commit -m 'Adiciona nova funcionalidade'`)
4. Push para a branch (`git push origin feature/nova-funcionalidade`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 👨‍💻 Autor

Desenvolvido para **FDS Logística e Terceirização**

---

📞 **Precisa de ajuda?** Abra uma [issue](../../issues) ou entre em contato!
