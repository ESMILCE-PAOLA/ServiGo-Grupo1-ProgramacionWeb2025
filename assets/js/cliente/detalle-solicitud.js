document.addEventListener('DOMContentLoaded', () => {
    if(!ID_SOLICITUD) return;

    fetch(`${window.BASE_URL}/backend/api/solicitudes/detalle.php?id=${ID_SOLICITUD}`)
        .then(r => r.json())
        .then(res => {
            if(!res.success) {
                document.querySelector('.container').innerHTML = `<div class="alert alert-danger">${res.error}</div>`;
                return;
            }

            const { solicitud, presupuestos } = res.data;

            // Llenar datos de solicitud
            document.getElementById('titulo').textContent = solicitud.titulo;
            document.getElementById('estado').textContent = solicitud.estado.toUpperCase();
            document.getElementById('descripcion').textContent = solicitud.descripcion;
            document.getElementById('direccion').textContent = solicitud.direccion;
            document.getElementById('localidad').textContent = solicitud.localidad_nombre || '';
            document.getElementById('fecha').textContent = new Date(solicitud.created_at).toLocaleDateString();

            // Llenar presupuestos
            const div = document.getElementById('listaPresupuestos');
            if(presupuestos.length === 0) {
                div.innerHTML = '<div class="col-12"><div class="alert alert-secondary">No has recibido presupuestos todavía.</div></div>';
                return;
            }

            div.innerHTML = presupuestos.map(p => `
                <div class="col-md-6 mb-3">
                    <div class="card h-100 border-primary">
                        <div class="card-header d-flex justify-content-between align-items-center bg-light">
                            <strong>${p.profesional_nombre}</strong>
                            <span class="badge bg-success fs-6">$${p.total}</span>
                        </div>
                        <div class="card-body">
                            <p class="card-text">${p.condiciones || 'Sin detalles adicionales.'}</p>
                            <small class="text-muted">Estado: ${p.estado}</small>
                        </div>
                        <div class="card-footer bg-white border-top-0">
                            <button class="btn btn-outline-success w-100 btn-sm">Contactar / Aceptar</button>
                        </div>
                    </div>
                </div>
            `).join('');
        })
        .catch(console.error);
});