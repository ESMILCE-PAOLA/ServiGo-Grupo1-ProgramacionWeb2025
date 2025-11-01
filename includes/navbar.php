<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$rol = $_SESSION['user']['rol'] ?? 'visitante';
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
  <a class="navbar-brand fw-bold text-warning" href="/ServiGo/ServiGo-Grupo1-ProgramacionWeb2025/index.php">⚡ ServiGo</a>

  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ms-auto">

      <?php if ($rol === 'visitante'): ?>
        <li class="nav-item"><a class="nav-link" href="/ServiGo/ServiGo-Grupo1-ProgramacionWeb2025/views/visitante/index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="/ServiGo/ServiGo-Grupo1-ProgramacionWeb2025/views/visitante/login.php">Iniciar sesión</a></li>
        <li class="nav-item"><a class="nav-link" href="/ServiGo/ServiGo-Grupo1-ProgramacionWeb2025/views/visitante/registro.php">Registrarse</a></li>

      <?php elseif ($rol === 'cliente'): ?>
        <li class="nav-item"><a class="nav-link" href="/ServiGo/ServiGo-Grupo1-ProgramacionWeb2025/views/cliente/index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="/ServiGo/ServiGo-Grupo1-ProgramacionWeb2025/views/cliente/nueva_solicitud.php">Nueva solicitud</a></li>
        <li class="nav-item"><a class="nav-link" href="/ServiGo/ServiGo-Grupo1-ProgramacionWeb2025/views/cliente/presupuestos.php">Presupuestos</a></li>
        <li class="nav-item"><a class="nav-link" href="/ServiGo/ServiGo-Grupo1-ProgramacionWeb2025/views/cliente/perfil.php">Mi perfil</a></li>

      <?php elseif ($rol === 'profesional'): ?>
        <li class="nav-item"><a class="nav-link" href="/ServiGo/ServiGo-Grupo1-ProgramacionWeb2025/views/profesional/index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="/ServiGo/ServiGo-Grupo1-ProgramacionWeb2025/views/profesional/solicitudes-profesional.php">Solicitudes</a></li>
        <li class="nav-item"><a class="nav-link" href="/ServiGo/ServiGo-Grupo1-ProgramacionWeb2025/views/profesional/crear_presupuesto.php">Presupuestos</a></li>
        <li class="nav-item"><a class="nav-link" href="/ServiGo/ServiGo-Grupo1-ProgramacionWeb2025/views/profesional/perfil_profesional.php">Mi perfil</a></li>

      <?php elseif ($rol === 'administrador'): ?>
        <li class="nav-item"><a class="nav-link" href="/ServiGo/ServiGo-Grupo1-ProgramacionWeb2025/views/administrador/index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="/ServiGo/ServiGo-Grupo1-ProgramacionWeb2025/views/administrador/GestionUsuarios.php">Usuarios</a></li>
        <li class="nav-item"><a class="nav-link" href="/ServiGo/ServiGo-Grupo1-ProgramacionWeb2025/views/administrador/GestionDenuncias.php">Denuncias</a></li>
        <li class="nav-item"><a class="nav-link" href="/ServiGo/ServiGo-Grupo1-ProgramacionWeb2025/views/administrador/perfil_administrador.php">Mi perfil</a></li>
      <?php endif; ?>

      <?php if ($rol !== 'visitante'): ?>
        <li class="nav-item"><a class="nav-link text-danger" href="/ServiGo/ServiGo-Grupo1-ProgramacionWeb2025/backend/api/auth/logout.php">Cerrar sesión</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
