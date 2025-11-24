<?php
require_once __DIR__ . '/../backend/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ServiGo</title>

  <!-- CSS GLOBAL -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/app.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="icon" href="<?= BASE_URL ?>/assets/img/logo.png">

  <!-- GLOBAL JS VAR -->
  <script>
    window.BASE_URL = "<?= BASE_URL ?>";
  </script>

  <!-- CSS por vista -->
  <?php if (isset($active)): ?>
    <?php if ($active === 'perfil'): ?>
      <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/perfil_profesional.css">

    <?php elseif ($active === 'editar-perfil'): ?>
      <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/perfil_profesional.css">

    <?php elseif ($active === 'solicitudes'): ?>
      <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/solicitudes.css">

    <?php elseif ($active === 'detalle-solicitud'): ?>
      <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/detalle_solicitud.css">

    <?php elseif ($active === 'crear-presupuesto'): ?>
      <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/crear_presupuesto.css">

    <?php elseif ($active === 'ver-presupuesto'): ?>
      <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/ver_presupuesto.css">
    <?php endif; ?>
  <?php endif; ?>

  <!-- JS por vista -->
  <?php if (isset($active)): ?>
    <?php if ($active === 'perfil'): ?>
      <script src="<?= BASE_URL ?>/assets/js/profesional/perfil_profesional.js?v=<?= time() ?>" defer></script>

    <?php elseif ($active === 'editar-perfil'): ?>
      <script src="<?= BASE_URL ?>/assets/js/profesional/editar_perfil.js?v=<?= time() ?>" defer></script>

    <?php elseif ($active === 'solicitudes'): ?>
      <script src="<?= BASE_URL ?>/assets/js/profesional/solicitudes.js?v=<?= time() ?>" defer></script>

    <?php elseif ($active === 'detalle-solicitud'): ?>
      <script src="<?= BASE_URL ?>/assets/js/profesional/detalle-solicitud.js?v=<?= time() ?>" defer></script>

    <?php elseif ($active === 'crear-presupuesto'): ?>
      <script src="<?= BASE_URL ?>/assets/js/profesional/crear-presupuesto.js?v=<?= time() ?>" defer></script>

    <?php elseif ($active === 'ver-presupuesto'): ?>
      <script src="<?= BASE_URL ?>/assets/js/profesional/ver-presupuesto.js?v=<?= time() ?>" defer></script>
    <?php endif; ?>
  <?php endif; ?>

  <!-- JS global: denuncias -->
  <script src="<?= BASE_URL ?>/assets/js/denuncias/denunciar.js?v=<?= time() ?>" defer></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body class="bg-light text-dark">
