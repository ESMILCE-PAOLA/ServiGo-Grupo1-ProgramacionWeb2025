document.addEventListener("DOMContentLoaded", async () => {

    // ===============================
    // Validar ID del profesional
    // ===============================
    if (!ID_PROFESIONAL) {
        console.error("No se especificó ID_PROFESIONAL");
        return;
    }

    const URL_API = `${BASE_URL}/backend/api/usuarios/profesional/perfil.php?id=${ID_PROFESIONAL}`;

    try {

        // ===============================
        // FETCH A LA API
        // ===============================
        const resp = await fetch(URL_API);
        const json = await resp.json();

        if (!json.success) {
            mostrarError("Ocurrió un error al obtener el perfil.");
            console.error(json.error);
            return;
        }

        const data = json.data;
        const info = data.info;
        const rubros = data.rubros;
        const trabajos = data.trabajos;
        const resenas = data.resenas;

        // ===============================
        // CARGAR DATOS BÁSICOS
        // ===============================
        document.getElementById("fotoPerfil").src =
            info.foto
                ? `${BASE_URL}${info.foto}`
                : `${BASE_URL}/assets/img/user.png`;

        document.getElementById("nombreProfesional").innerText = info.nombre;
        document.getElementById("promedio").innerText = info.promedio ?? "N/A";
        document.getElementById("experiencia").innerText = info.experiencia ?? "Sin especificar";
        document.getElementById("localidad").innerText = info.localidad ?? "Sin datos";
        document.getElementById("descripcion").innerText = info.descripcion ?? "Sin descripción";

        // Estado con badge
        const estadoBadge = document.getElementById("estado");
        estadoBadge.innerText = info.estado;

        if (info.estado === "Activo") {
            estadoBadge.classList.add("bg-success");
        } else {
            estadoBadge.classList.add("bg-secondary");
        }

        // ===============================
        // RUBROS
        // ===============================
        const contRubros = document.getElementById("rubros");
        contRubros.innerHTML = "";

        if (rubros.length === 0) {
            contRubros.innerHTML = `<span class="text-muted">Sin rubros</span>`;
        } else {
            rubros.forEach(r => {
                const span = document.createElement("span");
                span.className = "badge bg-primary me-1";
                span.innerText = r;
                contRubros.appendChild(span);
            });
        }

        // ===============================
        // TRABAJOS REALIZADOS — CARRUSEL
        // ===============================
        const contCarrusel = document.getElementById("trabajosCarousel");
        contCarrusel.innerHTML = "";

        if (trabajos.length === 0) {
            contCarrusel.innerHTML = `
                <div class="carousel-item active">
                    <div class="text-center text-muted p-5">
                        Este profesional aún no ha cargado trabajos realizados.
                    </div>
                </div>
            `;
        } else {
            trabajos.forEach((t, index) => {
                const item = document.createElement("div");
                item.className = `carousel-item ${index === 0 ? 'active' : ''}`;

                item.innerHTML = `
                    <img src="${t.imagen}" class="d-block w-100 carrusel-img" alt="${t.titulo}">
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                        <h6 class="fw-bold">${t.titulo}</h6>
                        <p>${t.descripcion}</p>
                    </div>
                `;

                contCarrusel.appendChild(item);
            });
        }

        // ===============================
        // RESEÑAS
        // ===============================
        const contResenas = document.getElementById("listaResenas");
        contResenas.innerHTML = "";

        if (resenas.length === 0) {
            contResenas.innerHTML = `
                <div class="list-group-item text-muted">No hay reseñas disponibles.</div>
            `;
        } else {
            resenas.forEach(r => {
                const item = document.createElement("div");
                item.className = "list-group-item list-group-item-light";

                item.innerHTML = `
                    <strong>${r.cliente}</strong> – ⭐ ${r.calificacion}<br>
                    <p class="mb-1">${r.comentario}</p>
                    <small class="text-muted">${r.created_at}</small>
                `;
                contResenas.appendChild(item);
            });
        }

    } catch (error) {
        console.error("Error en fetch:", error);
        mostrarError("No se pudo cargar la información del profesional.");
    }
});

// ===============================
// mensaje de error
// ===============================
function mostrarError(msg) {
    const main = document.querySelector("main");
    main.innerHTML = `
        <div class="alert alert-danger text-center mt-5">
            ${msg}
        </div>
    `;
}
