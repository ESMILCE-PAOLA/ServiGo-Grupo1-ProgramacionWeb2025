document.addEventListener("DOMContentLoaded", async () => {

    console.log("Perfil cargando…", { ID_PROFESIONAL, ES_MI_PERFIL, ROL_USUARIO });

    // ===============================
    // Validar ID del profesional
    // ===============================
    if (!ID_PROFESIONAL) {
        mostrarError("No se especificó el profesional a mostrar.");
        return;
    }

    const URL_API = `${BASE_URL}/backend/api/usuarios/profesional/perfil.php?id=${ID_PROFESIONAL}`;

    try {
        const resp = await fetch(URL_API);
        const json = await resp.json();

        if (!json.success) {
            mostrarError("No se pudo obtener el perfil del profesional.");
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
            info.foto ? `${BASE_URL}${info.foto}` : `${BASE_URL}/assets/img/user.png`;

        document.getElementById("nombreProfesional").innerText = info.nombre;
        document.getElementById("promedio").innerText = info.promedio ?? "N/A";
        document.getElementById("experiencia").innerText = info.experiencia ?? "Sin especificar";
        document.getElementById("localidad").innerText = info.localidad ?? "Sin datos";
        document.getElementById("descripcion").innerText = info.descripcion ?? "Sin descripción";

        // Badge de estado
        const estadoBadge = document.getElementById("estado");
        estadoBadge.innerText = info.estado;
        estadoBadge.classList.add(info.estado === "Activo" ? "bg-success" : "bg-secondary");

        // ===============================
        // RUBROS
        // ===============================
        const contRubros = document.getElementById("rubros");
        contRubros.innerHTML = "";

        if (!rubros.length) {
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
        // TRABAJOS REALIZADOS (CARRUSEL)
        // ===============================
        const contCarrusel = document.getElementById("trabajosCarousel");
        contCarrusel.innerHTML = "";

        if (!trabajos.length) {
            contCarrusel.innerHTML = `
                <div class="carousel-item active">
                    <div class="text-center text-muted p-5">
                        Sin trabajos realizados por el momento.
                    </div>
                </div>`;
        } else {
            trabajos.forEach((t, idx) => {
                const item = document.createElement("div");
                item.className = `carousel-item ${idx === 0 ? "active" : ""}`;

                item.innerHTML = `
                    <img src="${t.imagen}" class="d-block w-100 carrusel-img" alt="${t.titulo}">
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                        <h6 class="fw-bold">${t.titulo}</h6>
                        <p>${t.descripcion}</p>
                    </div>`;

                contCarrusel.appendChild(item);
            });
        }


        // ===============================
        // RESEÑAS
        // ===============================
        const contResenas = document.getElementById("listaResenas");
        contResenas.innerHTML = "";

        if (!resenas.length) {
            contResenas.innerHTML =
                `<div class="list-group-item text-muted">Aún no hay reseñas.</div>`;
        } else {
            resenas.forEach(r => {
                const item = document.createElement("div");
                item.className = "list-group-item";

                item.innerHTML = `
                    <strong>${r.cliente}</strong> – ⭐ ${r.calificacion}<br>
                    <p class="mb-1">${r.comentario}</p>
                    <small class="text-muted">${r.created_at}</small>
                `;

                contResenas.appendChild(item);
            });
        }

        // ===============================
        // LISTENERS SEGÚN ROL
        // ===============================
        inicializarEventosSegunRol();

    } catch (error) {
        console.error("Error en fetch:", error);
        mostrarError("No se pudo cargar la información del profesional.");
    }
});


// ============================================================================
// MANEJO DE EVENTOS SEGÚN ROL
// ============================================================================
function inicializarEventosSegunRol() {

    // Si es su perfil → no hay botones de cliente
    if (ES_MI_PERFIL) return;

    // Si es cliente
    if (ROL_USUARIO === "cliente") {

        const btnFavorito = document.getElementById("btnFavorito");
        const btnDenunciar = document.getElementById("btnDenunciar");
        const btnPresupuesto = document.getElementById("btnPresupuesto");

        if (btnFavorito) btnFavorito.addEventListener("click", agregarFavorito);
        if (btnDenunciar) btnDenunciar.addEventListener("click", denunciarPerfil);
        if (btnPresupuesto) btnPresupuesto.addEventListener("click", solicitarPresupuesto);
    }
}


// ============================================================================
// FUNCIONES CLIENTE → Favoritos / Denuncia / Presupuesto
// ============================================================================
async function agregarFavorito() {
    alert("Favorito agregado (falta endpoint real)");
}

async function denunciarPerfil() {
    alert("Denunciar perfil (falta endpoint real)");
}

async function solicitarPresupuesto() {
    alert("Solicitar presupuesto (abrir modal o redireccionar)");
}


// ============================================================================
// MENSAJE DE ERROR
// ============================================================================
function mostrarError(msg) {
    const main = document.querySelector("main");
    main.innerHTML = `
        <div class="alert alert-danger text-center mt-5">
            ${msg}
        </div>`;
}
