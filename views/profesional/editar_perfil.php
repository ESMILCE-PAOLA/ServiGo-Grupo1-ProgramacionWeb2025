<?php
require_once __DIR__ . '/../../includes/guard_profesional.php';

$active = 'editar-perfil';

include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';

$idProfesional = $_GET['id'] ?? null;

if (!$idProfesional) {
  echo "<div class='container mt-5 text-danger'><h4>ID de profesional no especificado.</h4></div>";
  include_once __DIR__ . '/../../includes/footer.php';
  exit;
}
?>

<main class="container py-5">

    <h3 class="fw-bold mb-4">Editar perfil profesional</h3>

    <!-- 🔥 BLOQUE DE ERROR QUE FALTABA -->
    <div id="msgError" class="alert alert-danger d-none"></div>

    <form id="formEditar" enctype="multipart/form-data">

        <div class="row g-3">

            <!-- Nombre -->
            <div class="col-md-6">
                <label class="form-label">Nombre completo</label>
                <input type="text" class="form-control" id="nombre" required>
            </div>

            <!-- Localidad -->
            <div class="col-md-6">
                <label class="form-label">Localidad</label>
                <select id="localidad" class="form-select" required></select>
            </div>

            <!-- Experiencia -->
            <div class="col-md-6">
                <label class="form-label">Experiencia</label>
                <input type="text" class="form-control" id="experiencia" required>
            </div>

            <!-- Rubros -->
            <div class="col-md-6">
                <label class="form-label">Rubros / Especialidades</label>
                <select id="rubros" class="form-select" multiple required></select>
                <small class="text-muted">Mantener CTRL para seleccionar varios.</small>
            </div>

            <!-- Descripción -->
            <div class="col-12">
                <label class="form-label">Descripción personal</label>
                <textarea id="descripcion" class="form-control" rows="4" required></textarea>
            </div>

            <!-- Foto actual -->
            <div class="col-md-6">
                <label class="form-label">Foto de perfil</label>
                <input type="file" id="foto" class="form-control">

                <div class="mt-2">
                    <small class="text-muted">Imagen actual:</small><br>
                    <img id="fotoActual" src="" width="150" class="rounded border">
                </div>
            </div>

        </div>

        <!-- Botones -->
        <div class="d-flex gap-2 mt-4">
            <a href="<?= BASE_URL ?>/views/profesional/perfil_profesional.php?id=<?= $idProfesional ?>"
               class="btn btn-secondary">Volver</a>

            <button type="submit" class="btn btn-success">Guardar cambios</button>
        </div>

    </form>

</main>

<!-- VARIABLES PARA JS -->
<script>
    const ID_PROFESIONAL = <?= json_encode($idProfesional) ?>;
    const BASE_URL = "<?= BASE_URL ?>";
</script>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
