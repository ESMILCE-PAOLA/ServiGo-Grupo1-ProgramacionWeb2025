document.addEventListener('DOMContentLoaded', () => {
    const tabla = document.getElementById('tablaSolicitudes');

    fetch(`${window.BASE_URL}/backend/api/solicitudes/listar_cliente.php`)
        .then(r => r.json())
        .then(data => {
            if (!data.success) throw new Error(data.error);
            
            if (data.data.length === 0) {
                tabla.innerHTML = '<tr><td colspan="5" class="text-center p-4">No tienes solicitudes creadas aún.</td></tr>';
                return;
            }

            tabla.innerHTML = data.data.map(s => `
                <tr>
                    <td>${new Date(s.created_at).toLocaleDateString()}</td>
                    <td class="fw-bold text-primary">${s.titulo}</td>
                    <td>${s.localidad || 'N/A'}</td>
                    <td><span class="badge ${getStatusBadge(s.estado)}">${s.estado.toUpperCase()}</span></td>
                    <td>
                        <a href="solicitud_cliente.php?id=${s.id}" class="btn btn-sm btn-info text-white">
                            <i class="bi bi-eye"></i> Ver Detalle
                        </a>
                    </td>
                </tr>
            `).join('');
        })
        .catch(err => {
            tabla.innerHTML = `<tr><td colspan="5" class="text-danger text-center">Error: ${err.message}</td></tr>`;
        });
});

function getStatusBadge(estado) {
    if (estado === 'pendiente') return 'bg-warning text-dark';
    if (estado === 'en_progreso') return 'bg-primary';
    if (estado === 'finalizada') return 'bg-success';
    return 'bg-secondary';
}