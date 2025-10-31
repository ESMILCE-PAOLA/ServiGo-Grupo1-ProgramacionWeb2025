// script.js - Funcionalidades de la vista PROFESIONAL
// --------------------------------------------------

// Datos hardcodeados de ejemplo
const solicitudes = [
  { id: 1, cliente: "Ana Torres", localidad: "San Justo", estado: "Pendiente", fecha: "2025-09-15", descripcion: "Necesito arreglo eléctrico en mi casa" },
  { id: 2, cliente: "Martín Díaz", localidad: "González Catán", estado: "Aceptada", fecha: "2025-09-20", descripcion: "Colocación de una puerta de madera" },
  { id: 3, cliente: "Laura Fernández", localidad: "Morón", estado: "Rechazada", fecha: "2025-09-22", descripcion: "Reparación de cañerías de agua" },
  { id: 4, cliente: "Pedro Gómez", localidad: "Ramos Mejía", estado: "Pendiente", fecha: "2025-09-25", descripcion: "Pintura de living y cocina" }
];

// ⚡ Filtro + Render
function renderSolicitudes() {
  const lista = document.getElementById("listaSolicitudes");
  if (!lista) return;

  lista.innerHTML = "";

  const localidad = document.getElementById("filtroLocalidad").value;
  const estado = document.getElementById("filtroEstado").value;
  const fecha = document.getElementById("filtroFecha").value;

  const filtradas = solicitudes.filter(s => {
    const matchLocalidad = localidad === "Todas" || s.localidad === localidad;
    const matchEstado = estado === "Todos" || s.estado === estado;
    const matchFecha = !fecha || s.fecha === fecha;
    return matchLocalidad && matchEstado && matchFecha;
  });

  if (filtradas.length === 0) {
    lista.innerHTML = `<div class="alert alert-info">No hay solicitudes con los filtros seleccionados.</div>`;
    return;
  }

  filtradas.forEach(s => {
    const card = document.createElement("div");
    card.className = "card mb-3 shadow-sm";

    card.innerHTML = `
      <div class="card-body">
        <h5 class="card-title">Cliente: ${s.cliente}</h5>
        <p class="card-text"><strong>Localidad:</strong> ${s.localidad}</p>
        <p class="card-text"><strong>Fecha:</strong> ${s.fecha}</p>
        <p class="card-text"><strong>Estado:</strong> <span class="badge bg-${
          s.estado === "Pendiente" ? "warning" : s.estado === "Aceptada" ? "success" : "danger"
        }">${s.estado}</span></p>
        <button class="btn btn-outline-primary btn-sm" onclick="verDetalle(${s.id})">
          <i class="bi bi-eye"></i> Ver mensaje
        </button>
      </div>
    `;
    lista.appendChild(card);
  });
}

// ⚡ Mostrar detalle en modal
function verDetalle(id) {
  const solicitud = solicitudes.find(s => s.id === id);
  if (!solicitud) return;

  const detalleDiv = document.getElementById("detalleSolicitud");
  detalleDiv.innerHTML = `
    <p><strong>Cliente:</strong> ${solicitud.cliente}</p>
    <p><strong>Localidad:</strong> ${solicitud.localidad}</p>
    <p><strong>Fecha:</strong> ${solicitud.fecha}</p>
    <p><strong>Estado:</strong> ${solicitud.estado}</p>
    <p><strong>Descripción:</strong> ${solicitud.descripcion}</p>
  `;

  const modal = new bootstrap.Modal(document.getElementById("modalDetalle"));
  modal.show();
}

// ⚡ Inicialización
document.addEventListener("DOMContentLoaded", () => {
  if (document.getElementById("btnBuscar")) {
    document.getElementById("btnBuscar").addEventListener("click", renderSolicitudes);
    renderSolicitudes();
  }
});
