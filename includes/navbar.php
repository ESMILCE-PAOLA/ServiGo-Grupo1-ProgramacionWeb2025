<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$rol = $_SESSION['user']['rol'] ?? 'visitante';

// Cargar configuración
require_once __DIR__ . '/../backend/config.php';

// BASE_URL viene definida como constante
$BASE = BASE_URL;
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
  <a class="navbar-brand fw-bold text-warning" href="<?= $BASE ?>/views/visitante/home.php">⚡ ServiGo</a>

  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ms-auto">

      <?php if ($rol === 'visitante'): ?>
        <li class="nav-item"><a class="nav-link" href="<?= $BASE ?>/views/login.php">Iniciar sesión</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $BASE ?>/views/registro.php">Registrarse</a></li>

      <?php elseif ($rol === 'cliente'): ?>
        <li class="nav-item"><a class="nav-link" href="<?= $BASE ?>/views/cliente/index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $BASE ?>/views/cliente/nueva_solicitud.php">Nueva solicitud</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $BASE ?>/views/cliente/presupuestos.php">Presupuestos</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $BASE ?>/views/cliente/perfil.php">Mi perfil</a></li>

      <?php elseif ($rol === 'profesional'): ?>
        <li class="nav-item"><a class="nav-link" href="<?= $BASE ?>/views/profesional/index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $BASE ?>/views/profesional/solicitudes-profesional.php">Solicitudes</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $BASE ?>/views/profesional/perfil_profesional.php">Mi perfil</a></li>

      <?php elseif ($rol === 'administrador'): ?>
        <li class="nav-item"><a class="nav-link" href="<?= $BASE ?>/views/administrador/index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $BASE ?>/views/administrador/GestionUsuarios.php">Usuarios</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $BASE ?>/views/administrador/GestionDenuncias.php">Denuncias</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $BASE ?>/views/administrador/perfil_administrador.php">Mi perfil</a></li>
      <?php endif; ?>

      <?php if ($rol !== 'visitante'): ?>
        <li class="nav-item"><a class="nav-link text-danger" href="<?= $BASE ?>/backend/api/auth/logout.php">Cerrar sesión</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
