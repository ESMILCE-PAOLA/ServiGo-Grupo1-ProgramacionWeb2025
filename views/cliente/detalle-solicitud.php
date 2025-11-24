<?php
//require_once __DIR__ . '/../../includes/guard_cliente.php';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';

$idSolicitud = $_GET['id'] ?? 0;
?>

<main class="container py-4 text-light">
  <h2 class="mb-4 text-light">Detalle de tu Solicitud</h2>

  <div id="detalleSolicitud" class="card bg-dark border-secondary mb-4">
    <div class="card-body">
      <h5 id="titulo" class="card-title text-warning"></h5>
      <p id="descripcion" class="text-light"></p>
      <p><strong>Profesional:</strong> <span id="profesional"></span></p>
      <p><strong>Dirección:</strong> <span id="direccion"></span></p>
      <p><strong>Localidad:</strong> <span id="localidad"></span></p>
      <p><strong>Estado:</strong> <span id="estado" class="badge bg-warning text-dark"></span></p>
      <p><strong>Fecha:</strong> <span id="fecha"></span></p>
    </div>
  </div>

  <!-- CHAT -->
  <div class="card bg-dark border-secondary mb-4">
    <div class="card-header">
      <h5 class="mb-0">Chat con el Profesional</h5>
    </div>
    <div class="card-body" id="chatBox" style="height: 250px; overflow-y: auto;">
      <div class="text-secondary text-center small">Cargando mensajes...</div>
    </div>
    <div class="card-footer d-flex gap-2">
      <input type="text" id="mensaje" class="form-control" placeholder="Escribe un mensaje...">
      <button id="btnEnviar" class="btn btn-primary"><i class="bi bi-send"></i></button>
    </div>
  </div>

  <div class="text-end">
    <a href="<?= BASE_URL ?>/views/cliente/solicitudes.php" class="btn btn-secondary">
      <i class="bi bi-arrow-left"></i> Volver
    </a>
  </div>
</main>

<script>
  const SOLICITUD_ID = <?= (int)$idSolicitud ?>;
</script>
<script src="<?= BASE_URL ?>/assets/js/cliente/detalle-solicitud.js" defer></script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
