<?php
require_once __DIR__ . '/../../includes/guard_profesional.php';
$active = 'inicio';
?>
<?php include_once __DIR__ . '/../../includes/header.php'; ?>
<?php include_once __DIR__ . '/../../includes/navbar.php'; ?>


<main class="text-light">

  <!-- HERO / BANNER PRINCIPAL -->
  <header class="hero text-white text-center bg-primary">
    <div class="container py-5">
      <h1 class="display-5 fw-bold">¡Impulsá tu presencia como profesional!</h1>
      <p class="lead mb-4">
        Mantené tu perfil siempre actualizado, respondé rápido y brindá el mejor servicio.
        Así tus clientes te puntúan mejor y aparecés entre los profesionales destacados.
      </p>
    </div>
  </header>

  <!-- SECCIÓN DESTACADOS -->
  <section class="container my-5">
    <h2 class="text-center mb-4 text-dark">Profesionales destacados</h2>
    <p class="text-center text-secondary">Estos son los colegas mejor valorados. ¡Vos también podés estar acá!</p>

    <div class="row g-4" id="gridProfesionales">
      <!-- Cards de profesionales generadas por JS -->
      <div class="col-md-4">
        <div class="card shadow-sm border-0">
          <img src="/ServiGo/assets/img/profesionales/electricista.jpg" class="card-img-top" alt="Electricista">
          <div class="card-body">
            <h5 class="card-title mb-0">Carlos López</h5>
            <small class="text-primary">Electricista · González Catán</small>
            <div class="mt-2">
              <span class="text-warning"><i class="bi bi-star-fill"></i> 4.8</span>
            </div>
            <a href="#" class="btn btn-outline-primary w-100 mt-3">Ver perfil</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card shadow-sm border-0">
          <img src="/ServiGo/assets/img/profesionales/plomero.jpg" class="card-img-top" alt="Plomera">
          <div class="card-body">
            <h5 class="card-title mb-0">Ana Torres</h5>
            <small class="text-primary">Plomera · San Justo</small>
            <div class="mt-2">
              <span class="text-warning"><i class="bi bi-star-fill"></i> 4.6</span>
            </div>
            <a href="#" class="btn btn-outline-primary w-100 mt-3">Ver perfil</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card shadow-sm border-0">
          <img src="/ServiGo/assets/img/profesionales/carpintero.jpg" class="card-img-top" alt="Carpintero">
          <div class="card-body">
            <h5 class="card-title mb-0">Martín Díaz</h5>
            <small class="text-primary">Carpintero · Morón</small>
            <div class="mt-2">
              <span class="text-warning"><i class="bi bi-star-fill"></i> 4.9</span>
            </div>
            <a href="#" class="btn btn-outline-primary w-100 mt-3">Ver perfil</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- SECCIÓN FINAL -->
  <section class="text-white text-center py-5 mt-5 bg-dark">
    <div class="container">
      <h2 class="fw-bold">Un mundo de servicios te espera</h2>
      <p class="lead mb-4">Atendé solicitudes, hacé crecer tu reputación y destacate en ServiGo.</p>
  </section>
</main>

<!-- Modal de aviso (igual que en front-end) -->
<div class="modal fade" id="modalAviso" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Acceso restringido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Para ver perfiles completos debés ingresar como <strong>Cliente</strong>.<br>
        Actualmente estás en tu cuenta de <strong>Profesional</strong>.
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Entendido</button>
      </div>
    </div>
  </div>
</div>


<?php include_once __DIR__ . '/../../includes/footer.php'; ?>