# Frontend – ServiGo

Este directorio contiene las **vistas del sistema ServiGo**, organizadas por **rol**.  
Cada carpeta incluye las pantallas principales en formato **HTML**, con soporte en **CSS** y **JavaScript**.

## Estructura actual
## 📋 Descripción por módulo

### 👤 Visitante
- **index.html** → Página principal para usuarios no registrados.
  - Puede visualizar profesionales destacados.
  - Al intentar ver más detalles o contactar, se solicita iniciar sesión.

### 🧑‍💼 Cliente
- **index.html** → Catálogo de profesionales filtrable (servicio, localidad, orden).
- **nueva_solicitud.html** → Formulario para enviar una solicitud a un profesional.
- **solicitud_cliente.html** → Listado de solicitudes enviadas por el cliente.
  - Incluye estados: Pendiente, En curso, Finalizado.
  - Acceso a chat de la solicitud.
  - Posibilidad de calificar al finalizar.
- **perfil.html** → Visualización de datos del cliente.

### 🛠 Profesional
- **index.html** → Vista inicial del profesional con acceso a su perfil y solicitudes.
- **solicitudes-profesional.html** →  
  - Listado de solicitudes recibidas (tabla).  
  - Filtros: rango de fechas, localidad (lista desplegable), estado.  
  - Acción “Ver mensaje” redirige a `detalle_solicitud.html`.  
- **detalle_solicitud.html** →  
  - Visualiza el mensaje del cliente.  
  - Acciones: Aceptar, Rechazar, Crear presupuesto.  
- **crear_presupuesto.html** →  
  - Formulario dinámico para armar un presupuesto.  
  - Permite agregar/eliminar filas y calcular subtotales y total.  
  - Envío simulado con modal de confirmación.  
- **perfil_profesional.html** →  
  - Perfil del profesional.  
  - El bloque **Acciones de administrador** (Bloquear/Desbloquear) se muestra **solo si la vista se abre desde rol Administrador**.  
  - El profesional no puede bloquearse a sí mismo.

### 🛡 Administrador
- **index.html** → Panel de inicio con accesos a todas las gestiones.  
- **denuncias.html** → Administración de denuncias realizadas por clientes.  
- **categorias.html** → Gestión de categorías de profesionales.  
- **perfil_profesional.html** (cuando se navega hacia un profesional) →  
  - Acciones de **Bloquear/Desbloquear usuario** con modal de confirmación.
http://localhost/ServiGo-Grupo1-ProgramacionWeb2025/frontend/visitante/index.html
---
4. Desde ahí se puede navegar según el rol:  
- `frontend/cliente/index.html`  
- `frontend/profesional/index.html`  
- `frontend/administrador/index.html`  

---

## 📝 Notas

- Los datos actuales son **hardcodeados en cada `script.js`**.  
- No existe todavía conexión con Base de Datos ni Backend.  
- Mejoras recientes:  
- Unificación de scripts en **Profesional** (todo en `script.js`).  
- **Solicitudes Recibidas** con filtros por rango de fechas, estado y localidad (lista desplegable).  
- Corrección de datos de prueba: se usan localidades reales (González Catán, San Justo, Morón, etc.).  
- Acciones de **bloquear/desbloquear** visibles solo para Administrador.  

## 🚀 Instrucciones para correrlo en XAMPP

1. Copiar la carpeta `ServiGo-Grupo1-ProgramacionWeb2025` dentro de:  C:\xampp\htdocs\
2. Iniciar **Apache** desde el panel de XAMPP.

3. Abrir el navegador y acceder a: 

##  Pendientes para la entrega

1. **Visitante:**  
   - Vistas de inicio de sesión, registro y recuperar contraseña.

2. **Cliente:**  
   - Completar el perfil.  
   - Agregar formulario para edición de perfil.  
   - Vista para comparar presupuestos de una misma solicitud.  
   - Ajustar solicitud para seleccionar y reenviar a favoritos.

3. **Profesional:**  
   - Formulario para editar perfil.

4. **Administrador:**  
   - Vista para mostrar lo denunciado (comentario, chat o perfil) con modal.  
   - Posibilidad de ocultar comentarios ofensivos.
