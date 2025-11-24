document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("formDenuncia");
    if (!form) return;

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const motivo = document.getElementById("motivoDenuncia").value;
        const detalle = document.getElementById("detalleDenuncia").value;

        const data = {
            motivo,
            detalle,
            denunciado_id: window.ID_DENUNCIADO ?? 0,
            solicitud_id: window.ID_SOLICITUD ?? 0
        };

        const resp = await fetch(`${BASE_URL}/backend/api/denuncias/guardar_denuncia.php`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        });

        const json = await resp.json();

        if (json.success) {
            Swal.fire("Denuncia enviada correctamente", json.message, "success");
            bootstrap.Modal.getInstance(document.getElementById("modalDenuncia")).hide();
        } else {
            Swal.fire("Error", json.error, "error");
        }
    });
});
