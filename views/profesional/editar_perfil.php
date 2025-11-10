<?php
require_once __DIR__ . '/../../includes/guard_profesional.php';
$active = 'perfil';
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';

// Datos simulados hasta conectar con la base
$profesional = [
  'nombre' => $_SESSION['user']['nombre'] ?? 'Carlos López',
  'localidad' => 'González Catán',
  'experiencia' => '10+ años',
  'rubros' => 'Electricista, Plomero',
  'descripcion' => 'Profesional con más de 10 años de experiencia en instalaciones eléctricas, mantenimiento y reparaciones.',
  'foto' => BASE_URL . '/assets/img/profesionales/electricista_perfil.jpg'
];
?>

<main class="container py-4 text-light">
  <h2 class="mb-4 text-light">Editar Perfil Profesional</h2>

  <form id="formEditarPerfil" enctype="multipart/form-data" class="row g-4 bg-dark p-4 rounded border border-secondary">

    <div class="col-md-6">
      <label for="nombre" class="form-label">Nombre completo</label>
      <input type="text" id="nombre" name="nombre" class="form-control"
             value="<?= htmlspecialchars($profesional['nombre']) ?>" required>
    </div>

    <div class="col-md-6">
      <label for="localidad" class="form-label">Localidad</label>
      <select id="localidad" name="localidad" class="form-select" required>
        <option value="González Catán" selected>González Catán</option>
        <option value="San Justo">San Justo</option>
        <option value="Morón">Morón</option>
        <option value="Lanús">Lanús</option>
        <option value="Moreno">Moreno</option>
      </select>
    </div>

    <div class="col-md-6">
      <label for="experiencia" class="form-label">Experiencia</label>
      <input type="text" id="experiencia" name="experiencia" class="form-control"
             value="<?= htmlspecialchars($profesional['experiencia']) ?>" placeholder="Ej: 5 años, 10+ años, etc.">
    </div>

    <div class="col-md-6">
      <label for="rubros" class="form-label">Rubros / Especialidades</label>
      <input type="text" id="rubros" name="rubros" class="form-control"
             value="<?= htmlspecialchars($profesional['rubros']) ?>" placeholder="Ej: Electricista, Plomero">
    </div>

    <div class="col-12">
      <label for="descripcion" class="form-label">Descripción personal</label>
      <textarea id="descripcion" name="descripcion" class="form-control" rows="4"
                placeholder="Contá brevemente tus habilidades, servicios o experiencia."><?= htmlspecialchars($profesional['descripcion']) ?></textarea>
    </div>

    <div class="col-md-6">
      <label for="foto" class="form-label">Foto de perfil</label>
      <input type="file" id="foto" name="foto" class="form-control" accept="image/*">
    </div>

    <div class="col-md-6 text-center">
      <img src="<?= htmlspecialchars($profesional['foto']) ?>" 
           alt="Foto actual" class="rounded-circle border mt-2" width="120">
      <p class="small text-secondary mt-1">Imagen actual</p>
    </div>

    <div class="col-12 text-end mt-3">
      <a href="<?= BASE_URL ?>/views/profesional/perfil_profesional.php" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Volver
      </a>
      <button type="submit" class="btn btn-success">
        <i class="bi bi-save"></i> Guardar cambios
      </button>
    </div>
  </form>

  <div id="mensaje" class="mt-3 text-center"></div>
</main>

<script src="<?= BASE_URL ?>/assets/js/profesional/editar_perfil.js" defer></script>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
