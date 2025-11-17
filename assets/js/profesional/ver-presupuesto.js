document.addEventListener("DOMContentLoaded", async () => {

    const params = new URLSearchParams(window.location.search);
    const idSolicitud = params.get("id");   // <── CORREGIDO

    if (!idSolicitud) {
        document.getElementById("presupuestoContainer").innerHTML =
            `<div class="alert alert-danger">ID de solicitud no especificado.</div>`;
        return;
    }

    const resp = await fetch(
        `${window.BASE_URL}/backend/api/presupuestos/obtener.php?solicitud_id=${idSolicitud}`
    );
    const json = await resp.json();

    if (!json.success) {
        document.getElementById("presupuestoContainer").innerHTML =
            `<div class="alert alert-danger">${json.error}</div>`;
        return;
    }

    const p = json.data.presupuesto;
    const det = json.data.detalle;

    let html = `
        <p><strong>Fecha emisión:</strong> ${p.fecha_emision}</p>
        <p><strong>Válido hasta:</strong> ${p.valido_hasta}</p>
        <p><strong>Condiciones:</strong> ${p.condiciones || "Sin condiciones adicionales"}</p>

        <h5>Detalle</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Cantidad</th>
                    <th>Descripción</th>
                    <th>Precio Unit.</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
    `;

    det.forEach(d => {
        html += `
            <tr>
                <td>${d.cantidad}</td>
                <td>${d.descripcion}</td>
                <td>$${d.precio_unitario}</td>
                <td>$${d.subtotal}</td>
            </tr>
        `;
    });

    html += `
        </tbody></table>
        <h4>Total: $${p.total}</h4>
    `;

    document.getElementById("presupuestoContainer").innerHTML = html;
});
