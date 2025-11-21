<?php require __DIR__.'/includes/header.php'; ?>
<?php require __DIR__.'/includes/navbar.php'; ?>
<main class="container">
  <div class="grid cols-3">
    <div class="card">
      <h2>Cliente</h2>
      <p>Publicá solicitudes, recibí presupuestos y chateá con profesionales.</p>
      <a class="btn primary" href="/ServiGo/views/cliente/dashboard.php">Entrar</a>
    </div>
    <div class="card">
      <h2>Profesional</h2>
      <p>Respondé solicitudes cercanas, enviá presupuestos y gestioná tu reputación.</p>
      <a class="btn primary" href="/ServiGo/views/profesional/dashboard.php">Entrar</a>
    </div>
    <div class="card">
      <h2>Administrador</h2>
      <p>Gestioná usuarios, moderación y métricas del sistema.</p>
      <a class="btn primary" href="/ServiGo/views/administrador/dashboard.php">Entrar</a>
    </div>
  </div>
</main>
<?php require __DIR__.'/includes/footer.php'; ?>
