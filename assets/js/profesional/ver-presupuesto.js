document.addEventListener("DOMContentLoaded", async () => {
    const idPresupuesto = window.ID_PRESUPUESTO;

    if (!idPresupuesto) {
        document.getElementById("contenedorPresupuesto").innerHTML =
            `<div class="alert alert-danger">ID de presupuesto no especificado.</div>`;
        return;
    }

    try {
        const resp = await fetch(
            `${window.BASE_URL}/backend/api/presupuestos/ver.php?id=${idPresupuesto}`
        );

        const json = await resp.json();

        if (!json.success) {
            document.getElementById("contenedorPresupuesto").innerHTML =
                `<div class="alert alert-danger">${json.error}</div>`;
            return;
        }

        const p = json.data;
        const det = json.data.detalle;

        // ================
        // ARMAR HTML COMPLETO
        // ================
        let html = `
            <div class="mb-4">
                <p><strong>Cliente:</strong> ${p.cliente}</p>
                <p><strong>Fecha de Solicitud:</strong> ${p.fecha_solicitud}</p>
                <p><strong>Fecha de Emisión:</strong> ${p.fecha_emision}</p>
                <p><strong>Válido Hasta:</strong> ${p.valido_hasta}</p>
                <p><strong>Condiciones:</strong> ${p.condiciones || "Sin condiciones"}</p>
            </div>

            <h5 class="mt-4">Detalle del Servicio</h5>
            <table class="table table-bordered text-light">
                <thead class="table-secondary text-dark">
                    <tr>
                        <th>Cantidad</th>
                        <th>Descripción</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
        `;

        det.forEach(item => {
            html += `
                <tr>
                    <td>${item.cantidad}</td>
                    <td>${item.descripcion}</td>
                    <td>$${item.precio_unitario}</td>
                    <td>$${item.subtotal}</td>
                </tr>
            `;
        });

        html += `
                </tbody>
            </table>
            <h4 class="mt-3 text-end">TOTAL: $${p.total}</h4>
        `;

        document.getElementById("contenedorPresupuesto").innerHTML = html;

    } catch (err) {
        console.error(err);
        document.getElementById("contenedorPresupuesto").innerHTML =
            `<div class="alert alert-danger">Error al cargar el presupuesto.</div>`;
    }
});
