// ==============================
// EDITAR PERFIL – PROFESIONAL
// ==============================

document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('#formEditarPerfil');
  const mensaje = document.querySelector('#mensaje');

  form?.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(form);
    mensaje.innerHTML = `<div class="text-secondary small">Guardando cambios...</div>`;

    try {
      const resp = await fetch(`${window.BASE_URL}/backend/api/usuarios/profesional/actualizar_perfil.php`, {
        method: 'POST',
        body: formData
      });
      const json = await resp.json();

      if (!json.success) {
        mensaje.innerHTML = `<div class="alert alert-danger">${json.error || 'No se pudieron guardar los cambios'}</div>`;
        return;
      }

      mensaje.innerHTML = `<div class="alert alert-success">✅ Perfil actualizado correctamente.</div>`;
      setTimeout(() => window.location.href = `${window.BASE_URL}/views/profesional/perfil_profesional.php`, 1200);
    } catch (err) {
      console.error(err);
      mensaje.innerHTML = `<div class="alert alert-danger">Error de red al actualizar.</div>`;
    }
  });
});
