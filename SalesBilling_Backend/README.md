# 📚 Sistema de Inventario de Ventas y Facturación

**Stack Tecnológico:** Laravel, Laravel Sanctum, MySQL, Postman, Railway

**Colección de Postman:** Abrir en Postman : https://.postman.co/workspace/My-Workspace~fabd6659-33f8-4926-8597-842371a54b83/collection/41282147-20b34b0f-8c29-41be-9a79-99e5b16ca4dd?action=share&creator=41282147 ✅

Aplicación creada para gestionar el inventario, ventas y facturación, operada por Administradores, Cajeros y Contadores, quienes son los usuarios con acceso a la plataforma. 📖✨

---

## 🚀 Funcionalidades

-   🔑 Autenticación de usuarios mediante Bearer Token
-   📝 Registro de usuarios
-   🔓 Inicio y cierre de sesión
-   👥 CRUD completo de Usuarios (solo Administrador y RH)
-   📦 CRUD de Productos (Administradores, Cajeros, Contadores)
-   🏢 CRUD de Categorías (Administradores, Cajeros, Contadores)
-   🏭 CRUD de Proveedores (Administradores y Contadores)
-   🛒 Registro de Compras (Administradores y Contadores)
-   👤 CRUD de Clientes (Administradores y Cajeros)
-   💰 Gestión de Ventas y obtención de datos de ventas (Administradores y Cajeros)
-   📊 Reportes de Inventario y transacciones de productos (Administradores y Contadores)
-   🧾 Generación de facturas en PDF de cada venta (Administradores, Cajeros, Contadores)

---

## 🔐 Roles y sus privilegios

Privilegios de Admin:

-   Administración
-   Facturación
-   Compras
-   Ventas
-   Inventarios
-   Bancos
-   Contabilidad
-   Recursos humanos (Administracion de usuarios)

Privilegios de Cashier:

-   Facturación
-   Ventas

Privilegios de Counter:

-   Inventarios
-   Bancos
-   Contabilidad
-   Compras

Privilegios de RH:

-   Recursos humanos(Administracion de usuarios)

## 👉 URL Base

https://sales-billing-production.up.railway.app/api/

## 🔐 Autenticación

| Método | Endpoint     | Descripción       |
| ------ | ------------ | ----------------- |
| POST   | /v1/register | Registrar usuario |
| POST   | /v1/login    | Iniciar sesión    |
| POST   | /v1/logout   | Cerrar sesión     |

---

## 👥 Gestión de Usuarios

| Método | Endpoint       | Descripción        | Rol Requerido |
| ------ | -------------- | ------------------ | ------------- |
| GET    | /v1/users      | Listar usuarios    | Admin/RH      |
| GET    | /v1/users/{id} | Ver usuario        | Admin/RH      |
| PUT    | /v1/users/{id} | Actualizar usuario | Admin/RH      |
| DELETE | /v1/users/{id} | Eliminar usuario   | Admin/RH      |

---

## 📦 Gestión de Productos

| Método | Endpoint          | Descripción       | Rol Requerido         |
| ------ | ----------------- | ----------------- | --------------------- |
| GET    | /v1/products      | Listar productos  | Admin/Cajero/Contador |
| GET    | /v1/products/{id} | Ver producto      | Admin/Cajero/Contador |
| POST   | /v1/products      | Crear producto    | Admin                 |
| PUT    | /v1/products/{id} | Actualizar        | Admin                 |
| DELETE | /v1/products/{id} | Eliminar producto | Admin                 |

---

## 📦 Gestión de Productos

| Método | Endpoint          | Descripción       | Rol Requerido         |
| ------ | ----------------- | ----------------- | --------------------- |
| GET    | /v1/products      | Listar productos  | Admin/Cajero/Contador |
| GET    | /v1/products/{id} | Ver producto      | Admin/Cajero/Contador |
| POST   | /v1/products      | Crear producto    | Admin                 |
| PUT    | /v1/products/{id} | Actualizar        | Admin                 |
| DELETE | /v1/products/{id} | Eliminar producto | Admin                 |

---

## 🏢 Gestión de Categorías

