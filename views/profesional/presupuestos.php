<?php
require_once __DIR__ . '/../../includes/guard_profesional.php';
$active = 'presupuestos';
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';
?>
<link rel="stylesheet" href="/ServiGo/assets/css/profesional.css">

<div class="container py-4 text-light">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold m-0">Mis presupuestos</h3>
    <button id="btnRefrescarPres" class="btn btn-outline-light btn-sm">Actualizar</button>
  </div>

  <div id="listaPresupuestos" class="row g-3"></div>

  <template id="tpl-presupuesto">
    <div class="col-12">
      <div class="card bg-dark">
        <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
          <div>
            <div class="fw-bold"></div>
            <div class="small text-secondary"></div>
          </div>
          <div class="text-end">
            <div class="badge"></div>
          </div>
        </div>
      </div>
    </div>
  </template>
</div>

<script src="/ServiGo/assets/js/profesional.js"></script>
<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
