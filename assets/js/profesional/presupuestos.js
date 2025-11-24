// ==============================
// PRESUPUESTOS – PROFESIONAL
// ==============================

document.addEventListener('DOMContentLoaded', () => {
  const tabla = document.querySelector('#tablaPresupuestos');
  const formFiltros = document.querySelector('#formFiltros');
  const filtroEstado = document.querySelector('#filtroEstado');
  const fechaDesde = document.querySelector('#fechaDesde');
  const fechaHasta = document.querySelector('#fechaHasta');

  cargarPresupuestos();

  formFiltros?.addEventListener('submit', e => {
    e.preventDefault();
    cargarPresupuestos();
  });

  async function cargarPresupuestos() {
    tabla.innerHTML = `
      <tr>
        <td colspan="8" class="text-center py-3">
          <div class="spinner-border text-primary" role="status"></div>
          <p class="small mt-2 text-secondary">Cargando...</p>
        </td>
      </tr>`;

    try {
      const query = new URLSearchParams({
        estado: filtroEstado.value,
        fechaDesde: fechaDesde.value,
        fechaHasta: fechaHasta.value
      }).toString();

      const resp = await fetch(`${window.BASE_URL}/backend/api/usuarios/profesional/listar_presupuestos.php?${query}`);
      const json = await resp.json();

      if (!json.success) throw new Error(json.error || 'Error al obtener presupuestos');

      if (!json.data.length) {
        tabla.innerHTML = `<tr><td colspan="8" class="text-center text-secondary py-3">No se encontraron presupuestos.</td></tr>`;
        return;
      }

      tabla.innerHTML = json.data.map(p => `
        <tr>
          <td>${p.id}</td>
          <td>${p.solicitud}</td>
          <td>${p.cliente}</td>
          <td>$${p.monto}</td>
          <td>${p.plazo_dias} días</td>
          <td>${p.validez_dias} días</td>
          <td>${badgeEstado(p.estado)}</td>
          <td>${p.created_at}</td>
        </tr>
      `).join('');

    } catch (err) {
      console.error(err);
      tabla.innerHTML = `<tr><td colspan="8" class="text-center text-danger py-3">Error al cargar presupuestos.</td></tr>`;
    }
  }

  function badgeEstado(estado) {
    switch (estado) {
      case 'Pendiente': return '<span class="badge bg-warning text-dark">Pendiente</span>';
      case 'Aceptado':  return '<span class="badge bg-success">Aceptado</span>';
      case 'Rechazado': return '<span class="badge bg-danger">Rechazado</span>';
      case 'Vencido':   return '<span class="badge bg-secondary">Vencido</span>';
      default:           return `<span class="badge bg-light text-dark">${estado}</span>`;
    }
  }
});
