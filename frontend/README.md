# Frontend – ServiGo

Este directorio contiene las **vistas del sistema ServiGo**, organizadas por **rol**.  
Cada carpeta incluye las pantallas principales en formato **HTML**, con soporte en **CSS** y **JavaScript**.

## Estructura actual
frontend/
│
├── visitante/ # Pantallas para usuarios NO registrados
│ ├── index.html # Página de inicio con buscador y login/registro en modal
│ ├── estilo.css
│ └── script.js
│ 📌 Falta agregar:
│ - iniciar_sesion.html
│ - registrarse.html
│ - recuperar_contraseña.html
│
├── cliente/ # Pantallas para usuarios registrados (clientes)
│ ├── index.html
│ ├── perfil.html # Perfil cliente (vacío, falta completar)
│ ├── nueva_solicitud.html
│ ├── solicitud_cliente.html
│ ├── chat_solicitud.html
│ ├── cliente.css
│ └── cliente.js
│ 📌 Falta agregar:
│ - formulario_editar_perfil.html
│ - vista_comparar_presupuestos.html
│
├── profesional/ # Pantallas para profesionales
│ ├── index.html
│ ├── perfil_profesional.html
│ ├── crear_presupuesto.html
│ ├── detalle_solicitud.html
│ ├── solicitudes-profesional.html
│ ├── estilos.css
│ ├── script.js
│ └── script_solicitudes.js
│ 📌 Falta agregar:
│ - formulario_editar_perfil.html
│
├── administrador/ # Pantallas para administradores
│ ├── DashboardAdministrador.html
│ ├── PerfilAdministrador.html
│ ├── GestionUsuarios.html
│ ├── GestionDenuncias.html
│ ├── usuarios-bloqueados.html
│ ├── script.js
│ └── imagenes/
│ 📌 Faltan:
│ - formulario_editar_perfil.html
│ - vista_ver_denuncia.html (modal para comentario/chat/perfil denunciado)
│
├── css/
│ └── estilo.css # Estilos compartidos
│
├── js/
│ └── script.js # Lógica compartida
│
└── README.md # Este archivo

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
