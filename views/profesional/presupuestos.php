<?php
require_once __DIR__ . '/../../includes/guard_profesional.php';
$active = 'presupuestos';
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';
?>

<main class="container py-4 text-light">

  <div class="container py-4">
    <h2 class="mb-4"><i class="bi bi-file-earmark-plus"></i> Crear Presupuesto</h2>

    <form id="formPresupuesto" class="card shadow-sm p-4">

      <!-- Encabezado -->
      <div class="mb-3">
        <label class="form-label fw-bold">ID de la Solicitud</label>
        <input type="text" class="form-control" value="#101" readonly>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label fw-bold">Dirigido a</label>
          <input type="text" class="form-control" value="María González" readonly>
        </div>
        <div class="col-md-3 mb-3">
          <label class="form-label fw-bold">Fecha de Emisión</label>
          <input type="date" class="form-control" value="2025-09-27" readonly>
        </div>
        <div class="col-md-3 mb-3">
          <label class="form-label fw-bold">Válido hasta</label>
          <input type="date" class="form-control" required>
        </div>
      </div>

      <!-- Detalle del servicio -->
      <h5 class="mt-4">Detalle del Servicio</h5>
      <table class="table table-bordered align-middle">
        <thead class="table-light">
          <tr>
            <th>Cantidad</th>
            <th>Descripción</th>
            <th>Precio Unitario (ARS)</th>
            <th>Subtotal</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody id="detalleBody">
          <tr>
            <td><input type="number" class="form-control cantidad" value="1" required></td>
            <td><input type="text" class="form-control descripcion" placeholder="Trabajo a realizar" required></td>
            <td><input type="number" class="form-control precioUnitario" required></td>
            <td><input type="text" class="form-control subtotal" readonly></td>
            <td><button type="button" class="btn btn-outline-danger btn-sm btnEliminar"><i class="bi bi-trash"></i></button></td>
          </tr>
        </tbody>
      </table>

      <button type="button" id="btnAgregarFila" class="btn btn-outline-primary btn-sm mb-3">
        <i class="bi bi-plus-circle"></i> Agregar ítem
      </button>

      <!-- Totales -->
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label fw-bold">Total (ARS)</label>
          <input type="text" class="form-control" id="total" readonly>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label fw-bold">Condiciones</label>
          <textarea class="form-control" rows="3" placeholder="Ej: válido por 7 días, incluye materiales..."></textarea>
        </div>
      </div>

      <!-- Adjuntos -->
      <div class="mb-3">
        <label class="form-label fw-bold">Adjuntar archivos (opcional)</label>
        <input type="file" class="form-control" multiple>
      </div>

      <!-- Acciones -->
      <div class="d-flex justify-content-between mt-4">
        <a href="detalle_solicitud.php" class="btn btn-secondary">
          <i class="bi bi-arrow-left"></i> Cancelar
        </a>
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-send"></i> Enviar Presupuesto
        </button>
      </div>

    </form>
  </div>

  <!-- FOOTER PROFESIONAL -->
  <?php include BASE_PATH . 'includes/footer_profesional.php'; ?>

</main>

<!-- SCRIPT PROPIO -->

<script src="<?= BASE_URL ?>/assets/js/profesional/presupuestos.js" defer></script>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
