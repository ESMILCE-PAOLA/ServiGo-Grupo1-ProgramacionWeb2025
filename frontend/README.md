# Frontend – ServiGo

Este directorio contiene las **vistas del sistema ServiGo**, organizadas por **rol**.  
Cada carpeta incluye las pantallas principales en formato **HTML**, con soporte en **CSS** y **JavaScript**.

---

## 📂 Estructura

```
frontend/
│── css/                  # Estilos compartidos
│    └── estilo.css
│
│── js/                   # Lógica compartida
│    └── script.js
│
├── visitante/            # Pantallas del visitante (usuario no registrado)
│    └── index.html       # Pantalla de inicio con buscador y login/registro
│
├── cliente/              # Pantallas del cliente (usuario registrado)
│    └── crear_solicitud_cliente.html   # Formulario para crear solicitudes
│
├── profesional/          # Pantallas del profesional
│    ├── perfil_profesional.html        # Perfil con datos y trabajos
│    └── solicitudes-profesional.html   # Listado de solicitudes recibidas
│
├── administrador/        # Pantallas del administrador
│    └── (pendiente)      # Panel de gestión (usuarios, denuncias, etc.)
│
└── comunes/              # Vistas comunes a cliente y profesional
     └── chat.html        # Chat privado vinculado a una solicitud
```

---

##  Cómo probar en local
1. Copiar el proyecto dentro de la carpeta **`htdocs`** de XAMPP.  
   Ejemplo:  
   ```
   C:\xampp\htdocs\ServiGo\frontend
   ```
2. Iniciar Apache en XAMPP.  
3. Abrir en el navegador la vista deseada, por ejemplo:  
   - Visitante: [http://localhost/ServiGo/frontend/visitante/index.html](http://localhost/ServiGo/frontend/visitante/index.html)  
   - Cliente: [http://localhost/ServiGo/frontend/cliente/crear_solicitud_cliente.html](http://localhost/ServiGo/frontend/cliente/crear_solicitud_cliente.html)  
   - Profesional: [http://localhost/ServiGo/frontend/profesional/perfil_profesional.html](http://localhost/ServiGo/frontend/profesional/perfil_profesional.html)  
   - Chat: [http://localhost/ServiGo/frontend/comunes/chat.html](http://localhost/ServiGo/frontend/comunes/chat.html)  

---

## 👥 Notas
- El **chat** siempre está vinculado a una **solicitud**: solo cliente y profesional involucrados pueden verlo.  
- Las vistas actuales son **prototipos**: sirven como base para continuar con la integración a PHP y base de datos.  
- El **administrador** aún no tiene vistas definidas.  

---

 *Este README es una guía rápida para el equipo de frontend.*
