// ==============================
// SOLICITUDES – PROFESIONAL
// ==============================
document.addEventListener("DOMContentLoaded", () => {
  const formFiltros = document.querySelector("#formFiltros");
  const tabla = document.querySelector("#tablaSolicitudes");
  const filtroLocalidad = document.querySelector("#filtroLocalidad");
  const filtroEstado = document.querySelector("#filtroEstado");
  const filtroEtapa = document.querySelector("#filtroEtapa");
  const fechaDesde = document.querySelector("#fechaDesde");
  const fechaHasta = document.querySelector("#fechaHasta");

  // ==============================
  //  CARGAR LOCALIDADES
  // ==============================
  async function cargarLocalidades() {
    try {
      const resp = await fetch(`${window.BASE_URL}/backend/api/localidades/listar.php`);
      const json = await resp.json();

      if (json.success && json.data.length) {
        // ✅ Ajuste: cada elemento del array es un string, no un objeto
        filtroLocalidad.innerHTML =
          '<option value="">Todas</option>' +
          json.data.map(nombre => `<option value="${nombre}">${nombre}</option>`).join("");
      }
    } catch (err) {
      console.error("Error cargando localidades:", err);
    }
  }

  // ==============================
  //  CARGAR SOLICITUDES
  // ==============================
  async function cargarSolicitudes() {
    try {
      const params = new URLSearchParams({
        fechaDesde: fechaDesde.value,
        fechaHasta: fechaHasta.value,
        estado: filtroEstado.value,
        etapa: filtroEtapa?.value ?? "",
        localidad: filtroLocalidad.value,
      });

      const resp = await fetch(
        `${window.BASE_URL}/backend/api/usuarios/profesional/listar_solicitudes.php?${params.toString()}`
      );
      const json = await resp.json();

      if (!json.success) throw new Error(json.error || "Error al cargar solicitudes");

      if (!json.data || json.data.length === 0) {
        tabla.innerHTML = `<tr>
          <td colspan="8" class="text-center text-muted py-3">No se encontraron solicitudes.</td>
        </tr>`;
        return;
      }

      tabla.innerHTML = json.data
        .map(
          (s) => `
          <tr>
            <td>${s.id}</td>
            <td>${s.cliente}</td>
            <td>${s.detalle}</td>
            <td>${s.localidad ?? "-"}</td>
            <td>${s.fecha}</td>
            <td>${badgeEstado(s.estado)}</td>   <!-- ✅ Cambiado de renderEstado -->
            <td>${badgeEtapa(s.etapa)}</td>     <!-- ✅ Cambiado de renderEtapa -->
            <td>
              <a href="${window.BASE_URL}/views/profesional/detalle-solicitud.php?id=${s.id}" 
                 class="btn btn-sm btn-outline-primary">
                Ver mensaje
              </a>
            </td>
          </tr>`
        )
        .join("");
    } catch (err) {
      console.error("Error al cargar solicitudes:", err);
      tabla.innerHTML = `<tr>
        <td colspan="8" class="text-center text-danger py-3">Error al cargar datos.</td>
      </tr>`;
    }
  }

  // ==============================
  //  RENDERIZAR ESTADOS (color)
  // ==============================
  const badgeEstado = (estado = "") => {
    const map = {
      pendiente: "bg-warning text-dark",
      aceptada: "bg-success",
      rechazada: "bg-danger",
    };
    const clase = map[estado.toLowerCase()] || "bg-secondary";
    return `<span class="badge ${clase} text-capitalize">${estado || "-"}</span>`;
  };

  const badgeEtapa = (etapa = "") => {
    const map = {
      pendiente: "bg-warning text-dark",
      presupuesto_enviado: "bg-info text-dark",
      esperando_cliente: "bg-primary",
      en_progreso: "bg-success",
      finalizada: "bg-secondary",
      cancelada: "bg-danger",
    };
    const clase = map[etapa.toLowerCase()] || "bg-light text-dark";
    return `<span class="badge ${clase} text-capitalize">${etapa || "-"}</span>`;
  };

  // ==============================
  //  EVENTOS
  // ==============================
  formFiltros?.addEventListener("submit", (e) => {
    e.preventDefault();
    cargarSolicitudes();
  });

  // ==============================
  //  INICIALIZACIÓN
  // ==============================
  cargarLocalidades();
  cargarSolicitudes();
});
