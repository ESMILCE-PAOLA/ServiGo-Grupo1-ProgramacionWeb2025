<?php
require_once __DIR__ . '/../../includes/guard_profesional.php';
$active = 'perfil';
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';

// Simulación: obtenemos datos del profesional logueado (después se conectará a la BD real)
$profesional = [
  'nombre' => $_SESSION['user']['nombre'] ?? 'Carlos López',
  'localidad' => 'González Catán',
  'experiencia' => '10+ años',
  'rubros' => ['Electricista', 'Plomero'],
  'puntuacion' => 4.8,
  'estado' => 'Activo',
  'foto' => BASE_URL . '/assets/img/profesionales/electricista_perfil.jpg',
  'descripcion' => 'Profesional con más de 10 años de experiencia en instalaciones eléctricas, mantenimiento y reparaciones. Me destaco por la puntualidad y la prolijidad en cada trabajo.'
];
?>

<main class="container my-5 text-light">
  <div class="row">
    <!-- Columna izquierda -->
    <div class="col-md-4 text-center">
      <img src="<?= htmlspecialchars($profesional['foto']) ?>" 
           class="img-fluid rounded-circle mb-3" alt="Foto Profesional" width="180">
      <h3><?= htmlspecialchars($profesional['nombre']) ?></h3>
      <p class="text-warning">⭐ Puntuación promedio: <?= $profesional['puntuacion'] ?></p>

      <!-- Card de información -->
      <div class="card text-start bg-dark border-secondary">
        <div class="card-body">
          <h5 class="card-title text-light">Información</h5>
          <p><i class="bi bi-briefcase"></i> Experiencia: <?= htmlspecialchars($profesional['experiencia']) ?></p>
          <p><i class="bi bi-person-badge"></i> Estado: 
            <span id="badgeEstado" class="badge bg-success"><?= htmlspecialchars($profesional['estado']) ?></span>
          </p>
          <p><i class="bi bi-geo-alt"></i> Localidad: <?= htmlspecialchars($profesional['localidad']) ?></p>
          <p><i class="bi bi-tools"></i> Rubros:
            <?php foreach ($profesional['rubros'] as $r): ?>
              <span class="badge bg-primary"><?= htmlspecialchars($r) ?></span>
            <?php endforeach; ?>
          </p>
        </div>
      </div>

      <!-- Botones del profesional -->
      <div class="mt-3 d-grid gap-2">
        <a href="<?= BASE_URL ?>/views/profesional/editar_perfil.php" 
           class="btn btn-outline-secondary w-100">
          <i class="bi bi-pencil-square"></i> Editar perfil
        </a>
      </div>

      <!-- Botones administrativos -->
      <div id="accionesAdmin" class="mt-3 d-none">
        <button id="btnBloquear" class="btn btn-danger w-100 mb-2">
          <i class="bi bi-slash-circle"></i> Bloquear
        </button>
        <button id="btnDesbloquear" class="btn btn-outline-danger d-none w-100">
          <i class="bi bi-unlock"></i> Desbloquear
        </button>
      </div>
    </div>

    <!-- Columna derecha -->
    <div class="col-md-8">
      <h4 class="text-light">Sobre mí</h4>
      <p><?= htmlspecialchars($profesional['descripcion']) ?></p>

      <h4 class="mt-4 text-light">Trabajos realizados</h4>
      <div id="carouselTrabajos" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="<?= BASE_URL ?>/assets/img/profesionales/trabajo1_tablero.jpg" 
                 class="d-block w-100 rounded" alt="Tablero eléctrico">
            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
              <h6>Reparación de tablero eléctrico</h6>
              <p>Comercio – Isidro Casanova</p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="<?= BASE_URL ?>/assets/img/profesionales/trabajo2_cableado.jpg" 
                 class="d-block w-100 rounded" alt="Cableado eléctrico">
            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
              <h6>Cableado estructural</h6>
              <p>Vivienda – González Catán</p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="<?= BASE_URL ?>/assets/img/profesionales/trabajo3_luminaria.jpg" 
                 class="d-block w-100 rounded" alt="Instalación luminaria">
            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
              <h6>Instalación de luminarias LED</h6>
              <p>Oficina – San Justo</p>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselTrabajos" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselTrabajos" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>
    </div>
  </div>
</main>

<!-- COMENTARIOS -->
<section class="container my-5 text-light">
  <h4>Opiniones de clientes</h4>
  <div class="list-group">
    <div class="list-group-item bg-dark text-light border-secondary">
      <strong>Juan Pérez</strong> – ⭐⭐⭐⭐⭐  
      <p>Muy buen trabajo, rápido y prolijo. Lo recomiendo.</p>
      <button class="btn btn-outline-danger btn-sm"><i class="bi bi-flag"></i> Denunciar comentario</button>
    </div>
    <div class="list-group-item bg-dark text-light border-secondary">
      <strong>María García</strong> – ⭐⭐⭐⭐☆  
      <p>Cumplió con lo pactado, pero tardó un poco en responder.</p>
      <button class="btn btn-outline-danger btn-sm"><i class="bi bi-flag"></i> Denunciar comentario</button>
    </div>
  </div>
  <div class="text-center mt-3">
    <a href="<?= BASE_URL ?>/views/profesional/reseñas.php" class="btn btn-outline-primary">Ver todas las reseñas</a>
  </div>
</section>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
