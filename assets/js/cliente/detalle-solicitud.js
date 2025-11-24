// ==============================
// DETALLE SOLICITUD – CLIENTE
// ==============================

document.addEventListener('DOMContentLoaded', async () => {
  const chatBox = document.querySelector('#chatBox');
  const btnEnviar = document.querySelector('#btnEnviar');
  const inputMensaje = document.querySelector('#mensaje');

  let intervalChat;

  await cargarDetalle();
  await cargarChat();

  // Actualiza el chat cada 10 segundos
  intervalChat = setInterval(cargarChat, 10000);

  btnEnviar?.addEventListener('click', async () => {
    const texto = inputMensaje.value.trim();
    if (!texto) return;
    inputMensaje.value = '';
    const msgHTML = `<div class="text-end"><span class="badge bg-success">${texto}</span></div>`;
    chatBox.insertAdjacentHTML('beforeend', msgHTML);
    chatBox.scrollTop = chatBox.scrollHeight;

    try {
      await fetch(`${window.BASE_URL}/backend/api/chat/enviar.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          solicitud_id: SOLICITUD_ID,
          mensaje: texto,
          emisor: 'cliente'
        })
      });
    } catch (err) {
      console.error('Error al enviar mensaje', err);
    }
  });

  async function cargarDetalle() {
    try {
      const resp = await fetch(`${window.BASE_URL}/backend/api/usuarios/cliente/obtener_solicitud.php?id=${SOLICITUD_ID}`);
      const json = await resp.json();
      if (!json.success) throw new Error(json.error);

      const s = json.data;
      document.querySelector('#titulo').textContent = s.titulo || '';
      document.querySelector('#descripcion').textContent = s.descripcion || '';
      document.querySelector('#profesional').textContent = s.profesional || 'No asignado';
      document.querySelector('#direccion').textContent = s.direccion || '';
      document.querySelector('#localidad').textContent = s.localidad || '';
      document.querySelector('#estado').textContent = s.estado || '';
      document.querySelector('#fecha').textContent = s.created_at || '';
    } catch (err) {
      chatBox.innerHTML = `<p class="text-danger">Error: ${err.message}</p>`;
    }
  }

  async function cargarChat() {
    try {
      const resp = await fetch(`${window.BASE_URL}/backend/api/chat/listar.php?solicitud_id=${SOLICITUD_ID}`);
      const json = await resp.json();

      if (!json.success) {
        chatBox.innerHTML = `<div class="text-danger text-center py-3">Error al cargar mensajes.</div>`;
        return;
      }

      if (!json.data.length) {
        chatBox.innerHTML = `<div class="text-secondary text-center small py-3">Sin mensajes aún.</div>`;
        return;
      }

      chatBox.innerHTML = json.data.map(m => `
        <div class="${m.emisor === 'cliente' ? 'text-end' : 'text-start'}">
          <span class="badge ${m.emisor === 'cliente' ? 'bg-success' : 'bg-secondary'}">${m.mensaje}</span>
        </div>
      `).join('');

      chatBox.scrollTop = chatBox.scrollHeight;
    } catch (err) {
      console.error('Error al cargar chat:', err);
    }
  }
});
