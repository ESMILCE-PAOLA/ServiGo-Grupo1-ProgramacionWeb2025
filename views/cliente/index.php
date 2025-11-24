<?php
//require_once __DIR__ . '/../../includes/guard_cliente.php';
$active = 'solicitudes';
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Mis Solicitudes</h2>
        <a href="nueva_solicitud.php" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nueva Solicitud
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Título</th>
                        <th>Localidad</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="tablaSolicitudes">
                    <tr><td colspan="5" class="text-center py-4">Cargando...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>/assets/js/cliente/index.js?v=<?= time() ?>"></script>
<?php include_once __DIR__ . '/../../includes/footer.php'; ?>