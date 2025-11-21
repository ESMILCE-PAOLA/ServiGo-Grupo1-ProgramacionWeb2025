# ServiGo – Estructura Base (PHP + JS)

Esta estructura organiza **frontend** y **backend** sin framework (XAMPP/Apache/PHP).
Incluye sesiones, endpoints mínimos, y un esquema de BD con triggers de auditoría.

## Requisitos
- PHP 8.2+ con PDO MySQL/MariaDB
- Apache (mod_rewrite activado)
- MariaDB 10.4+
- XAMPP recomendado

## Estructura
```
ServiGo/
├─ assets/          # CSS/JS/Imgs
├─ includes/        # Fragmentos reutilizables y helpers de sesión/autorización
├─ backend/         # Conexión BD y utilidades
│  └─ api/          # Endpoints REST (auth, solicitudes, presupuestos, chat, usuarios)
├─ views/           # Vistas por rol (administrador, cliente, profesional, visitante)
├─ database/        # Scripts .sql
├─ .htaccess        # Reescritura básica (opcional)
├─ config.php
└─ index.php
```

## Puesta en marcha (local)
1. Crear BD e importar `database/servigo.sql`.
2. Copiar `.env.sample` a `.env` (o editar `config.php`) y configurar credenciales.
3. Colocar el proyecto en `htdocs/ServiGo/` (o configurar VirtualHost).
4. Navegar a `http://localhost/ServiGo/`.
5. Usuario demo: `admin@servigo.test` / `admin123`.

## Notas
- Endpoints devuelven JSON; las vistas invocan por `fetch`.
- Se fuerza un presupuesto por profesional por solicitud (comparan varios de distintos profesionales).
- Se incluye traza de auditoría y triggers `updated_at`.
