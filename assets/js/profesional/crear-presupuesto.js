// ==============================
// CREAR PRESUPUESTO – PROFESIONAL
// ==============================

document.addEventListener("DOMContentLoaded", async () => {

    const form = document.querySelector('#formPresupuesto');
    const detalleBody = document.getElementById("detalleBody");

    // =================================================
    // FUNCIÓN GENERAL PARA MOSTRAR MODALES DINÁMICOS
    // =================================================
    function mostrarModal(titulo, mensaje) {
        document.getElementById("tituloModal").innerText = titulo;
        document.getElementById("cuerpoModal").innerText = mensaje;

        let modal = new bootstrap.Modal(document.getElementById("modalMensaje"));
        modal.show();
    }

    // =================================================
    // 1. CARGAR DATOS DE LA SOLICITUD
    // =================================================
    const urlParams = new URLSearchParams(window.location.search);
    const idSolicitud = urlParams.get("id");

    try {
        const resp = await fetch(`${window.BASE_URL}/backend/api/solicitudes/obtener_solicitud.php?id=${idSolicitud}`);
        const json = await resp.json();

        if (!json.success) {
            mostrarModal("Error", "No se pudieron cargar los datos de la solicitud.");
            return;
        }

        const data = json.data;

        document.getElementById("solicitudId").value = "#" + data.id;
        document.getElementById("clienteNombre").value = data.cliente;
        document.getElementById("fechaSolicitud").value = data.created_at.substring(0, 10);
        document.getElementById("solicitud_id_real").value = data.id;

        // Fecha actual como emisión
        document.getElementById("fechaEmision").value =
            new Date().toISOString().slice(0, 10);

    } catch (e) {
        console.error(e);
        mostrarModal("Error", "Error de conexión al cargar la solicitud.");
    }

    // =================================================
    // 2. CÁLCULOS DINÁMICOS
    // =================================================
    const calcularSubtotal = (row) => {
        const cantidad = parseFloat(row.querySelector(".cantidad").value) || 0;
        const precio = parseFloat(row.querySelector(".precioUnitario").value) || 0;
        row.querySelector(".subtotal").value = (cantidad * precio).toFixed(2);
    };

    const calcularTotal = () => {
        let total = 0;
        document.querySelectorAll(".subtotal").forEach(sub => {
            total += parseFloat(sub.value || 0);
        });
        document.getElementById("total").value = total.toFixed(2);
    };

    detalleBody.addEventListener("input", (e) => {
        if (e.target.classList.contains("cantidad") ||
            e.target.classList.contains("precioUnitario")) {

            const row = e.target.closest("tr");
            calcularSubtotal(row);
            calcularTotal();
        }
    });

    // =================================================
    // 3. AGREGAR UNA FILA DEL DETALLE
    // =================================================
    document.getElementById("btnAgregarFila").addEventListener("click", () => {

        const nuevaFila = document.createElement("tr");
        nuevaFila.innerHTML = `
            <td><input name="cantidad[]" type="number" class="form-control cantidad" value="1" required></td>
            <td><input name="descripcion[]" type="text" class="form-control descripcion" placeholder="Trabajo a realizar" required></td>
            <td><input name="precio_unitario[]" type="number" class="form-control precioUnitario" required></td>
            <td><input name="subtotal[]" type="text" class="form-control subtotal" readonly></td>
            <td><button type="button" class="btn btn-outline-danger btn-sm btnEliminar"><i class="bi bi-trash"></i></button></td>
        `;

        detalleBody.appendChild(nuevaFila);
    });

    // =================================================
    // 4. ELIMINAR FILA DEL DETALLE
    // =================================================
    detalleBody.addEventListener("click", (e) => {
        if (e.target.closest(".btnEliminar")) {
            e.target.closest("tr").remove();
            calcularTotal();
        }
    });

    // =================================================
    // 5. ENVIAR FORMULARIO
    // =================================================
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        calcularTotal();
        formData.append("total", document.getElementById("total").value);

        try {
            const resp = await fetch(`${window.BASE_URL}/backend/api/presupuestos/agregar.php`, {
                method: "POST",
                body: formData
            });

            const json = await resp.json();

            if (!json.success) {
                mostrarModal("Error", json.error || "No se pudo enviar el presupuesto.");
                return;
            }

            // Mostrar modal de éxito
            mostrarModal("Éxito", "El presupuesto fue enviado correctamente.");

            // Redirigir después de mostrar el modal
            setTimeout(() => {
                window.location.href =
                    `${window.BASE_URL}/views/profesional/detalle-solicitud.php?id=${idSolicitud}`;
            }, 1500);

        } catch (err) {
            console.error(err);
            mostrarModal("Error", "Hubo un problema al enviar el presupuesto.");
        }
    });

}); 
