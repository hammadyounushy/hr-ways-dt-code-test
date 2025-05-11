# Laravel Translation Management Service

A scalable, secure, and high-performance API-driven translation management service built with Laravel 12 and Docker.

---

## 🚀 Features
- Store translations by locale (`en`, `fr`, `es`, etc.)
- Tag translations (e.g., `web`, `mobile`, `desktop`)
- Full CRUD API for translations
- Search translations by tag, key, or content
- JSON export endpoint for frontend usage
- Token-based API authentication (Laravel Sanctum)
- Factory/Seeder to generate 100k+ test records
- Dockerized environment with Nginx, PHP 8.2, and MySQL 8
- API documentation via Swagger
- Test coverage with PHPUnit (unit + feature)

---

## 📦 Installation

### 1. Clone the Repository

### 2. Start Docker Environment
```bash
docker-compose up -d --build
```

### 3. Install Laravel (inside PHP container)
```bash
docker exec -it php-fpm bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

---

## 👤 Authentication

### Register a new user:
```http
POST /api/register
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "secret123",
  "password_confirmation": "secret123"
}
```

### Login to get token:
```http
POST /api/login
{
  "email": "john@example.com",
  "password": "secret123"
}
```

Use this token as:
```http
Authorization: Bearer your_token_here
```

---

## 🌐 API Endpoints

| Method | Endpoint                     | Description                       |
|--------|------------------------------|-----------------------------------|
| POST   | /api/register                | Register a new user               |
| POST   | /api/login                   | Login and receive token           |
| GET    | /api/translations            | List all translations             |
| POST   | /api/translations            | Create new translation            |
| GET    | /api/translations/{id}       | View translation by ID            |
| PUT    | /api/translations/{id}       | Update translation                |
| DELETE | /api/translations/{id}       | Delete translation                |
| GET    | /api/translations/search     | Search by key/content/tag         |
| GET    | /api/translations/export     | Export all translations as JSON   |

---

## 🧪 Run Tests

```bash
docker exec -it php-fpm bash
php artisan test
```

Feature and unit tests cover:
- Translation CRUD
- Search and Export

---

## 🛠 Seed Database with 100k+ Translations

```bash
php artisan db:seed --class=TranslationSeeder
```

---

## 📘 API Docs (Swagger)

Generate API docs:
```bash
php artisan l5-swagger:generate
```

Then visit:
```
http://localhost/api/documentation
```

---

## 📄 License
MIT
