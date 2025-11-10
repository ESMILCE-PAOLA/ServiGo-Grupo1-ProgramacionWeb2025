<?php
require_once __DIR__ . '/../../includes/guard_profesional.php';
$active = 'presupuestos';
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';
?>

<main class="container py-4 text-light">
  <h2 class="mb-4 text-light">Mis Presupuestos Enviados</h2>

  <!-- FILTROS -->
  <form id="formFiltros" class="row g-3 mb-4">
    <div class="col-md-3">
      <label class="form-label">Desde</label>
      <input type="date" id="fechaDesde" class="form-control">
    </div>
    <div class="col-md-3">
      <label class="form-label">Hasta</label>
      <input type="date" id="fechaHasta" class="form-control">
    </div>
    <div class="col-md-3">
      <label class="form-label">Estado</label>
      <select id="filtroEstado" class="form-select">
        <option value="">Todos</option>
        <option value="Pendiente">Pendiente</option>
        <option value="Aceptado">Aceptado</option>
        <option value="Rechazado">Rechazado</option>
        <option value="Vencido">Vencido</option>
      </select>
    </div>
    <div class="col-12 text-end">
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-funnel"></i> Filtrar
      </button>
    </div>
  </form>

  <!-- TABLA -->
  <div class="table-responsive">
    <table class="table align-middle text-light">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Solicitud</th>
          <th>Cliente</th>
          <th>Monto</th>
          <th>Plazo</th>
          <th>Validez</th>
          <th>Estado</th>
          <th>Fecha</th>
        </tr>
      </thead>
      <tbody id="tablaPresupuestos">
        <tr>
          <td colspan="8" class="text-center py-3 text-secondary">Cargando presupuestos...</td>
        </tr>
      </tbody>
    </table>
  </div>
</main>

<script src="<?= BASE_URL ?>/assets/js/profesional/presupuestos.js" defer></script>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
