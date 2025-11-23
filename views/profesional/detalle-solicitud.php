<?php
require_once __DIR__ . '/../../includes/guard_profesional.php';
$active = 'solicitudes';
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';

$id = intval($_GET['id'] ?? 0);
?>
<link rel="stylesheet" href="/ServiGo/assets/css/profesional.css">

<div class="container py-4 text-light">
  <a href="/ServiGo/views/profesional/solicitudes-profesional.php" class="btn btn-outline-light btn-sm mb-3">← Volver</a>
  <div id="detalleSolicitud" class="card bg-dark mb-4">
    <div class="card-body">
      <h4 class="mb-2">Solicitud #<?= htmlspecialchars($id) ?></h4>
      <div class="small text-secondary" id="solicitudInfo">Cargando...</div>
    </div>
  </div>

  <div class="card bg-dark">
    <div class="card-body">
      <h5 class="card-title">Enviar presupuesto</h5>
      <form id="formPresupuesto">
        <input type="hidden" name="solicitud_id" value="<?= htmlspecialchars($id) ?>">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Monto (ARS)</label>
            <input type="number" step="0.01" min="0" class="form-control" name="monto" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Plazo estimado (días)</label>
            <input type="number" min="1" class="form-control" name="plazo_dias" required>
          </div>
          <div class="col-12">
            <label class="form-label">Detalle / Observaciones</label>
            <textarea class="form-control" name="detalle" rows="3" required></textarea>
          </div>
        </div>
        <div class="mt-3 d-flex gap-2">
          <button class="btn btn-primary" type="submit">Enviar</button>
          <span id="estadoEnvio" class="small text-secondary"></span>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="/ServiGo/assets/js/profesional.js"></script>
<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
