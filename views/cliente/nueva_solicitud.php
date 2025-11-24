<?php
//require_once __DIR__ . '/../../includes/guard_cliente.php';
$active = 'nueva_solicitud';
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Crear Solicitud de Servicio</h5>
                </div>
                <div class="card-body">
                    <form id="formNueva">
                        <div class="mb-3">
                            <label class="form-label">Título del problema</label>
                            <input type="text" name="titulo" class="form-control" required placeholder="Ej: Pérdida de agua">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción detallada</label>
                            <textarea name="descripcion" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Localidad</label>
                                <select name="id_localidad" id="selectLocalidad" class="form-select" required>
                                    <option value="">Cargando...</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Dirección</label>
                                <input type="text" name="direccion" class="form-control" required>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Publicar Solicitud</button>
                            <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
                        </div>
                    </form>
                    <div id="alerta" class="alert mt-3 d-none"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>/assets/js/cliente/nueva-solicitud.js?v=<?= time() ?>"></script>
<?php include_once __DIR__ . '/../../includes/footer.php'; ?>