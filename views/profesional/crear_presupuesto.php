<?php
require_once __DIR__ . '/../../includes/guard_profesional.php';
$active = 'presupuestos';
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';

$idSolicitud = $_GET['id'] ?? 0;
?>

<main class="container py-4 text-light">
  <h2 class="mb-4 text-light">Crear Presupuesto</h2>

  <div class="card bg-dark border-secondary mb-4">
    <div class="card-body">
      <form id="formPresupuesto" class="row g-3">
        <input type="hidden" name="solicitud_id" value="<?= htmlspecialchars($idSolicitud) ?>">

        <div class="col-md-6">
          <label for="monto" class="form-label">Monto estimado ($)</label>
          <input type="number" class="form-control" id="monto" name="monto" placeholder="Ej: 15000" required>
        </div>

        <div class="col-md-6">
          <label for="plazo" class="form-label">Plazo de entrega (días)</label>
          <input type="number" class="form-control" id="plazo" name="plazo_dias" placeholder="Ej: 7" required>
        </div>

        <div class="col-12">
          <label for="descripcion" class="form-label">Descripción del trabajo</label>
          <textarea class="form-control" id="descripcion" name="descripcion" rows="4"
            placeholder="Detalles del servicio que vas a realizar..." required></textarea>
        </div>

        <div class="col-md-6">
          <label for="validez" class="form-label">Validez del presupuesto (días)</label>
          <input type="number" class="form-control" id="validez" name="validez_dias" placeholder="Ej: 10" required>
        </div>

        <div class="col-md-6">
          <label for="metodo" class="form-label">Método de pago</label>
          <select id="metodo" name="metodo_pago" class="form-select" required>
            <option value="">Seleccione...</option>
            <option value="Efectivo">Efectivo</option>
            <option value="Transferencia">Transferencia</option>
            <option value="Mercado Pago">Mercado Pago</option>
          </select>
        </div>

        <div class="col-12 text-end">
          <button type="submit" class="btn btn-success">
            <i class="bi bi-send"></i> Enviar presupuesto
          </button>
          <a href="<?= BASE_URL ?>/views/profesional/solicitudes-profesional.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
          </a>
        </div>
      </form>
    </div>
  </div>

  <div id="alerta" class="text-center mt-3"></div>
</main>

<script src="<?= BASE_URL ?>/assets/js/profesional/crear-presupuesto.js" defer></script>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
