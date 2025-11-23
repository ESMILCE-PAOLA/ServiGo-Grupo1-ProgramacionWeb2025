<?php
require_once __DIR__ . '/../../includes/guard_profesional.php';
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';

$solicitudId = intval($_GET['id'] ?? 0);
?>
<link rel="stylesheet" href="/ServiGo/assets/css/profesional.css">

<div class="container py-4 text-light">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h3 class="fw-bold m-0">Crear presupuesto</h3>
    <div class="d-flex gap-2">
      <a class="btn btn-outline-light btn-sm" href="/ServiGo/views/profesional/solicitudes-profesional.php">← Volver a solicitudes</a>
      <?php if ($solicitudId): ?>
        <a class="btn btn-outline-info btn-sm" href="/ServiGo/views/profesional/detalle-solicitud.php?id=<?= htmlspecialchars($solicitudId) ?>">
          Ver detalle
        </a>
      <?php endif; ?>
    </div>
  </div>

  <?php if ($solicitudId <= 0): ?>
    <div class="alert alert-warning">
      Falta el parámetro <code>?id</code> de la solicitud.
    </div>
  <?php else: ?>
    <div class="card bg-dark mb-4">
      <div class="card-body">
        <div class="small text-secondary">Solicitud #<?= htmlspecialchars($solicitudId) ?></div>
        <div id="infoSolicitud" class="small text-secondary">Cargando datos…</div>
      </div>
    </div>

    <div class="card bg-dark">
      <div class="card-body">
        <h5 class="card-title">Completar presupuesto</h5>
        <form id="formPresupuesto">
          <input type="hidden" name="solicitud_id" value="<?= htmlspecialchars($solicitudId) ?>">

          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Monto (ARS)</label>
              <input type="number" step="0.01" min="0" class="form-control" name="monto" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Plazo estimado (días)</label>
              <input type="number" min="1" class="form-control" name="plazo_dias" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Validez (días)</label>
              <input type="number" min="1" class="form-control" name="validez_dias" placeholder="(opcional)">
            </div>
            <div class="col-12">
              <label class="form-label">Detalle / Observaciones</label>
              <textarea class="form-control" name="detalle" rows="4" required></textarea>
            </div>
          </div>

          <div class="mt-3 d-flex align-items-center gap-2">
            <button class="btn btn-primary" type="submit">Enviar presupuesto</button>
            <span id="estadoEnvio" class="small text-secondary"></span>
          </div>
        </form>
      </div>
    </div>
  <?php endif; ?>
</div>

<script>
  // Mini helper para mostrar toasts simples
  function toast(msg, type='info') {
    const d = document.createElement('div');
    d.className = `alert alert-${type} position-fixed top-0 start-50 translate-middle-x mt-3`;
    d.style.zIndex = 2000;
    d.textContent = msg;
    document.body.appendChild(d);
    setTimeout(()=>d.remove(), 2200);
  }

  // Cargar info básica de la solicitud (si tenés endpoint de detalle, usalo;
  // dejo una llamada tentativa; si no existe aún, podés quitar este bloque)
  (async ()=>{
    const info = document.getElementById('infoSolicitud');
    if(!info) return;
    try {
      const id = <?= $solicitudId ?>;
      // Si todavía no tenés endpoint específico, comentá estas 3 líneas:
      const r = await fetch('/ServiGo/backend/api/cliente/obtener_solicitud.php?id=' + id);
      const j = await r.json();
      if (j?.success) info.textContent = `${j.data.titulo ?? ''} · ${j.data.localidad ?? ''} · ${j.data.cliente ?? ''}`;
      else info.textContent = ' ';
    } catch { info.textContent = ' '; }
  })();

  // Envío del presupuesto
  document.getElementById('formPresupuesto')?.addEventListener('submit', async (e)=>{
    e.preventDefault();
    const form = e.currentTarget;
    const fd = new FormData(form);
    document.getElementById('estadoEnvio').textContent = 'Enviando...';
    try {
      const r = await fetch('/ServiGo/backend/api/profesional/enviar_presupuesto.php', { method:'POST', body: fd });
      const j = await r.json();
      if (j.success) {
        toast('Presupuesto enviado con éxito', 'success');
        form.reset();
      } else {
        toast(j.error || 'No se pudo enviar', 'danger');
      }
    } catch {
      toast('Error de red', 'danger');
    } finally {
      document.getElementById('estadoEnvio').textContent = '';
    }
  });
</script>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
