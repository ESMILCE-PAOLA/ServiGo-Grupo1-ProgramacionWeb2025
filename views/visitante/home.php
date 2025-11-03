<?php 
  __DIR__ . include_once("../../backend/db.php");

$sql = "SELECT * FROM localidades";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$localidades = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ServiGO - Home Visitante</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> 


  <link rel="stylesheet" href="../../assets/css/home.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script defer src="../../assets/js/visitante/Profesionales.js"></script>
</head>
<body>


<?php require __DIR__ . '/../../includes/header.php'; ?>
<?php require __DIR__ . '/../../includes/navbar.php';?>


  <!--Foto de Entrada-->
    <section>
      <div>
        <img src="../../assets/img/FotoEntrada.jpeg" alt="">
      </div>
    </section>

  <!-- Contenido -->
  <div class="container mt-4">
    <h4 class="mb-3 text-white">Profesionales destacados</h4>

    <!-- Barra de filtros y búsqueda -->
    <div class="filter-bar">
      <form class="row g-2 align-items-center">
        <div class="col-md-6 col-sm-12">
          <label for="servicio" class="form-label mb-1">Filtrar por servicio</label>
          <select id="servicio" class="form-select">
            <option value="">Todos</option>
            <option value="electricista">Electricista</option>
            <option value="plomero">Plomero</option>
            <option value="pintor">Pintor</option>
            <option value="carpintero">Carpintero</option>
            <option value="gasista">Gasista</option>
          </select>
        </div>

         <div class="col-md-6 col-sm-12">
          <label for="Localidad" class="form-label mb-1">Filtrar por Localidad</label>
          <select id="Localidad" class="form-select">
            <option value="">Elige una Localidad</option>
                <?php
                    foreach ($localidades as $localidad) {
                        echo '<option value="' . $localidad["id"] . '">' . $localidad["nombre"] .'</option>';
                    }
                ?>
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

    <!-- Lista de profesionales -->
       <div id="AlertaNoProf" class="alert alert-warning d-none">
        <strong>Lo lamentamos</strong> No hay profesionales disponibles para mostrar
      </div>

      <div id="contenedorTabla"></div>

    <div class="alert alert-info mt-3 text-center">
      Para aplicar filtros o ver más información debes registrarte o iniciar sesión.
    </div>
  </div>


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

<?php require __DIR__ . '/../../includes/footer.php';?>

</html>