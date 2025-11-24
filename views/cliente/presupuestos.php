<?php
//require_once __DIR__ . '/../../includes/guard_cliente.php';
$active = 'solicitudes';
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';
?>

<div class="container py-5">
    <h2 class="mb-4">📌 Mis Solicitudes y Presupuestos</h2>
    <div class="table-responsive card shadow-sm p-3">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Fecha</th>
                    <th>Título</th>
                    <th>Localidad</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaSolicitudes">
                <tr><td colspan="5" class="text-center">Cargando...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<script src="<?= BASE_URL ?>/assets/js/cliente/presupuestos.js?v=<?= time() ?>"></script>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>