# Contexto del Proyecto: F1 Hexa API 🏎️

Este proyecto es una implementación de **Arquitectura Hexagonal (por capas)** sobre el framework **Laravel 11**, utilizando **Sanctum** para autenticación.

## 🏗️ Estructura del Código (`_src/`)

El código principal de la lógica de negocio y la infraestructura personalizada reside en la carpeta `_src/`, organizada así:

- **`L1_domain/`**: Entidades e interfaces de repositorios. (Ej: `AuthRepositoryInterface`).
- **`L2_application/`**: Casos de uso y DTOs. (Ej: `LoginUseCase`, `LoginDto`).
- **`L3_infrastructure/`**: Controladores, Modelos Eloquent, Persistencia y Rutas.
    - **Modelos**: Se utiliza el modelo `my_user` en lugar del `User` por defecto.
    - **Rutas**: Definidas en `L3_infrastructure/Routes/my_api.php`.

## 🔑 Autenticación (Sanctum)

- **Tabla de Usuarios**: `my_user` (definida en la última migración).
- **Campos**: `username` (para login), `email`, `password`.
- **Repositorio**: `EloquentAuth` maneja la lógica de login/logout y generación de tokens.
- **Configuración**: `config/auth.php` ha sido modificado para usar `yangpimpollo\L3_infrastructure\Model\my_user::class`.

## 🛠️ Comandos Útiles para continuar

### Instalación y Base de Datos
```bash
composer install
php artisan migrate:fresh --seed
```
*El seeder crea un usuario por defecto: `username: string`, `password: string`.*

### Testing
Se han implementado tests de integración para validar el flujo completo de Auth:
```bash
php artisan test tests/Feature/AuthTest.php
```

### Documentación API
- **Scramble** está configurado para la documentación automática.
- URL: `/docs/api` (incluye soporte para Bearer Tokens).

## 📌 Estado Actual
- Login y Logout funcionales bajo arquitectura hexagonal.
- Repositorio `EloquentAuth` vinculado via `myServiceProvider`.
- Rutas protegidas por middleware `auth:sanctum`.

---
*Nota para Gemini: Al retomar, verifica siempre que los bindings en `myServiceProvider` coincidan con las interfaces en `L1`.*
