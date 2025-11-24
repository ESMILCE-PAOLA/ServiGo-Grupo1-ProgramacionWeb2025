<?php
require_once __DIR__ . '/../../includes/guard_profesional.php';
$active = 'detalle-solicitud';
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';

$id = $_GET['id'] ?? null;
if (!$id) {
  echo "<div class='container mt-5 text-center'>
          <h4 class='text-danger'>Solicitud no especificada.</h4>
          <a href='solicitudes-profesional.php' class='btn btn-outline-dark mt-3'>Volver</a>
        </div>";
  include_once __DIR__ . '/../../includes/footer.php';
  exit;
}
?>

<div class="container py-4">
  <!-- Encabezado -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0 fw-bold text-dark">
      Solicitud <span id="numeroSolicitud" class="text-secondary">#<?= htmlspecialchars($id) ?></span>
    </h3>
    <button id="btnDenunciar" 
            class="btn btn-outline-danger btn-sm"
            data-bs-toggle="modal"
            data-bs-target="#modalDenuncia">
      <i class="bi bi-flag"></i> Denunciar
    </button>

  </div>

  <!-- ===================== -->
  <!-- DATOS DE LA SOLICITUD -->
  <!-- ===================== -->
  <div id="detalleSolicitud" class="card border-0 shadow-sm mb-4">
    <div class="card-body bg-light">
      <div class="row mb-2">
        <div class="col-md-6">
          <p><strong>Cliente:</strong> <span id="nombreCliente" class="text-secondary">—</span></p>
          <p><strong>Dirección:</strong> <span id="direccion" class="text-secondary">—</span></p>
          <p><strong>Localidad:</strong> <span id="localidad" class="text-secondary">—</span></p>
        </div>
        <div class="col-md-6">
          <p><strong>Título de solicitud:</strong> <span id="titulo" class="text-secondary">—</span></p>
          <p><strong>Fecha:</strong> <span id="fecha" class="text-secondary">—</span></p>
        </div>
      </div>

      <div class="mt-3">
        <p><strong>Detalle:</strong></p>
        <p id="descripcion" class="text-muted">Cargando descripción...</p>
      </div>

      <!-- Adjuntos -->
      <div id="archivosAdjuntos" class="mt-4 d-none">
        <p><strong>Archivos adjuntos:</strong></p>
        <ul id="listaAdjuntos" class="list-unstyled mb-0"></ul>
      </div>
    </div>
  </div>

  <!-- ===================== -->
  <!-- CHAT -->
  <!-- ===================== -->
  <div id="chatContainer" class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom fw-bold">Chat</div>
    <div id="mensajesChat" class="card-body bg-white" style="max-height: 320px; overflow-y: auto;">
      <p class="text-muted text-center">Cargando mensajes...</p>
    </div>
    <div class="card-footer bg-white border-top">
      <form id="formMensaje" class="d-flex">
        <input type="text" id="inputMensaje" class="form-control me-2" placeholder="Escriba un mensaje..." required>
        <button class="btn btn-primary px-3" type="submit">
            <i class="bi bi-send-fill"></i> Enviar
        </button>


      </form>
    </div>
  </div>

  <!-- ===================== -->
  <!-- BOTONES DE ACCIÓN -->
  <!-- ===================== -->
  <button id="btnVerPresupuesto" class="btn btn-info" style="display:none;">
      Ver presupuesto
  </button>

  <div class="text-center mt-4">
    <button id="btnCrearPresupuesto" class="btn btn-primary me-2" disabled>
      <i class="bi bi-receipt"></i> Crear Presupuesto
    </button>

    <button id="btnAceptar" class="btn btn-success me-2">
      <i class="bi bi-check-circle"></i> Aceptar
    </button>
    <button id="btnRechazar" class="btn btn-danger me-2">
      <i class="bi bi-x-circle"></i> Rechazar
    </button>
    <a href="solicitudes-profesional.php" class="btn btn-secondary">
      <i class="bi bi-arrow-left"></i> Volver
    </a>
  </div>

<!-- ====== MODALES ====== -->
<?php 
  include_once __DIR__ . '/../../includes/modales/modales_generales.php';
  include_once __DIR__ . '/../../includes/modales/modal_denuncia.php'; 

?>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
