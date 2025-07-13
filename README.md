# 🛠️ Gerenciador de Viagens

Entrevista tecnica da Genesis

---

## 🚀 Tecnologias

Este projeto foi desenvolvido com as seguintes tecnologias:

- [Laravel 12](https://laravel.com/) (PHP 8.3)
- [PostgreSQL 16](https://www.postgresql.org/)
- [Node.js 24](https://nodejs.org/)
- [Vue.js](https://vuejs.org/) com [Inertia.js](https://inertiajs.com/)
- [PHPUnit](https://phpunit.de/) para testes automatizados
- [Docker](https://www.docker.com/) e `docker-compose` para desenvolvimento e testes locais
- [GitHub Actions](https://github.com/features/actions) para execução de testes automatizados via pull request (ambiente de CI)

---

## 📦 Requisitos

Antes de começar, verifique se você atendeu aos seguintes requisitos:

- PHP >= 8.3
- Composer
- Node.js >= 18 (recomendado: 24)
- PostgreSQL >= 16
- NPM ou Yarn
- Docker e Docker Compose (para uso do ambiente containerizado)

---

## ⚙️ Instalação

### 1. Clone o repositório
```bash
git clone https://github.com/seu-usuario/seu-repositorio.git
cd seu-repositorio
```

### 2. Copie o `.env` de exemplo e configure
```bash
cp .env.example .env
```
> Altere as variáveis de ambiente conforme necessário, especialmente as configurações de banco de dados.

### 3. Suba o ambiente com Docker
```bash
docker-compose up -d
```

### 4. Instale as dependências do backend
```bash
composer install
```

### 5. Instale as dependências do frontend
```bash
npm install
```

### 6. Rode as migrações com seeders
```bash
 php artisan migrate:fresh --seed
```

### 7. Rode o projeto
```bash
composer run dev
```

---

## ✅ Testes

Para executar os testes automatizados com PHPUnit:

```bash
php artisan test
# ou
vendor/bin/phpunit
```

---

## 🧠 Estrutura do Projeto

O projeto segue a arquitetura padrão Laravel com Inertia.js:

```
├── app/
├── bootstrap/
├── database/
├── public/
├── resources/
│   ├── js/         # Código Vue
│   └── views/      # Views Blade (fallback)
├── routes/
│   └── web.php
├── tests/
├── docker-compose.yml
└── .env
```

---

## ⚙️ Integração Contínua

Este projeto utiliza GitHub Actions **apenas para testes automatizados** no ambiente da própria máquina virtual do GitHub quando há um **pull request**.

---

## ✨ Autor

Desenvolvido por [Bruno Winter](https://github.com/DilkerWinter)

---

## 🤖 Tecnologias

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-000?style=for-the-badge&logo=postgresql)
![Vue.js](https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vue.js&logoColor=4FC08D)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![GitHub Actions](https://img.shields.io/badge/GitHub%20Actions-2088FF?style=for-the-badge&logo=github-actions&logoColor=white)