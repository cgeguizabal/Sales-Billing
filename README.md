# 💼 Sistema de Ventas, Inventario y Facturación

Un **Sistema Integral de Ventas, Inventario y Facturación** desarrollado con **React (frontend)** y **Laravel (backend)**, utilizando **MySQL** como sistema de gestión de base de datos.  
El sistema permite gestionar productos, categorías, proveedores, compras, ventas, usuarios y reportes de inventario (Kardex).

---

## 🌐 Sistema en Línea

**Sistema en línea:** [https://sales-billing-theta.vercel.app/](https://sales-billing-theta.vercel.app/)

El desarrollo de este sistema se realizó utilizando **React** para el front-end y **Laravel** para el back-end, con **SQL** como sistema de gestión de la base de datos.  
El sistema se encuentra completamente funcional para su uso. En la interfaz están habilitadas únicamente las funcionalidades solicitadas; sin embargo, en el **back-end** puede observarse que la gestión de la base de datos está completamente implementada.  
En el mismo repositorio se incluyen los **scripts SQL** utilizados para la creación de las tablas, así como el **diseño del diagrama entidad-relación (E-R)** correspondiente a la estructura de la base de datos.

---

## 🚀 Características Principales

### 🧾 Productos

- Crear, ver y gestionar productos.
- Integración completa con la base de datos mediante la API.

### 🏢 Proveedores

- Ver y registrar proveedores directamente desde la interfaz.

### 🏷️ Categorías

- Gestión completa de categorías con validación de duplicados.

### 🛒 Compras

- Registrar compras con múltiples productos y cantidades.
- Actualiza automáticamente el inventario.

### 💰 Ventas

- Registrar ventas y generar facturas en PDF.
- Reduce el inventario automáticamente al vender.

### 📊 Reporte Kardex

- Muestra todas las transacciones de inventario (compras y ventas).
- Indica el tipo de transacción, cantidad, producto y fecha.
- Colores diferenciados para tipos de transacción.

### 👥 Usuarios y Roles

- Sistema de autenticación con **Laravel Sanctum**.
- Control de acceso según el rol del usuario.
- Administración de usuarios (solo para el rol RH o Admin).

---

## 🧠 Tecnologías Utilizadas

| Categoría               | Tecnología      |
| ----------------------- | --------------- |
| **Frontend**            | React + Vite    |
| **Estilos**             | SCSS Modules    |
| **Cliente HTTP**        | Axios           |
| **Backend**             | Laravel 11      |
| **Autenticación**       | Laravel Sanctum |
| **Base de datos**       | MySQL           |
| **Servidor**            | Railway         |
| **Despliegue Frontend** | Vercel          |

---

## 🧩 Roles y Privilegios

### 👑 Administrador

- Administración total del sistema.
- Gestión de usuarios, ventas, compras, inventarios y bancos.

### 💼 Contador

- Acceso a módulos de inventarios, bancos, contabilidad y compras.

### 💳 Cajero

- Facturación y ventas.

### 👥 Recursos Humanos (RH)

- Gestión y administración de usuarios.

---

## 🔐 Usuarios de Prueba

```json
// Admin
{
  "email": "guillermo@example.com",
  "password": "secret123"
}

// RH
{
  "email": "fernando@example.com",
  "password": "secret12345"
}

// Cashier
{
  "email": "ivonne@example.com",
  "password": "secret123456"
}

// Counter
{
  "email": "joshua@example.com",
  "password": "secret1234567"
}
```
