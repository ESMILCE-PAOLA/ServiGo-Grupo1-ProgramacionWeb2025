<?php
require_once __DIR__ . '/../../includes/guard_profesional.php';
$active = 'crear-presupuesto';
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';

$idSolicitud = $_GET['id'] ?? 0;
?>

<main class="container py-4 text-light">
  <h2 class="mb-4 text-light">
    <i class="bi bi-file-earmark-plus"></i> Crear Presupuesto
  </h2>

  <form id="formPresupuesto" class="card shadow-sm p-4">

    <!-- Hidden -->
    <input type="hidden" name="solicitud_id" id="solicitud_id_real">
    <input type="hidden" name="profesional_id" value="<?= $_SESSION['user']['id'] ?>">

    <!-- Datos principales -->
    <div class="mb-3">
      <label class="form-label fw-bold">ID de la Solicitud</label>
      <input type="text" id="solicitudId" class="form-control" readonly>
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Dirigido a</label>
        <input type="text" id="clienteNombre" class="form-control" readonly>
      </div>

      <div class="col-md-3 mb-3">
        <label class="form-label fw-bold">Fecha de Solicitud</label>
        <input type="date" id="fechaSolicitud" class="form-control" readonly>
      </div>

      <div class="col-md-3 mb-3">
        <label class="form-label fw-bold">Fecha de Emisión</label>
        <input type="date" id="fechaEmision" name="fecha_emision" class="form-control" readonly>
      </div>

      <div class="col-md-3 mb-3">
        <label class="form-label fw-bold">Válido hasta</label>
        <input type="date" name="valido_hasta" class="form-control" required>
      </div>
    </div>

    <!-- Detalle -->
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
          <td><input type="number" name="cantidad[]" class="form-control cantidad" value="1" required></td>
          <td><input type="text" name="descripcion[]" class="form-control descripcion" placeholder="Trabajo a realizar" required></td>
          <td><input type="number" name="precio_unitario[]" class="form-control precioUnitario" required></td>
          <td><input type="text" name="subtotal[]" class="form-control subtotal" readonly></td>
          <td><button type="button" class="btn btn-outline-danger btn-sm btnEliminar">
              <i class="bi bi-trash"></i>
            </button>
          </td>
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
        <input type="text" name="total" id="total" class="form-control" readonly>
      </div>

      <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Condiciones</label>
        <textarea name="condiciones" class="form-control" rows="3" placeholder="Ej: válido 7 días, incluye materiales..."></textarea>
      </div>
    </div>

    <!-- Acciones -->
    <div class="d-flex justify-content-between mt-4">
      <a href="detalle-solicitud.php?id=<?= $idSolicitud ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Cancelar
      </a>
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-send"></i> Enviar Presupuesto
      </button>
    </div>

  </form>
</main>
<!-- Modal de Mensaje -->
<div class="modal fade" id="modalMensaje" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="tituloModal">Mensaje</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body" id="cuerpoModal">
        Aquí va el mensaje dinámico
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
      </div>

    </div>
  </div>
</div>


<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
