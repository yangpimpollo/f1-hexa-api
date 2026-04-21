# Contexto del Proyecto: F1 Hexa API 🏎️

Este proyecto es una implementación de **Arquitectura Hexagonal (por capas)** sobre el framework **Laravel 11**, utilizando **Sanctum** para autenticación y **PostgreSQL** para persistencia de alto rendimiento.

## 🏗️ Estructura del Código (`_src/`)

Organizado en tres capas puras:
- **`L1_domain/`**: Entidades, Value Objects (Dni, Phone), Interfaces de Repositorios y Excepciones de Dominio.
- **`L2_application/`**: Casos de uso y DTOs (Data Transfer Objects).
- **`L3_infrastructure/`**: Controladores, Persistencia (SQL Puro), Proveedores y Rutas.

## 🔑 Módulos Implementados

### 1. Autenticación (Sanctum)
- **Tabla**: `my_users` (vinculada a `stores`).
- **Lógica**: Login/Logout mediante `EloquentAuth`.
- **Seguridad**: Tokens Bearer gestionados por Sanctum.

### 2. Clientes (Customers)
- **Validación**: Uso de Value Objects para DNI (8 dígitos) y Phone (9 dígitos, empieza con 9).
- **Excepciones**: Manejo global de errores de dominio en `bootstrap/app.php`.
- **Persistencia**: `EloquentCustomer` usando SQL directo.

### 3. Productos y Búsqueda
- **Esquema**: `categories` -> `products` <- `inventories` -> `stores`.
- **Búsqueda Contextual**: Los empleados solo pueden buscar productos con stock en su propia tienda (`SearchController`).
- **Rendimiento**: Búsquedas con `ILIKE` en PostgreSQL para máxima velocidad.

### 4. Ventas (Orders)
- **Agregado**: La entidad `Order` gestiona una lista de `OrderItem`.
- **Seguridad de Precios**: Los precios se validan en el servidor (L2), ignorando el precio enviado por el cliente.
- **Transaccionalidad**:
    - **Venta**: Inserta orden + resta stock (falla si no hay cantidad suficiente).
    - **Cancelación**: Elimina orden + devuelve stock automáticamente a la tienda.

## 🛠️ Comandos y Base de Datos

### Inicialización Completa
```bash
php artisan migrate:fresh --seed
```
*El `InitSeeder` crea una tienda por defecto (`AA-AAA-00`), un usuario administrador, categorías, productos y llena el inventario con stock aleatorio.*

### Endpoints Principales (Protegidos)
- `GET /api/products/search?patito=...`: Búsqueda de productos en la tienda del usuario.
- `POST /api/orders`: Registro de venta.
- `GET /api/orders/index`: Historial de ventas de la tienda.
- `DELETE /api/orders/delete?order_id=...`: Cancelación de venta y retorno de stock.

---
*Nota para Gemini: Al retomar, prioriza el uso de SQL puro en la capa L3 y respeta siempre los Value Objects definidos en L1 para mantener la integridad del dominio.*
