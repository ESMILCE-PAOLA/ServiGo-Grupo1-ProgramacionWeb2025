document.addEventListener("DOMContentLoaded", async () => {

    if (!ID_PROFESIONAL) {
        console.error("ERROR: ID_PROFESIONAL no está definido.");
        return;
    }

    const form = document.getElementById("formEditar");
    const msgError = document.getElementById("msgError");

    // ================================
    // 1 CARGAR DATOS DEL PROFESIONAL
    // ================================
    try {
        const resp = await fetch(`${BASE_URL}/backend/api/usuarios/profesional/perfil.php?id=${ID_PROFESIONAL}`);
        const json = await resp.json();

        if (!json.success) {
            console.error("Error al cargar información del profesional:", json.error);
            msgError.classList.remove("d-none");
            msgError.innerText = "No se pudo cargar la información del profesional.";
            return;
        }

        const info = json.data.info;
        const rubrosBD = json.data.rubros; // array de rubros actuales del profesional

        // Rellenar campos
        document.getElementById("nombre").value = info.nombre;
        document.getElementById("experiencia").value = info.experiencia;
        document.getElementById("descripcion").value = info.descripcion;

        // Foto actual
        document.getElementById("fotoActual").src =
            info.foto ? BASE_URL + info.foto : `${BASE_URL}/assets/img/user.png`;

        // ================================
        // 2 CARGAR LOCALIDADES
        // ================================
        const selLocalidad = document.getElementById("localidad");

        const resLoc = await fetch(`${BASE_URL}/backend/api/localidades/listar.php`);
        const jsonLoc = await resLoc.json();

        selLocalidad.innerHTML = "";

        jsonLoc.data.forEach(loc => {
            const opt = document.createElement("option");
            opt.value = loc.id;
            opt.textContent = loc.nombre;

            if (loc.nombre === info.localidad) opt.selected = true;


            selLocalidad.appendChild(opt);
        });

        // ================================
        // 3 CARGAR RUBROS (MULTISELECT)
        // ================================
        const selRubros = document.getElementById("rubros");

        const resRub = await fetch(`${BASE_URL}/backend/api/rubros/listar.php`);
        const jsonRub = await resRub.json();

        selRubros.innerHTML = "";

        jsonRub.data.forEach(r => {
            const opt = document.createElement("option");
            opt.value = r.id;
            opt.textContent = r.nombre;

            // Marcar los rubros que ya tiene
            if (rubrosBD.includes(r.nombre)) {
                opt.selected = true;
            }

            selRubros.appendChild(opt);
        });

    } catch (err) {
        console.error("Error cargando datos del perfil:", err);
        msgError.classList.remove("d-none");
        msgError.innerText = "Error al cargar los datos.";
    }

    // ================================
    // 4 GUARDAR CAMBIOS
    // ================================
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        msgError.classList.add("d-none");
        msgError.innerText = "";

        const formData = new FormData(form);

        try {
            const resp = await fetch(
                `${BASE_URL}/backend/api/usuarios/profesional/actualizar_perfil.php?id=${ID_PROFESIONAL}`,
                { method: "POST", body: formData }
            );

            const json = await resp.json();

            if (!json.success) {
                msgError.classList.remove("d-none");
                msgError.innerText = json.error || "Ocurrió un error inesperado.";
                return;
            }

            Swal.fire({
                icon: "success",
                title: "Cambios guardados",
                text: "Tu perfil fue actualizado correctamente.",
                confirmButtonColor: "#0d6efd"
            }).then(() => {
                window.location.href =
                    `${BASE_URL}/views/profesional/perfil_profesional.php?id=${ID_PROFESIONAL}`;
            });

        } catch (err) {
            console.error("Error en la petición:", err);
            msgError.classList.remove("d-none");
            msgError.innerText = "No se pudo procesar la solicitud.";
        }
    });

});
