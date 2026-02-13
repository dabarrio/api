# CMS API - Sistema de Gestión de Contenido

API RESTful desarrollada en Laravel para un sistema CMS modular que permite la gestión de artículos, categorías y usuarios.

## Características

- **Gestión de Artículos**: CRUD completo con categorización, slugs automáticos y control de estados
- **Gestión de Categorías**: Administración de categorías con validación de integridad referencial
- **Gestión de Usuarios**: Sistema de usuarios con roles y estados
- **Autenticación**: Sistema de autenticación basado en tokens con Laravel Sanctum
- **Arquitectura**: Implementación de patrones Repository, DTO y Dependency Injection

## Requisitos

- PHP 8.1 o superior
- Composer
- MySQL/PostgreSQL/SQLite
- Node.js (opcional, para assets)

## Instalación

1. Clonar el repositorio:
```bash
git clone <repository-url>
cd challenger-api
```

2. Instalar dependencias:
```bash
composer install
```

3. Configurar el archivo de entorno:
```bash
cp .env.example .env
```

4. Configurar la base de datos en `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cms_db
DB_USERNAME=root
DB_PASSWORD=
```

5. Generar la clave de aplicación:
```bash
php artisan key:generate
```

6. Ejecutar las migraciones:
```bash
php artisan migrate
```

7. (Opcional) Poblar la base de datos con datos de prueba:
```bash
php artisan db:seed
```

Esto creará:
- 5 usuarios (admin@cms.com, editor@cms.com, etc.) - password: `password123`
- 7 categorías (Tecnología, Diseño, Programación, etc.)
- 8 artículos de ejemplo con relaciones

8. Iniciar el servidor de desarrollo:
```bash
php artisan serve
```

La API estará disponible en `http://127.0.0.1:8000`

## Probar la API

### Colección de Postman/Bruno

El proyecto incluye una colección completa de Postman con todos los endpoints: `CMS_API.postman_collection.json`

**Para importar en Postman:**
1. Abrir Postman
2. Click en "Import" (esquina superior izquierda)
3. Seleccionar el archivo `CMS_API.postman_collection.json`
4. La colección incluye:
   - ✅ Todos los 19 endpoints organizados por carpetas
   - ✅ Variables de entorno configuradas (`base_url`, `auth_token`)
   - ✅ Script automático para guardar el token después del login
   - ✅ Ejemplos de requests con datos de prueba

**Para usar:**
1. Ejecutar el request `Authentication > Login` con `admin@cms.com` / `password123`
2. El token se guarda automáticamente en la variable `auth_token`
3. Los demás requests ya están configurados para usar el token

**Para importar en Bruno/Thunder Client:**
- Ambos soportan el formato Postman Collection v2.1
- Usar la función "Import" de cada herramienta

## Estructura del Proyecto

```
app/
├── Dtos/                    # Data Transfer Objects
│   ├── ArticleDTO.php
│   ├── CategoryDTO.php
│   └── UserDTO.php
├── Http/
│   ├── Controllers/         # Controladores de la API
│   │   ├── ArticleController.php
│   │   ├── AuthController.php
│   │   ├── CategoryController.php
│   │   └── UserController.php
│   └── Middleware/
│       └── EnsureUserIsActive.php
├── Interfaces/              # Interfaces para Repository Pattern
│   ├── ArticleRepositoryInterface.php
│   └── CategoryRepositoryInterface.php
├── Models/                  # Modelos Eloquent
│   ├── Article.php
│   ├── Category.php
│   └── User.php
└── Repositories/            # Implementación de repositorios
    ├── ArticleRepository.php
    └── CategoryRepository.php
```

## Endpoints de la API

### Autenticación

| Método | Endpoint | Descripción | Autenticación |
|--------|----------|-------------|---------------|
| POST | `/api/register` | Registrar nuevo usuario | No |
| POST | `/api/login` | Iniciar sesión | No |
| POST | `/api/logout` | Cerrar sesión | Sí |
| GET | `/api/me` | Obtener usuario autenticado | Sí |

### Usuarios

| Método | Endpoint | Descripción | Autenticación |
|--------|----------|-------------|---------------|
| GET | `/api/users` | Listar usuarios | Sí |
| POST | `/api/users` | Crear usuario | Sí + Activo |
| GET | `/api/users/{id}` | Ver usuario | Sí |
| PUT | `/api/users/{id}` | Actualizar usuario | Sí + Activo |
| DELETE | `/api/users/{id}` | Eliminar usuario | Sí + Activo |

### Artículos

