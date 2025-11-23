<?php
require_once __DIR__ . '/../../includes/guard_profesional.php';
$active = 'inicio';
?>
<?php include_once __DIR__ . '/../../includes/header.php'; ?>
<?php include_once __DIR__ . '/../../includes/navbar.php'; ?>

<link rel="stylesheet" href="/ServiGo/assets/css/profesional.css">
<?php
require_once __DIR__ . '/../../includes/guard_profesional.php';
$active = 'inicio';
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';
?>

<main class="text-light">

<div class="container py-4">
  <h2 class="mb-4 fw-semibold text-dark">Solicitudes Recibidas</h2>

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
      <label class="form-label">Localidad</label>
      <select id="filtroLocalidad" class="form-select">
        <option value="">Todas</option>
      </select>
    </div>
    <div class="col-md-3">
      <label class="form-label">Estado</label>
      <select id="filtroEstado" class="form-select">
        <option value="">Todos</option>
        <option value="Pendiente">Pendiente</option>
        <option value="Aceptada">Aceptada</option>
        <option value="Rechazada">Rechazada</option>
      </select>
    </div>
    <div class="col-12 text-end">
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-funnel"></i> Buscar
      </button>
    </div>
  </form>

  <!-- TABLA -->
  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>ID</th>
          <th>Cliente</th>
          <th>Detalle</th>
          <th>Localidad</th>
          <th>Fecha</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="tablaSolicitudes">
        <!-- Contenido generado dinámicamente -->
        <tr>
          <td>101</td>
          <td>María González</td>
          <td>Instalación eléctrica cocina</td>
          <td>González Catán</td>
          <td>2025-09-25</td>
          <td><span class="estado pendiente">Pendiente</span></td>
          <td><button class="btn-ver">Ver mensaje</button></td>
        </tr>
        <tr>
          <td>102</td>
          <td>Juan Pérez</td>
          <td>Pérdida en cañería baño</td>
          <td>San Justo</td>
          <td>2025-09-26</td>
          <td><span class="estado aceptada">Aceptada</span></td>
          <td><button class="btn-ver">Ver mensaje</button></td>
        </tr>
        <tr>
          <td>103</td>
          <td>Sofía Arias</td>
          <td>Carpintería: reparación de puerta</td>
          <td>Morón</td>
          <td>2025-09-27</td>
          <td><span class="estado rechazada">Rechazada</span></td>
          <td><button class="btn-ver">Ver mensaje</button></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>