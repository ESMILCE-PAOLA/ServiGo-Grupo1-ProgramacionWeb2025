document.addEventListener('DOMContentLoaded', () => {
    const tabla = document.getElementById('tablaSolicitudes');

    fetch(`${window.BASE_URL}/backend/api/solicitudes/listar_cliente.php`)
        .then(r => r.json())
        .then(res => {
            if(!res.success) throw new Error(res.error);
            
            if(res.data.length === 0) {
                tabla.innerHTML = '<tr><td colspan="5" class="text-center py-4">No tienes solicitudes activas.</td></tr>';
                return;
            }

            tabla.innerHTML = res.data.map(s => `
                <tr>
                    <td>${new Date(s.created_at).toLocaleDateString()}</td>
                    <td class="fw-bold">${s.titulo}</td>
                    <td>${s.localidad || '-'}</td>
                    <td><span class="badge bg-info text-dark">${s.estado.toUpperCase()}</span></td>
                    <td>
                        <a href="solicitud_cliente.php?id=${s.id}" class="btn btn-sm btn-outline-primary">Ver Detalle</a>
                    </td>
                </tr>
            `).join('');
        })
        .catch(err => {
            tabla.innerHTML = `<tr><td colspan="5" class="text-danger text-center">Error: ${err.message}</td></tr>`;
        });
});