| Método | Endpoint | Descripción | Autenticación |
|--------|----------|-------------|---------------|
| GET | `/api/articles` | Listar artículos | Sí |
| POST | `/api/articles` | Crear artículo | Sí + Activo |
| GET | `/api/articles/{id}` | Ver artículo | Sí |
| PUT | `/api/articles/{id}` | Actualizar artículo | Sí + Activo |
| DELETE | `/api/articles/{id}` | Eliminar artículo | Sí + Activo |

### Categorías

| Método | Endpoint | Descripción | Autenticación |
|--------|----------|-------------|---------------|
| GET | `/api/categories` | Listar categorías | Sí |
| POST | `/api/categories` | Crear categoría | Sí + Activo |
| GET | `/api/categories/{id}` | Ver categoría | Sí |
| PUT | `/api/categories/{id}` | Actualizar categoría | Sí + Activo |
| DELETE | `/api/categories/{id}` | Eliminar categoría | Sí + Activo |

## Uso

> **Nota:** Si ejecutaste los seeders, ya tienes usuarios de prueba disponibles:
> - Admin: `admin@cms.com` / `password123`
> - Editor: `editor@cms.com` / `password123`
> - Otros usuarios: `juan@cms.com`, `maria@cms.com` / `password123`

### 1. Registrar un usuario

```bash
POST /api/register
Content-Type: application/json

{
  "name": "Juan Pérez",
  "email": "juan@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "role": "editor"
}
```

**Respuesta:**
```json
{
  "message": "Usuario registrado exitosamente",
  "user": {
    "id": 1,
    "name": "Juan Pérez",
    "email": "juan@example.com",
    "role": "editor",
    "is_active": true
  },
  "access_token": "1|xxxxxxxxxxxxxxxxxxxx",
  "token_type": "Bearer"
}
```

### 2. Iniciar sesión

```bash
POST /api/login
Content-Type: application/json

{
  "email": "juan@example.com",
  "password": "password123"
}
```

### 3. Crear un artículo

```bash
POST /api/articles
Authorization: Bearer {tu_token}
Content-Type: application/json

{
  "title": "Mi primer artículo",
  "content": "Este es el contenido del artículo...",
  "status": "published",
  "published_at": "2026-02-13 18:30:00",
  "author_id": 1,
  "category_ids": [1, 2]
}
```

**Nota:** El slug se genera automáticamente desde el título.

### 4. Crear una categoría

```bash
POST /api/categories
Authorization: Bearer {tu_token}
Content-Type: application/json

{
  "name": "Tecnología",
  "description": "Artículos sobre tecnología",
  "is_active": true
}
```

## Validaciones de Negocio

### Artículos
- El **slug se genera automáticamente** desde el título
- Si el slug ya existe, se agrega numeración incremental (ej: `mi-articulo-2`)
- Solo usuarios **activos** pueden crear o editar artículos
- El estado debe ser: `draft`, `published` o `archived`

### Categorías
- No se pueden eliminar categorías que tienen artículos asociados
- El nombre debe ser único

### Usuarios
- Solo usuarios **activos** pueden realizar operaciones de escritura
- Los roles disponibles son: `admin` y `editor`
- El email debe ser único

## Patrones de Diseño Implementados

### Repository Pattern
Abstracción de la lógica de acceso a datos:
- `ArticleRepositoryInterface` / `ArticleRepository`
- `CategoryRepositoryInterface` / `CategoryRepository`

### DTO Pattern
Objetos inmutables para transferencia de datos:
- `ArticleDTO`
- `CategoryDTO`
- `UserDTO`

### Dependency Injection
Inyección de dependencias a través de interfaces registradas en `AppServiceProvider`.

## Códigos de Estado HTTP

- `200 OK`: Operación exitosa
- `201 Created`: Recurso creado exitosamente
- `400 Bad Request`: Error en la validación de datos
- `403 Forbidden`: Usuario inactivo o sin permisos
- `404 Not Found`: Recurso no encontrado

## Comandos Útiles

```bash
# Ver todas las rutas
php artisan route:list

# Limpiar caché
php artisan cache:clear
php artisan route:clear
php artisan config:clear

# Seeders
php artisan db:seed                    # Ejecutar todos los seeders
php artisan db:seed --class=UserSeeder # Ejecutar seeder específico
php artisan migrate:fresh --seed       # Resetear DB y ejecutar seeders

# Ejecutar tests (si están implementados)
php artisan test

# Crear un usuario desde tinker
php artisan tinker
>>> User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('password'), 'role' => 'admin', 'is_active' => true]);
```

## Tecnologías Utilizadas

- **Laravel 11**: Framework PHP
- **Laravel Sanctum**: Autenticación basada en tokens
- **MySQL**: Base de datos relacional
- **PHP 8.3**: Lenguaje de programación

## Licencia

Este proyecto fue desarrollado como parte de un challenge técnico.
