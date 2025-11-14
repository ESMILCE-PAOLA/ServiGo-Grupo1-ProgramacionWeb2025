// ==============================
// DETALLE DE SOLICITUD – PROFESIONAL
// ==============================
document.addEventListener("DOMContentLoaded", async () => {
  console.log("[detalle-solicitud] DOM listo");

  const urlParams = new URLSearchParams(window.location.search);
  const idSolicitud = urlParams.get("id");

  if (!idSolicitud) {
    console.error("Falta el ID en la URL");
    return;
  }

  const API = {
    detalle: `${window.BASE_URL}/backend/api/usuarios/profesional/detalle_solicitud.php?id=${idSolicitud}`,
    chat: `${window.BASE_URL}/backend/api/chat/listar.php?solicitud_id=${idSolicitud}`,
    enviarMensaje: `${window.BASE_URL}/backend/api/chat/enviar.php`,
    actualizarEstado: `${window.BASE_URL}/backend/api/solicitudes/actualizar_estado.php`
  };

  // === ELEMENTOS DEL DOM ===
  const nombreCliente = document.getElementById("nombreCliente");
  const direccion = document.getElementById("direccion");
  const localidad = document.getElementById("localidad");
  const titulo = document.getElementById("titulo");
  const fecha = document.getElementById("fecha");
  const descripcion = document.getElementById("descripcion");

  const listaAdjuntos = document.getElementById("listaAdjuntos");
  const bloqueAdjuntos = document.getElementById("archivosAdjuntos");

  const chatBox = document.getElementById("mensajesChat");
  const formMensaje = document.getElementById("formMensaje");
  const inputMensaje = document.getElementById("inputMensaje");

  const btnAceptar = document.getElementById("btnAceptar");
  const btnRechazar = document.getElementById("btnRechazar");
  const btnCrearPresupuesto = document.getElementById("btnCrearPresupuesto");

  // ==============================
  // CARGAR DETALLE DE SOLICITUD
  // ==============================
  async function cargarDetalle() {
    try {
      const resp = await fetch(API.detalle);
      const json = await resp.json();
      console.log("[detalle-solicitud] detalle:", json);

      if (!json.success || !json.data) {
        descripcion.textContent = "Error al cargar datos.";
        return;
      }

      const d = json.data;

      nombreCliente.textContent = d.cliente ?? "—";
      direccion.textContent = d.direccion ?? "—";
      localidad.textContent = d.localidad ?? "—";
      titulo.textContent = d.titulo ?? "—";
      fecha.textContent = d.created_at ?? "—";
      descripcion.textContent = d.descripcion ?? "—";

      // ADJUNTOS
      if (d.adjuntos && d.adjuntos.length > 0) {
        bloqueAdjuntos.classList.remove("d-none");
        listaAdjuntos.innerHTML = d.adjuntos
          .map(a => `
            <li>
              <a href="${window.BASE_URL}/assets/${a}"
                 target="_blank"
                 class="text-decoration-none text-primary">
                 <i class="bi bi-paperclip"></i> ${a.split("/").pop()}
              </a>
            </li>
          `)
          .join("");
      } else {
        bloqueAdjuntos.classList.add("d-none");
      }

      // Estado de la relación profesional–solicitud
      const estadoRelacion = d.estado_relacion ?? "";
      console.log("[detalle-solicitud] estado_relacion:", estadoRelacion);

      // Habilitar botón Crear Presupuesto solo si está ACEPTADA para este profesional
      if (estadoRelacion === "aceptada") {
        btnCrearPresupuesto.disabled = false;
      } else {
        btnCrearPresupuesto.disabled = true;
      }

    } catch (err) {
      console.error("Error cargando detalle:", err);
      descripcion.textContent = "Error al cargar los datos.";
    }
  }

  // ==============================
  // CARGAR CHAT
  // ==============================
  async function cargarChat() {
    try {
      const resp = await fetch(API.chat);
      const json = await resp.json();
      console.log("[detalle-solicitud] chat:", json);

      if (!json.success || !json.data.length) {
        chatBox.innerHTML = `<p class="text-muted text-center">Sin mensajes.</p>`;
        return;
      }

      chatBox.innerHTML = json.data
        .map(m => {
          const esProfesional = m.tipo === "profesional";
          return `
            <div class="d-flex ${esProfesional ? "justify-content-end" : "justify-content-start"} mb-2">
              <div class="p-2 rounded-3 shadow-sm chat-bubble ${esProfesional ? "bubble-pro" : "bubble-cli"}">
                <div class="fw-bold small mb-1">${m.nombre}</div>
                <div>${m.mensaje}</div>
                <div class="text-muted small text-end mt-1">${m.created_at ?? ""}</div>
              </div>
            </div>
          `;
        })
        .join("");

      chatBox.scrollTop = chatBox.scrollHeight;
    } catch (err) {
      console.error("Error chat:", err);
      chatBox.innerHTML = `<p class="text-danger text-center">Error al cargar chat.</p>`;
    }
  }

  // ==============================
  // ENVIAR MENSAJE
  // ==============================
  if (formMensaje) {
    formMensaje.addEventListener("submit", async (e) => {
      e.preventDefault();

      const mensaje = inputMensaje.value.trim();
      if (!mensaje) return;

      try {
        const resp = await fetch(API.enviarMensaje, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            solicitud_id: idSolicitud,
            mensaje,
            tipo: "profesional"
          }),
        });

        const json = await resp.json();
        console.log("[detalle-solicitud] enviarMensaje:", json);

        if (json.success) {
          inputMensaje.value = "";
          cargarChat();
        } else {
          mostrarModalError("No se pudo enviar el mensaje");
        }
      } catch (err) {
        console.error(err);
        mostrarModalError("Error al enviar mensaje");
      }
    });
  }

  // ==============================
  // CAMBIAR ESTADO (ACEPTAR / RECHAZAR)
  // ==============================
  async function cambiarEstado(estado) {
    try {
      const resp = await fetch(API.actualizarEstado, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          id_solicitud: idSolicitud,
          estado
        })
      });

      const json = await resp.json();
      console.log("[detalle-solicitud] actualizarEstado:", json);

      if (!json.success) {
        mostrarModalError(json.error || "No se pudo actualizar el estado.");
        return;
      }

      await cargarDetalle(); // refrescar datos
      mostrarModalConfirmacion("Estado actualizado correctamente");
    } catch (err) {
      console.error(err);
      mostrarModalError("Error de servidor al actualizar el estado");
    }
  }

  // BOTÓN ACEPTAR
  if (btnAceptar) {
    btnAceptar.addEventListener("click", () => {
      mostrarModalConfirmacion("¿Aceptar esta solicitud?", () => cambiarEstado("aceptada"));
    });
  }

  // BOTÓN RECHAZAR
  if (btnRechazar) {
    btnRechazar.addEventListener("click", () => {
      mostrarModalConfirmacion("¿Rechazar esta solicitud?", () => cambiarEstado("rechazada"));
    });
  }

  // CREAR PRESUPUESTO
  if (btnCrearPresupuesto) {
    btnCrearPresupuesto.addEventListener("click", () => {
      window.location.href = `crear_presupuesto.php?id=${idSolicitud}`;
    });
  }

  // ==============================
  // MODALES
  // ==============================
  function mostrarModalConfirmacion(texto, onConfirmar = null) {
    const modalEl = document.getElementById("modalConfirmacion");
    if (!modalEl) {
      alert(texto); // fallback por si falta el modal
      if (onConfirmar) onConfirmar();
      return;
    }

    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modalEl.querySelector(".modal-body").textContent = texto;

    modalEl.querySelector("#btnConfirmar").onclick = () => {
      modal.hide();
      if (onConfirmar) onConfirmar();
    };

    modal.show();
  }

  function mostrarModalError(texto) {
    const modalEl = document.getElementById("modalError");
    if (!modalEl) {
      alert(texto); // fallback
      return;
    }

    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modalEl.querySelector(".modal-body").textContent = texto;
    modal.show();
  }

  // ==============================
  // INICIALIZACIÓN
  // ==============================
  await cargarDetalle();
  await cargarChat();
  console.log("[detalle-solicitud] inicialización completa");
});
