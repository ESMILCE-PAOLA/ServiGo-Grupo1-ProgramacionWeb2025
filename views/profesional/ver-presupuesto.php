<?php
require_once __DIR__ . '/../../includes/header.php';
?>

<div class="container py-4">
    <h3 class="mb-4">Presupuesto Enviado</h3>

    <div id="presupuestoContainer" class="card p-3"></div>

    <a href="detalle-solicitud.php?id=<?= $_GET['id_solicitud'] ?>" class="btn btn-secondary mt-3">
        Volver
    </a>
</div>

<script src="<?= BASE_URL ?>/assets/js/profesional/ver-presupuesto.js"></script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
