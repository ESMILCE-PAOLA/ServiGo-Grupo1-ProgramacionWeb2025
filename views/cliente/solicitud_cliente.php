<?php
//require_once __DIR__ . '/../../includes/guard_cliente.php';
$active = 'detalle-solicitud';
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';
// Capturamos ID de la URL
//$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
?>

<div class="container py-5">
    <a href="index.php" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Volver al listado
    </a>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h3 class="card-title text-primary" id="titulo">Cargando...</h3>
                <span class="badge bg-secondary align-self-start" id="estado">...</span>
            </div>
            <p class="lead mt-3" id="descripcion"></p>
            <hr>
            <div class="row text-muted">
                <div class="col-md-6">
                    <i class="bi bi-geo-alt-fill"></i> <span id="direccion"></span>, <span id="localidad"></span>
                </div>
                <div class="col-md-6 text-md-end">
                    <i class="bi bi-calendar-event"></i> Publicado el: <span id="fecha"></span>
                </div>
            </div>
        </div>
    </div>

    <h4 class="mb-3">Presupuestos Recibidos</h4>
    <div id="listaPresupuestos" class="row">
        <div class="col-12"><div class="alert alert-info">Cargando presupuestos...</div></div>
    </div>
</div>

<script>const ID_SOLICITUD = <?= $id ?>;</script>
<script src="<?= BASE_URL ?>/assets/js/cliente/detalle-solicitud.js?v=<?= time() ?>"></script>
<?php include_once __DIR__ . '/../../includes/footer.php'; ?>