// ==============================
// SOLICITUDES – PROFESIONAL
// ==============================
document.addEventListener("DOMContentLoaded", async () => {
  const formFiltros = document.querySelector("#formFiltros");
  const tabla = document.querySelector("#tablaSolicitudes");
  const filtroLocalidad = document.querySelector("#filtroLocalidad");
  const filtroEstado = document.querySelector("#filtroEstado");
  const filtroEtapa = document.querySelector("#filtroEtapa");
  const fechaDesde = document.querySelector("#fechaDesde");
  const fechaHasta = document.querySelector("#fechaHasta");

  let ENUM_ESTADOS = [];
  let ENUM_ETAPAS = [];

  // ==============================
  // CARGAR ENUMS (Estados + Etapas)
  // ==============================
  async function cargarEnums() {
    try {
      const resp = await fetch(`${window.BASE_URL}/backend/api/enums/solicitudes_profesionales.php`);
      const json = await resp.json();

      if (!json.success) throw new Error(json.error || "Error cargando ENUMs");

      ENUM_ESTADOS = json.data.estados;
      ENUM_ETAPAS = json.data.etapas;

      rellenarFiltrosDinamicos();
    } catch (err) {
      console.error("Error cargando ENUMs:", err);
    }
  }

  function rellenarFiltrosDinamicos() {
    // ESTADO (Profesional)
    filtroEstado.innerHTML =
      `<option value="">Todos</option>` +
      ENUM_ESTADOS.map(estado => 
        `<option value="${estado}">${capitalizar(estado)}</option>`
      ).join("");

    // ETAPA (Proceso)
    filtroEtapa.innerHTML =
      `<option value="">Todas</option>` +
      ENUM_ETAPAS.map(etapa =>
        `<option value="${etapa}">${capitalizar(etapa.replace('_',' '))}</option>`
      ).join("");
  }

  // ==============================
  // CARGAR LOCALIDADES
  // ==============================
  async function cargarLocalidades() {
    try {
      const resp = await fetch(`${window.BASE_URL}/backend/api/localidades/listar.php`);
      const json = await resp.json();

      if (json.success && json.data.length) {
        filtroLocalidad.innerHTML =
          '<option value="">Todas</option>' +
          json.data.map(nombre => `<option value="${nombre}">${nombre}</option>`).join("");
      }
    } catch (err) {
      console.error("Error cargando localidades:", err);
    }
  }

  // ==============================
  // CARGAR SOLICITUDES
  // ==============================
  async function cargarSolicitudes() {
    try {
      const params = new URLSearchParams({
        fechaDesde: fechaDesde.value,
        fechaHasta: fechaHasta.value,
        estado: filtroEstado.value,
        etapa: filtroEtapa.value || "",
        localidad: filtroLocalidad.value,
      });

      const resp = await fetch(
        `${window.BASE_URL}/backend/api/usuarios/profesional/listar_solicitudes.php?${params.toString()}`
      );
      const json = await resp.json();

      if (!json.success) throw new Error(json.error || "Error al cargar solicitudes");

      if (!json.data || json.data.length === 0) {
        tabla.innerHTML = `
          <tr><td colspan="8" class="text-center text-muted py-3">
            No se encontraron solicitudes.
          </td></tr>`;
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
              <td>${badgeEstado(s.estado)}</td>
              <td>${badgeEtapa(s.etapa)}</td>
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
      tabla.innerHTML = `
        <tr><td colspan="8" class="text-center text-danger py-3">
          Error al cargar datos.
        </td></tr>`;
    }
  }

  // ==============================
  // RENDERIZAR BADGE (ESTADO)
  // ==============================
  const badgeEstado = (estado = "") => {
    const map = {
      pendiente: "bg-warning text-dark",
      aceptada: "bg-success",
      rechazada: "bg-danger",
    };
    const clase = map[estado] || "bg-secondary";
    return `<span class="badge ${clase} text-capitalize">${estado || "-"}</span>`;
  };

  // ==============================
  // RENDERIZAR BADGE (ETAPA)
  // ==============================
  const badgeEtapa = (etapa = "") => {
    const map = {
      pendiente: "bg-warning text-dark",
      presupuesto: "bg-info text-dark",
      en_servicio: "bg-primary",
      finalizado: "bg-success",
    };
    const clase = map[etapa] || "bg-light text-dark";
    return `<span class="badge ${clase} text-capitalize">${etapa || "-"}</span>`;
  };

  // ==============================
  // UTIL
  // ==============================
  function capitalizar(texto) {
    return texto.charAt(0).toUpperCase() + texto.slice(1);
  }

  // ==============================
  // EVENTOS
  // ==============================
  formFiltros?.addEventListener("submit", (e) => {
    e.preventDefault();
    cargarSolicitudes();
  });

  // ==============================
  // INICIALIZACIÓN
  // ==============================
  await cargarEnums();       //  Primero cargar enums
  await cargarLocalidades(); // Luego cargar localidades
  await cargarSolicitudes(); // Finalmente cargar solicitudes
});
