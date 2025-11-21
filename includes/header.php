<?php
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ServiGo</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap JS (bundle con Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

  <!-- CSS Global -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
  <?php if (isset($active) && in_array($active, ['solicitudes','detalle-solicitud','perfil'])): ?>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/profesional.css">
  <?php endif; ?>

  <link rel="icon" href="<?= BASE_URL ?>/assets/img/logo.png">

  <!-- Variable global BASE_URL para JS -->
  <script>
    window.BASE_URL = "<?= BASE_URL ?>";
  </script>

  <!-- ===== Scripts específicos según la vista ===== -->
  <?php if (isset($active)): ?>
    <?php if ($active == 'solicitudes'): ?>
      <script src="<?= BASE_URL ?>/assets/js/profesional/solicitudes.js?v=<?= time() ?>" defer></script>

    <?php elseif ($active == 'perfil'): ?>
      <script src="<?= BASE_URL ?>/assets/js/profesional/perfil.js?v=<?= time() ?>" defer></script>

    <?php elseif ($active == 'cliente'): ?>
      <script src="<?= BASE_URL ?>/assets/js/cliente.js?v=<?= time() ?>" defer></script>

    <?php elseif ($active == 'detalle-solicitud'): ?>
      <script src="<?= BASE_URL ?>/assets/js/profesional/detalle-solicitud.js?v=<?= time() ?>" defer></script>
    <?php endif; ?>
  <?php endif; ?>
</head>

<body class="bg-light text-dark">
