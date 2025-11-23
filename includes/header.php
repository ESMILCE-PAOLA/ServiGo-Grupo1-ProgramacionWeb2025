<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ServiGo</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS Global -->
  <link rel="stylesheet" href="/ServiGo-Grupo1-ProgramacionWeb2025/assets/css/style.css">
  <link rel="icon" href="/ServiGo-Grupo1-ProgramacionWeb2025/assets/img/logo.png">

  <!-- ===== Scripts específicos según la vista ===== -->
  <?php if (isset($active)): ?>
    <?php if ($active === 'solicitudes'): ?>
      <script src="/ServiGo-Grupo1-ProgramacionWeb2025/assets/js/profesional.js" defer></script>
    <?php elseif ($active === 'perfil'): ?>
      <script src="/ServiGo-Grupo1-ProgramacionWeb2025/assets/js/perfil.js" defer></script>
    <?php elseif ($active === 'cliente'): ?>
      <script src="/ServiGo-Grupo1-ProgramacionWeb2025/assets/js/cliente.js" defer></script>
    <?php endif; ?>
  <?php endif; ?>
</head>

<body class="bg-light text-dark">
