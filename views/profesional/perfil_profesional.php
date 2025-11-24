<?php
// ================================
// ACCESO SEGÚN ROL
// ================================

session_start();
$rol = $_SESSION['user']['rol'] ?? 'visitante';

// Visitante NO puede ver perfiles → redirige a login
if ($rol === 'visitante') {
    header("Location: /ServiGo/ServiGo-Grupo1-ProgramacionWeb2025/views/login.php");
    exit;
}

// Cliente y profesional pueden ver este perfil.
// Administrador también si lo requieren.

// ================================
// INCLUDES
// ================================
$active = 'perfil';
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';

// ================================
// OBTENER ID DEL PROFESIONAL
// ================================
$idProfesional = $_GET['id'] ?? null;

if (!$idProfesional) {
    echo "<div class='container mt-5'><h4 class='text-danger'>ID de profesional no especificado.</h4></div>";
    include_once __DIR__ . '/../../includes/footer.php';
    exit;
}

// ================================
// ¿ES SU PROPIO PERFIL?
// ================================
$esMiPerfil = (
    isset($_SESSION['user']['profesional_id']) &&
    $_SESSION['user']['profesional_id'] == $idProfesional
);
?>

<main class="container py-5">

  <div class="row g-4">

    <!-- ============================
         COLUMNA IZQUIERDA
    ============================= -->
    <div class="col-lg-4 text-center">

      <!-- Foto -->
      <img id="fotoPerfil" class="foto-perfil mb-3" src="" alt="Foto del profesional">

      <!-- Nombre -->
      <h3 id="nombreProfesional" class="fw-bold"></h3>

      <!-- Puntuación -->
      <p class="text-warning">
        <i class="bi bi-star-fill"></i> Puntuación promedio: <span id="promedio"></span>
      </p>

      <!-- Información -->
      <div class="card shadow-sm">
        <div class="card-body text-start">

          <h5 class="fw-bold mb-3">Información</h5>

          <p><i class="bi bi-briefcase"></i> Experiencia: <span id="experiencia"></span></p>

          <p>
            <i class="bi bi-person-badge"></i> Estado:
            <span id="estado" class="badge"></span>
          </p>

          <p><i class="bi bi-geo-alt"></i> Localidad: <span id="localidad"></span></p>

          <p><i class="bi bi-tools"></i> Rubros: <span id="rubros"></span></p>
        </div>
      </div>

      <!-- ============================
           BOTONES
      ============================= -->
      <div class="d-grid gap-2 mt-3">

        <?php if (!$esMiPerfil && $rol === 'cliente'): ?>
          <!-- BOTONES PARA CLIENTE -->
          <button class="btn btn-warning" id="btnFavorito">
            <i class="bi bi-star"></i> Agregar a Favoritos
          </button>

          <button class="btn btn-outline-danger" id="btnDenunciar">
            <i class="bi bi-flag"></i> Denunciar perfil
          </button>

          <button class="btn btn-primary" id="btnPresupuesto">
            <i class="bi bi-file-earmark-text"></i> Solicitar presupuesto
          </button>
        <?php endif; ?>

        <?php if ($esMiPerfil && $rol === 'profesional'): ?>
          <!-- BOTÓN DE PROFESIONAL -->
          <a href="<?= BASE_URL ?>/views/profesional/editar_perfil.php?id=<?= $idProfesional ?>"
             class="btn btn-outline-secondary">
            <i class="bi bi-pencil-square"></i> Editar información
          </a>
        <?php endif; ?>

      </div>

    </div> <!-- FIN COLUMNA IZQUIERDA -->

    <!-- ============================
         COLUMNA DERECHA
    ============================= -->
    <div class="col-lg-8">

      <!-- Sobre mí -->
      <h4 class="fw-bold">Sobre mí</h4>
      <p id="descripcion" class="mb-4"></p>

      <!-- Trabajos realizados -->
      <h4 class="fw-bold">Trabajos realizados</h4>

      <div id="carouselTrabajos" class="carousel slide mt-3" data-bs-ride="carousel">
        <div class="carousel-inner" id="trabajosCarousel"></div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselTrabajos" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#carouselTrabajos" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>

      <!-- Reseñas -->
      <h4 class="fw-bold mt-5">Opiniones de clientes</h4>

      <div id="listaResenas" class="list-group mt-3"></div>

      <div class="text-center mt-3">
        <a href="<?= BASE_URL ?>/views/profesional/resenas.php?id=<?= $idProfesional ?>" class="btn btn-outline-primary">
          Ver todas las reseñas
        </a>
      </div>

    </div>

  </div>

</main>

<!-- Variables globales para JS -->
<script>
  const ID_PROFESIONAL = <?= json_encode($idProfesional) ?>;
  const BASE_URL = "<?= BASE_URL ?>";
  const ES_MI_PERFIL = <?= json_encode($esMiPerfil) ?>;
  const ROL_USUARIO = "<?= $rol ?>";
</script>

<script>
    window.ID_DENUNCIADO = <?= json_encode($idProfesional) ?>;
    window.ID_SOLICITUD = 0;
</script>

<?php 
  include_once __DIR__ . '/../../includes/modales/modal_denuncia.php';
?>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
