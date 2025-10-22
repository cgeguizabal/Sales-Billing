# 💼 Sistema de Ventas e Inventario (Frontend)

Un **Sistema de Gestión de Ventas e Inventario**, construido con **React + Vite**, que se conecta a un **backend en Laravel**.  
Permite gestionar productos, proveedores, compras, ventas y visualizar el movimiento del inventario a través del **Reporte Kardex**.

---

## 🚀 Características

### 🧾 Productos

- Crear, ver y gestionar productos.
- Carga dinámica de la base de datos a través de la API.

### 🏢 Proveedores

- Visualizar todos los proveedores registrados.
- Los datos se obtienen directamente desde la base de datos del backend.

### 🛒 Compras

- Registrar compras a proveedores.
- Seleccionar múltiples productos y cantidades.
- Actualiza automáticamente el inventario mediante la API.

### 💵 Ventas

- Registrar ventas con productos y clientes.
- Descuenta las existencias automáticamente.

### 📊 Reporte Kardex

- Muestra los movimientos de cada producto (compras y ventas).
- Control de inventario detallado por fecha, tipo de transacción y cantidad.
- Resalta los tipos de transacción con colores diferentes.

---

## 🧠 Tecnologías Utilizadas

| Categoría              | Tecnología   |
| ---------------------- | ------------ |
| **Frontend**           | React + Vite |
| **Estilos**            | SCSS Modules |
| **Gráficos**           | Recharts     |
| **Cliente HTTP**       | Axios        |
| **Backend**            | Laravel API  |
| **Gestor de paquetes** | npm          |

---

## 🛠️ Requisitos para Probar la Aplicación

- La aplicación está actualmente en línea y completamente funcional.
- Usuarios de prueba:

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

Privilegios de Admin:

- Administración
- Facturación
- Compras
- Ventas
- Inventarios
- Bancos
- Contabilidad
- Recursos humanos (Administracion de usuarios)

Privilegios de Cashier:

- Facturación
- Ventas

Privilegios de Counter:

- Inventarios
- Bancos
- Contabilidad
- Compras

Privilegios de RH:

- Recursos humanos(Administracion de usuarios)
