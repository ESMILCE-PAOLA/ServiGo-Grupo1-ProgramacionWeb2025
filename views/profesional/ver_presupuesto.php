<?php
require_once __DIR__ . '/../../includes/guard_profesional.php';
require_once __DIR__ . '/../../includes/db.php';

$active = 'ver-presupuesto';
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';

$idSolicitud = intval($_GET['id'] ?? 0);

if ($idSolicitud <= 0) {
  echo "<div class='container mt-5 text-center text-danger'>
          <h4>Solicitud inválida.</h4>
          <a href='solicitudes-profesional.php' class='btn btn-outline-light mt-3'>Volver</a>
        </div>";
  include_once __DIR__ . '/../../includes/footer.php';
  exit;
}

// ===============================
// Buscar presupuesto REAL
// ===============================
$sql = "SELECT id 
        FROM presupuestos 
        WHERE solicitud_id = :solicitud_id 
          AND profesional_id = :profesional_id
        LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':solicitud_id'   => $idSolicitud,
    ':profesional_id' => $_SESSION['user']['id']   // ← CORRECTO
]);

$pres = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pres) {
    echo "<div class='container mt-5 text-center text-warning'>
            <h4>No existe un presupuesto para esta solicitud.</h4>
            <a href='detalle-solicitud.php?id=$idSolicitud' class='btn btn-outline-light mt-3'>Volver a la solicitud</a>
          </div>";
    include_once __DIR__ . '/../../includes/footer.php';
    exit;
}

$idPresupuesto = $pres['id'];
?>

<script>
  window.ID_PRESUPUESTO = <?= $idPresupuesto ?>;
</script>

<script src="<?= BASE_URL ?>/assets/js/profesional/ver-presupuesto.js?v=<?= time() ?>" defer></script>

<div class="container py-4 text-light">
  <h2 class="mb-4">
    <i class="bi bi-file-earmark-text"></i> Presupuesto enviado
  </h2>

  <div id="contenedorPresupuesto" class="card bg shadow-sm p-4">
    <p class="text-center text-secondary">Cargando presupuesto...</p>
  </div>

  <div class="mt-4">
    <a href="detalle-solicitud.php?id=<?= $idSolicitud ?>" class="btn btn-secondary">
      <i class="bi bi-arrow-left"></i> Volver a la solicitud
    </a>
  </div>
</div>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
