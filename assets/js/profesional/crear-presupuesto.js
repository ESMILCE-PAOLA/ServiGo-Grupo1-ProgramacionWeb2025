// ==============================
// CREAR PRESUPUESTO – PROFESIONAL
// ==============================

document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('#formPresupuesto');
  const alerta = document.querySelector('#alerta');

  form?.addEventListener('submit', async e => {
    e.preventDefault();

    alerta.innerHTML = `<div class="text-secondary small">Enviando presupuesto...</div>`;

    try {
      const formData = new FormData(form);
      const resp = await fetch(`${window.BASE_URL}/backend/api/usuarios/profesional/crear_presupuesto.php`, {
        method: 'POST',
        body: formData
      });

      const json = await resp.json();

      if (!json.success) {
        alerta.innerHTML = `<div class="alert alert-danger py-2">${json.error || 'Error al enviar el presupuesto'}</div>`;
        return;
      }

      alerta.innerHTML = `<div class="alert alert-success py-2"> Presupuesto enviado correctamente.</div>`;
      form.reset();

      setTimeout(() => {
        window.location.href = `${window.BASE_URL}/views/profesional/presupuestos.php`;
      }, 1200);

    } catch (err) {
      console.error(err);
      alerta.innerHTML = `<div class="alert alert-danger py-2">Error de red al enviar presupuesto.</div>`;
    }
  });
});
