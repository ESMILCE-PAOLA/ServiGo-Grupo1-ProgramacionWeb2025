document.addEventListener('DOMContentLoaded', () => {
  cargarSolicitudes();

  // Recarga con filtros (por ahora solo refresca)
  document.querySelector('#formFiltros').addEventListener('submit', e => {
    e.preventDefault();
    cargarSolicitudes();
  });
});

async function cargarSolicitudes() {
  const cuerpo = document.querySelector('#tablaSolicitudes');
  cuerpo.innerHTML = '<tr><td colspan="7" class="text-center text-secondary py-3">Cargando...</td></tr>';

  try {
    const r = await fetch('/ServiGo-Grupo1-ProgramacionWeb2025/backend/api/usuarios/profesional/listar_solicitudes.php');
    const j = await r.json();

    if (!j.success || !j.data.length) {
      cuerpo.innerHTML = '<tr><td colspan="7" class="text-center text-secondary py-3">No hay solicitudes registradas.</td></tr>';
      return;
    }

    cuerpo.innerHTML = '';

    j.data.forEach(s => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${s.id}</td>
        <td>${s.cliente}</td>
        <td>${s.descripcion}</td>
        <td>${s.localidad ?? ''}</td>
        <td>${new Date(s.created_at).toLocaleDateString('es-AR')}</td>
        <td>${estadoBadge(s.estado)}</td>
        <td>
          <a href="/ServiGo-Grupo1-ProgramacionWeb2025/views/profesional/detalle-solicitud.php?id=${s.id}" 
             class="btn btn-sm btn-info text-dark">
             <i class="bi bi-chat-left-text"></i> Ver mensaje
          </a>
        </td>
      `;
      cuerpo.appendChild(tr);
    });

  } catch (err) {
    console.error(err);
    cuerpo.innerHTML = '<tr><td colspan="7" class="text-center text-danger py-3">Error al cargar las solicitudes.</td></tr>';
  }
}

function estadoBadge(estado) {
  if (estado === 'Pendiente') return '<span class="badge bg-warning text-dark">Pendiente</span>';
  if (estado === 'Aceptada') return '<span class="badge bg-success">Aceptada</span>';
  if (estado === 'Rechazada') return '<span class="badge bg-danger">Rechazada</span>';
  return `<span class="badge bg-secondary">${estado}</span>`;
}
