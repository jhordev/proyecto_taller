# Sistema POS — Taller UCSS

Sistema de punto de venta (POS) desarrollado con Laravel como proyecto de taller universitario. Permite gestionar empleados, proveedores, clientes, productos, inventario y ventas, con un dashboard de métricas en tiempo real.

---

## Tecnologías

- **Backend:** Laravel 12 (PHP 8.2+)
- **Base de datos:** MySQL 8.0
- **Frontend:** Blade + Vite + ApexCharts
- **Autenticación:** Laravel Auth con middleware de sesión
- **Contenedores:** Docker (opcional)

---

## Módulos del sistema

| Módulo | Descripción |
|---|---|
| Empleados | CRUD con validaciones y diseño plano |
| Proveedores | Listado con búsqueda y paginación |
| Clientes | CRUD con estado activo/inactivo |
| Categorías | Clasificación de productos |
| Unidades de medida | Unidades para el inventario |
| Productos | CRUD con gestión de imágenes y sincronización de stock |
| Inventario | Registro de movimientos con actualización automática de stock |
| Ventas | Punto de venta y comprobantes |
| Dashboard | KPIs, gráficos interactivos y tabla de stock crítico |

---

## Requisitos previos

- PHP >= 8.2
- Composer
- Node.js >= 18 y npm
- MySQL 8.0 (vía Docker, XAMPP o MySQL Workbench)

---

## Opción 1 — Docker (recomendado)

Solo necesitas tener Docker Desktop instalado.

### 1. Levantar la base de datos

```bash
docker compose up -d
```

Esto levanta un contenedor MySQL 8.0 con:

| Parámetro | Valor |
|---|---|
| Host | `127.0.0.1` |
| Puerto | `3301` |
| Base de datos | `laravel` |
| Usuario | `root` |
| Contraseña | `123456` |

### 2. Instalar dependencias

```bash
composer install
npm install
```

### 3. Configurar el entorno

```bash
cp .env.example .env
php artisan key:generate
```

Editar el `.env` con la conexión MySQL del contenedor:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3301
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=123456
```

### 4. Ejecutar migraciones y seeder

```bash
php artisan migrate --seed
```

### 5. Compilar assets y levantar el servidor

```bash
npm run build
php artisan serve
```

El sistema queda disponible en [http://localhost:8000](http://localhost:8000).

---

## Opción 2 — XAMPP

### 1. Iniciar XAMPP

Abre el panel de control de XAMPP y activa los módulos **Apache** y **MySQL**.

### 2. Crear la base de datos

Abre [http://localhost/phpmyadmin](http://localhost/phpmyadmin) y crea una base de datos llamada `proyecto_taller`.

### 3. Instalar dependencias

```bash
composer install
npm install
```

### 4. Configurar el entorno

```bash
cp .env.example .env
php artisan key:generate
```

Editar el `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=proyecto_taller
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Ejecutar migraciones y seeder

```bash
php artisan migrate --seed
```

### 6. Compilar assets y levantar el servidor

```bash
npm run build
php artisan serve
```

El sistema queda disponible en [http://localhost:8000](http://localhost:8000).

---

## Opción 3 — MySQL Workbench (BD externa)

Esta opción es útil si ya tienes MySQL instalado de forma nativa y lo gestionas con MySQL Workbench.

### 1. Crear la base de datos desde Workbench

Abre MySQL Workbench, conéctate a tu servidor local y ejecuta:

```sql
CREATE DATABASE proyecto_taller CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Instalar dependencias

```bash
composer install
npm install
```

### 3. Configurar el entorno

```bash
cp .env.example .env
php artisan key:generate
```

Editar el `.env` con los datos de tu instalación MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=proyecto_taller
DB_USERNAME=root
DB_PASSWORD=tu_contraseña
```

### 4. Ejecutar migraciones y seeder

```bash
php artisan migrate --seed
```

### 5. Compilar assets y levantar el servidor

```bash
npm run build
php artisan serve
```

El sistema queda disponible en [http://localhost:8000](http://localhost:8000).

---

## Credenciales por defecto

El seeder crea un usuario administrador listo para usar:

| Campo | Valor |
|---|---|
| Correo | `admin@admin.com` |
| Contraseña | `admin123` |

---

## Estructura de la base de datos

Las migraciones crean las siguientes tablas y objetos en orden:

```
users, cache, jobs
empleados
proveedores
clientes
unidades_medida
categorias
productos               ← trigger: sincroniza estado por stock
movimientos_inventario  ← trigger: actualiza stock al registrar movimiento
ventas
detalle_ventas
vistas SQL del dashboard (v_ventas_diarias, v_ventas_mensuales,
                          v_productos_mas_vendidos,
                          v_ventas_por_metodo_pago,
                          v_stock_critico)
```

---

## Comandos útiles

```bash
# Levantar contenedor MySQL (Docker)
docker compose up -d

# Detener contenedor MySQL (Docker)
docker compose down

# Revertir y volver a ejecutar todas las migraciones
php artisan migrate:fresh --seed

# Compilar assets en modo desarrollo con hot reload
npm run dev

# Ver rutas registradas
php artisan route:list
```

---

## Equipo

Proyecto desarrollado como trabajo de taller universitario — UCSS.