| Método | Endpoint            | Descripción     | Rol Requerido         |
| ------ | ------------------- | --------------- | --------------------- |
| POST   | /v1/categories      | Crear categoría | Admin/Cajero/Contador |
| GET    | /v1/categories      | Listar          | Admin/Cajero/Contador |
| GET    | /v1/categories/{id} | Ver categoría   | Admin/Cajero/Contador |
| PUT    | /v1/categories/{id} | Actualizar      | Admin/Cajero/Contador |
| DELETE | /v1/categories/{id} | Eliminar        | Admin/Cajero/Contador |

---

## 🏭 Gestión de Proveedores

| Método | Endpoint           | Descripción        | Rol Requerido  |
| ------ | ------------------ | ------------------ | -------------- |
| POST   | /v1/suppliers      | Crear proveedor    | Admin/Contador |
| GET    | /v1/suppliers      | Listar proveedores | Admin/Contador |
| GET    | /v1/suppliers/{id} | Ver proveedor      | Admin/Contador |
| PUT    | /v1/suppliers/{id} | Actualizar         | Admin/Contador |
| DELETE | /v1/suppliers/{id} | Eliminar           | Admin/Contador |

---

## 🛒 Gestión de Compras

| Método | Endpoint      | Descripción      | Rol Requerido  |
| ------ | ------------- | ---------------- | -------------- |
| POST   | /v1/purchases | Registrar compra | Admin/Contador |
| GET    | /v1/purchases | Listar compras   | Admin/Contador |

---

## 👤 Gestión de Clientes

| Método | Endpoint           | Descripción     | Rol Requerido |
| ------ | ------------------ | --------------- | ------------- |
| GET    | /v1/customers      | Listar clientes | Admin/Cajero  |
| POST   | /v1/customers      | Crear cliente   | Admin/Cajero  |
| GET    | /v1/customers/{id} | Ver cliente     | Admin/Cajero  |
| PUT    | /v1/customers/{id} | Actualizar      | Admin         |
| DELETE | /v1/customers/{id} | Eliminar        | Admin         |

---

## 💰 Gestión de Ventas

| Método | Endpoint               | Descripción         | Rol Requerido         |
| ------ | ---------------------- | ------------------- | --------------------- |
| POST   | /v1/sales              | Registrar venta     | Admin/Cajero          |
| GET    | /v1/sales              | Listar ventas       | Admin/Cajero          |
| GET    | /v1/sales/{id}         | Ver venta           | Admin/Cajero          |
| GET    | /v1/sales/{id}/invoice | Generar factura PDF | Admin/Cajero/Contador |

---

## 📊 Reportes de Inventario

| Método | Endpoint                  | Descripción                 | Rol Requerido  |
| ------ | ------------------------- | --------------------------- | -------------- |
| GET    | /v1/inventoryTransactions | Transacciones de inventario | Admin/Contador |

## 🛠️ Requisitos para Probar la Aplicación

-   La aplicación está actualmente en línea y completamente funcional.
-   Usuarios de prueba:

```json
//Admin
{
    "email": "guillermo@example.com",
    "password": "secret123"
}

//RH
{
    "email": "fernando@example.com",
    "password": "secret12345"
}

//Cashier
{
    "email": "ivonne@example.com",
    "password": "secret123456"
}

//Counter
{
    "email": "joshua@example.com",
    "password": "secret1234567"
}


```

---

Si deseas ejecutarla de forma local, asegúrate de que tu computadora tenga los siguientes requisitos:

-   PHP 8.x
-   Composer
-   MySQL ejecutado por XAMPP u otra herramienta
-   Apache

---

⚙️ Configuración del Entorno

Para conectar la API a tu propia base de datos, simplemente llena el archivo .env con tus credenciales locales. Sin este paso, la API no podrá conectarse a la base de datos.

Ejemplo de configuración:
DB_CONNECTION=mysql  
DB_HOST=127.0.0.1  
DB_PORT=3306  
DB_DATABASE=your_database_name  
DB_USERNAME=your_database_user  
DB_PASSWORD=your_database_password

---

🚀 Instalación Local
⚠️ Asegúrate de que MySQL esté corriendo localmente (por ejemplo, con XAMPP) antes de iniciar.

Clona el repositorio
Abre tu terminal en la raíz del proyecto

Ejecuta los siguientes comandos:

```bash
composer install      # ⚙️  Instalar dependencias de PHP
cp .env.example .env  # 📝 Crear el archivo de configuración .env
php artisan serve     # 🚀 Iniciar el servidor local

```
