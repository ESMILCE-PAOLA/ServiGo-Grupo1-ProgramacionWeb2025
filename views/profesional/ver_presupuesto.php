<?php
require_once __DIR__ . '/../../includes/guard_profesional.php';
$active = 'ver-presupuesto';
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';

$idPresupuesto = $_GET['id'] ?? 0;

if (!$idPresupuesto) {
  echo "<div class='container mt-5 text-center'>
          <h4 class='text-danger'>Presupuesto no especificado.</h4>
          <a href='solicitudes-profesional.php' class='btn btn-outline-dark mt-3'>Volver</a>
        </div>";
  include_once __DIR__ . '/../../includes/footer.php';
  exit;
}
?>

<div class="container py-4 text-light">
  <h2 class="mb-4">
    <i class="bi bi-file-earmark-text"></i> Presupuesto Enviado
  </h2>

  <div id="contenedorPresupuesto" class="card bg-dark shadow-sm p-4">
    <p class="text-center text-secondary">Cargando presupuesto...</p>
  </div>

  <div class="mt-4">
    <a id="btnVolver" href="#" class="btn btn-secondary">
      <i class="bi bi-arrow-left"></i> Volver a la solicitud
    </a>
  </div>
</div>

<script src="<?= BASE_URL ?>/assets/js/profesional/ver_presupuesto.js?v=<?= time() ?>"></script>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
