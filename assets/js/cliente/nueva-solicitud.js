document.addEventListener('DOMContentLoaded', async () => {
    const select = document.getElementById('selectLocalidad');
    const form = document.getElementById('formNueva');
    const alerta = document.getElementById('alerta');

    // 1. Cargar Localidades (Usamos la API que ya tenías o la general)
    try {
        const res = await fetch(`${window.BASE_URL}/backend/api/localidades/listar.php`);
        const json = await res.json();
        if(json.success) {
            select.innerHTML = '<option value="">Seleccione...</option>' + 
            json.data.map(l => `<option value="${l.id}">${l.nombre}</option>`).join('');
        }
    } catch(e) { console.error("Error localidades", e); }

    // 2. Enviar datos
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        try {
            const res = await fetch(`${window.BASE_URL}/backend/api/solicitudes/agregar.php`, {
                method: 'POST', body: new FormData(form)
            });
            const data = await res.json();

            if(data.success) {
                alerta.className = 'alert alert-success mt-3';
                alerta.textContent = 'Solicitud creada con éxito. Redirigiendo...';
                alerta.classList.remove('d-none');
                setTimeout(() => window.location.href = 'index.php', 2000);
            } else {
                throw new Error(data.error || 'Error desconocido');
            }
        } catch(err) {
            alerta.className = 'alert alert-danger mt-3';
            alerta.textContent = err.message;
            alerta.classList.remove('d-none');
        }
    });
});