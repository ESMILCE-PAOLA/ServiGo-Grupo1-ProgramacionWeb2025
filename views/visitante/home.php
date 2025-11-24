<?php
require_once __DIR__ . '/../../includes/db.php';


$sql = "SELECT * FROM localidades";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$localidades = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM rubros";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$rubros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ServiGO - Home Visitante</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> 

  <link rel="stylesheet" href="../../assets/css/home.css">
  <script defer src="../../assets/js/visitante/Profesionales.js"></script>
</head>
<body>

<?php require __DIR__ . '/../../includes/header.php'; ?>
<?php require __DIR__ . '/../../includes/navbar.php'; ?>

<!-- Foto de Entrada -->
<section>
  <div>
    <img src="../../assets/img/FotoEntrada.jpeg" class="w-100" alt="Portada">
  </div>
</section>

<!-- Contenido -->
<div class="container mt-4">
  <h4 class="mb-3 text-white">Profesionales destacados</h4>

  <!-- Barra de filtros -->
  <div class="filter-bar">
    <form class="row g-2 align-items-center">

      <div class="col-md-6 col-sm-12">
        <label for="servicio" class="form-label mb-1">Filtrar por servicio</label>
        <select id="servicio" class="form-select">
          <option value="">Elige un rubro</option>
          <?php foreach ($rubros as $r): ?>
            <option value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-6 col-sm-12">
        <label for="Localidad" class="form-label mb-1">Filtrar por localidad</label>
        <select id="Localidad" class="form-select">
          <option value="">Elige una localidad</option>
          <?php foreach ($localidades as $l): ?>
            <option value="<?= $l['id'] ?>"><?= $l['nombre'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-6 col-sm-12">
        <label for="buscar" class="form-label mb-1">Buscar profesional</label>
        <div class="input-group">
          <input type="text" id="buscar" class="form-control" placeholder="Ej: Juan Pérez, plomería, etc.">
          <button class="btn btn-primary" type="button">Buscar</button>
        </div>
      </div>

    </form>
  </div>

  <!-- Mensajes -->
  <div id="AlertaNoProf" class="alert alert-warning d-none mt-3">
    <strong>Lo lamentamos</strong> No hay profesionales disponibles para mostrar
  </div>

  <div id="contenedorTabla"></div>

  <div class="alert alert-info mt-3 text-center">
    Para aplicar filtros o ver más información debes registrarte o iniciar sesión.
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ProfModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Detalle del profesional</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body" id="modalContenido">
        Cargando información...
      </div>

    </div>
  </div>
</div>

<?php require __DIR__ . '/../../includes/footer.php'; ?>

</body>
</html>
