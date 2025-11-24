<?php
require_once __DIR__ . '/../../includes/guard_profesional.php';
$active = 'solicitudes';
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/profesional.css">

<main class="text-light">
  <div class="container py-4">
    <h2 class="mb-4 fw-semibold text-dark">Solicitudes Recibidas</h2>

    <!-- FILTROS -->
    <form id="formFiltros" class="row g-3 mb-4 align-items-end">

      <div class="col-md-2">
        <label class="form-label">Desde</label>
        <input type="date" id="fechaDesde" class="form-control">
      </div>

      <div class="col-md-2">
        <label class="form-label">Hasta</label>
        <input type="date" id="fechaHasta" class="form-control">
      </div>

      <div class="col-md-2">
        <label class="form-label">Localidad</label>
        <select id="filtroLocalidad" class="form-select">
          <!-- Se llenará dinámicamente con JS -->
          <option value="">Todas</option>
        </select>
      </div>

      <div class="col-md-2">
        <label class="form-label">Estado (Profesional)</label>
        <select id="filtroEstado" class="form-select">
          <!-- COMPLETAMENTE DINÁMICO -->
          <option value="">Todos</option>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">Etapa (Proceso)</label>
        <select id="filtroEtapa" class="form-select">
          <!-- COMPLETAMENTE DINÁMICO -->
          <option value="">Todas</option>
        </select>
      </div>

      <div class="col-md-2 text-end">
        <button type="submit" class="btn btn-primary w-100">
          <i class="bi bi-funnel"></i> Buscar
        </button>
      </div>
    </form>

    <!-- TABLA -->
    <div class="table-responsive">
      <table class="table align-middle table-hover text-center">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Detalle</th>
            <th>Localidad</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Etapa</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody id="tablaSolicitudes">
          <!-- Se cargará dinámicamente -->
        </tbody>
      </table>
    </div>


<script src="<?= BASE_URL ?>/assets/js/profesional/solicitudes.js" defer></script>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
