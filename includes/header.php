<?php
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ServiGo</title>
  
    <!-- CSS Global -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/app.css">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


  <!-- Bootstrap JS (bundle con Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>



  <?php
    // HOJAS DE ESTILO EXCLUSIVAS PARA PROFESIONAL
    $css_profesional = [
      'solicitudes',
      'detalle-solicitud',
      'perfil',
      'crear-presupuesto',
      'ver-presupuesto'
    ];

    if (isset($active) && in_array($active, $css_profesional)):
  ?>
      <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/profesional.css">
  <?php endif; ?>

  <!-- Favicon -->
  <link rel="icon" href="<?= BASE_URL ?>/assets/img/logo.png">

  <!-- Variable global BASE_URL para JS -->
  <script>
    window.BASE_URL = "<?= BASE_URL ?>";
  </script>

  <!-- Scripts según la vista -->
  <?php if (isset($active)): ?>

      <?php if ($active === 'solicitudes'): ?>
          <script src="<?= BASE_URL ?>/assets/js/profesional/solicitudes.js?v=<?= time() ?>" defer></script>

      <?php elseif ($active === 'perfil'): ?>
          <script src="<?= BASE_URL ?>/assets/js/profesional/perfil.js?v=<?= time() ?>" defer></script>

      <?php elseif ($active === 'cliente'): ?>
          <script src="<?= BASE_URL ?>/assets/js/cliente.js?v=<?= time() ?>" defer></script>

      <?php elseif ($active === 'detalle-solicitud'): ?>
          <script src="<?= BASE_URL ?>/assets/js/profesional/detalle-solicitud.js?v=<?= time() ?>" defer></script>

      <?php elseif ($active === 'crear-presupuesto'): ?>
          <script src="<?= BASE_URL ?>/assets/js/profesional/crear-presupuesto.js?v=<?= time() ?>" defer></script>

      <?php endif; ?>

  <?php endif; ?>

</head>

<body class="bg-light text-dark">
