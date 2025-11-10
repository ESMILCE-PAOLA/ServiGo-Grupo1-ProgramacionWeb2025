// ==============================
// DETALLE DE SOLICITUD – PROFESIONAL
// ==============================
document.addEventListener("DOMContentLoaded", async () => {
  const urlParams = new URLSearchParams(window.location.search);
  const idSolicitud = urlParams.get("id");

  if (!idSolicitud) {
    console.error("Falta el parámetro ID en la URL");
    return;
  }

  const API = {
    detalle: `${window.BASE_URL}/backend/api/usuarios/profesional/detalle_solicitud.php?id=${idSolicitud}`,
    chat: `${window.BASE_URL}/backend/api/chat/listar.php?solicitud_id=${idSolicitud}`,
    enviarMensaje: `${window.BASE_URL}/backend/api/chat/enviar.php`,
  };

  // Elementos del DOM
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

  // ==============================
  // CARGAR DETALLE DE SOLICITUD
  // ==============================
  async function cargarDetalle() {
    try {
      const resp = await fetch(API.detalle);
      const json = await resp.json();

      if (!json.success || !json.data) {
        descripcion.textContent = "Error al cargar los datos de la solicitud.";
        return;
      }

      const d = json.data;
      nombreCliente.textContent = d.cliente ?? "—";
      direccion.textContent = d.direccion ?? "—";
      localidad.textContent = d.localidad ?? "—";
      titulo.textContent = d.titulo ?? "—";
      fecha.textContent = d.created_at ?? "—";
      descripcion.textContent = d.descripcion ?? "—";

      // Mostrar adjuntos si existen
      if (d.adjuntos && d.adjuntos.length > 0) {
        bloqueAdjuntos.classList.remove("d-none");
        listaAdjuntos.innerHTML = d.adjuntos
          .map(
            (a) =>
              `<li><a href="${window.BASE_URL}/${a}" target="_blank" class="text-decoration-none text-primary"><i class="bi bi-paperclip"></i> ${a.split("/").pop()}</a></li>`
          )
          .join("");
      } else {
        bloqueAdjuntos.classList.add("d-none");
      }
    } catch (err) {
      console.error("Error cargando solicitud:", err);
      descripcion.textContent = "Error al cargar los datos de la solicitud.";
    }
  }

  // ==============================
  // CARGAR CHAT
  // ==============================
  async function cargarChat() {
    try {
      const resp = await fetch(API.chat);
      const json = await resp.json();

      if (!json.success) throw new Error("No se pudieron obtener mensajes");
      if (!json.data || json.data.length === 0) {
        chatBox.innerHTML =
          '<p class="text-muted text-center">Sin mensajes aún.</p>';
        return;
      }

      chatBox.innerHTML = json.data
        .map(
          (m) => `
          <div class="mb-2">
            <strong class="${m.tipo === 'profesional' ? 'text-primary' : 'text-success'}">
              ${m.tipo === "profesional" ? "Profesional" : "Cliente"}:
            </strong>
            <span>${m.mensaje}</span>
            <div class="text-muted small">${m.created_at ?? ""}</div>
          </div>
        `
        )
        .join("");

      chatBox.scrollTop = chatBox.scrollHeight;
    } catch (err) {
      console.error("Error al cargar chat:", err);
      chatBox.innerHTML =
        '<p class="text-danger text-center">Error al cargar mensajes.</p>';
    }
  }
  // ==============================
  // ACTUALIZAR ESTADO
  // ==============================
  async function actualizarEstado(estado) {
    if (!confirm(`¿Seguro que desea marcar la solicitud como ${estado}?`)) return;

    try {
      const resp = await fetch(`${window.BASE_URL}/backend/api/usuarios/profesional/actualizar_estado.php`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id_solicitud: idSolicitud, estado }),
      });

      const json = await resp.json();
      if (json.success) {
        alert("Estado actualizado correctamente");
        // Redirigir de nuevo a la lista para ver el cambio
        window.location.href = `${window.BASE_URL}/views/profesional/solicitudes-profesional.php`;
      } else {
        alert("Error: " + (json.error || "No se pudo actualizar el estado"));
      }
    } catch (err) {
      console.error("Error actualizando estado:", err);
      alert("Error al intentar actualizar el estado");
    }
  }


  // Asignar eventos a los botones
  document.getElementById("btnAceptar")?.addEventListener("click", () => actualizarEstado("aceptada"));
  document.getElementById("btnRechazar")?.addEventListener("click", () => actualizarEstado("rechazada"));


  // ==============================
  // ENVIAR MENSAJE
  // ==============================
  formMensaje?.addEventListener("submit", async (e) => {
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
          tipo: "profesional",
        }),
      });

      const json = await resp.json();
      if (json.success) {
        inputMensaje.value = "";
        await cargarChat();
      } else {
        alert("No se pudo enviar el mensaje");
      }
    } catch (err) {
      console.error("Error al enviar mensaje:", err);
    }
  });

  // ==============================
  // INICIALIZACIÓN
  // ==============================
  await cargarDetalle();
  await cargarChat();
});
