document.addEventListener("DOMContentLoaded", () => {
  const path = window.location.pathname;

  // ================= INDEX CLIENTE =================
  if (path.includes("index.html")) {
    console.log("Cliente → Index");

    const profesionales = [
      { id: 1, nombre: "Carlos López", rubro: "Electricista", localidad: "González Catán", activo: true, puntuacion: 4.8, foto: "https://picsum.photos/seed/pro1/600/400" },
      { id: 2, nombre: "Ana Torres", rubro: "Plomera", localidad: "La Matanza", activo: false, puntuacion: 4.6, foto: "https://picsum.photos/seed/pro2/600/400" },
      { id: 3, nombre: "Martín Díaz", rubro: "Carpintero", localidad: "Morón", activo: true, puntuacion: 4.9, foto: "https://picsum.photos/seed/pro3/600/400" },
      { id: 4, nombre: "Lucía Fernández", rubro: "Barbera", localidad: "Lanús", activo: true, puntuacion: 4.7, foto: "https://picsum.photos/seed/pro4/600/400" },
      { id: 5, nombre: "Pedro Gómez", rubro: "Electricista", localidad: "Moreno", activo: true, puntuacion: 4.5, foto: "https://picsum.photos/seed/pro5/600/400" },
    ];

    let activos = profesionales.filter(p => p.activo);
    activos = activos.sort(() => Math.random() - 0.5);

    const grid = document.getElementById("gridProfesionales");

    function renderizar(lista) {
      grid.innerHTML = "";
      lista.forEach(p => {
        const col = document.createElement("div");
        col.className = "col-12 col-md-6 col-lg-4";
        col.innerHTML = `
          <div class="card h-100 shadow-sm">
              <img src="${p.foto}" class="card-img-top" alt="Foto de ${p.nombre}">
              <div class="card-body">
                <h5 class="card-title mb-1">${p.nombre}</h5>
                <p class="mb-1"><span class="badge bg-primary">${p.rubro}</span> · <small class="text-muted">${p.localidad}</small></p>
                <p class="mb-2"><span class="badge bg-success">Activo</span></p>
                <p class="text-warning">⭐ ${p.puntuacion}</p>
                <button class="btn btn-outline-primary w-100 btnVer" onclick="location.href='../profesional/perfil_profesional.html'">
                    <i class="bi bi-eye"></i> Ver perfil completo
                </button>
              </div>
          </div>
        `;
        grid.appendChild(col);
      });
    }

    renderizar(activos);

    const btnBuscar = document.getElementById("btnBuscar");
    btnBuscar?.addEventListener("click", (e) => {
      e.preventDefault();

      const servicio = document.getElementById("buscarServicio").value.toLowerCase();
      const localidad = document.getElementById("filtroLocalidad").value.toLowerCase();
      const ordenar = document.getElementById("ordenarPor").value;

      let filtrados = activos.filter(p => {
        const coincideServicio = servicio === "" || p.rubro.toLowerCase().includes(servicio);
        const coincideLocalidad = localidad === "" || p.localidad.toLowerCase() === localidad;
        return coincideServicio && coincideLocalidad;
      });

      if (ordenar === "puntuacion") {
        filtrados.sort((a, b) => b.puntuacion - a.puntuacion);
      } else if (ordenar === "nombre") {
        filtrados.sort((a, b) => a.nombre.localeCompare(b.nombre));
      } else if (ordenar === "random") {
        filtrados = filtrados.sort(() => Math.random() - 0.5);
      }

      renderizar(filtrados);
    });
  }

  // ================= NUEVA SOLICITUD =================
  if (path.includes("nueva_solicitud.html")) {
    console.log("Cliente → Nueva Solicitud");

    const buscarInput = document.getElementById("buscarProfesional");
    const lista = document.getElementById("listaProfesionales")?.getElementsByTagName("label");

    if (buscarInput && lista) {
      buscarInput.addEventListener("keyup", () => {
        const filtro = buscarInput.value.toLowerCase();
        Array.from(lista).forEach(label => {
          const texto = label.textContent.toLowerCase();
          label.style.display = texto.includes(filtro) ? "" : "none";
        });
      });
    }

    const form = document.getElementById("formSolicitud");
    if (form) {
      form.addEventListener("submit", (e) => {
        e.preventDefault();

        const modal = new bootstrap.Modal(document.getElementById("modalConfirmacion"));
        modal.show();

        // Simulación de redirección luego de enviar
        setTimeout(() => {
          location.href = "solicitudes_cliente.html";
        }, 2000);
      });
    }
  }

  // ================= SOLICITUDES CLIENTE =================
const solicitudes = [
  { id: "S01", descripcion: "Arreglo instalación eléctrica", estado: "Pendiente", profesionales: ["Carlos López"] },
  { id: "S02", descripcion: "Reparación de caño roto", estado: "En curso", profesionales: ["Ana Torres", "Pedro Gómez"] },
  { id: "S03", descripcion: "Armado de mueble", estado: "Finalizado", profesionales: ["Martín Díaz"] }
];

const tbody = document.getElementById("tablaSolicitudes");

function renderSolicitudes(lista) {
  tbody.innerHTML = "";
  lista.forEach(s => {
    tbody.innerHTML += `
      <tr>
        <td>${s.id}</td>
        <td>${s.descripcion}</td>
        <td><span class="badge ${
          s.estado === "Pendiente" ? "bg-warning text-dark" :
          s.estado === "En curso" ? "bg-info text-dark" : "bg-success"
        }">${s.estado}</span></td>
        <td>${s.profesionales.join(", ")}</td>
        <td>
          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalChat">
            <i class="bi bi-chat-dots"></i> Ver Chat
          </button>
          ${s.estado === "Finalizado" ? `
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalCalificar">
              <i class="bi bi-star-fill"></i> Calificar
            </button>` : ""}
        </td>
      </tr>
    `;
  });
}

renderSolicitudes(solicitudes);

// Calificación con estrellas
const estrellas = document.querySelectorAll("#estrellas i");
let rating = 0;
estrellas.forEach(estrella => {
  estrella.addEventListener("click", () => {
    rating = estrella.dataset.value;
    estrellas.forEach(e => e.classList.remove("bi-star-fill"));
    for (let i = 0; i < rating; i++) estrellas[i].classList.add("bi-star-fill");
  });
});

document.getElementById("btnEnviarCalificacion").addEventListener("click", () => {
  const comentario = document.getElementById("comentario").value;
  console.log(`Calificación: ${rating} estrellas, Comentario: ${comentario}`);
  alert("¡Gracias por tu calificación!");
  const modal = bootstrap.Modal.getInstance(document.getElementById("modalCalificar"));
  modal.hide();
});

  // ================= PERFIL CLIENTE =================
  if (path.includes("perfil.html")) {
    console.log("Cliente → Perfil");

    const perfil = {
      nombre: "María López",
      email: "maria@mail.com",
      localidad: "González Catán",
      telefono: "1122334455"
    };

    document.getElementById("nombreCliente").textContent = perfil.nombre;
    document.getElementById("emailCliente").textContent = perfil.email;
    document.getElementById("localidadCliente").textContent = perfil.localidad;
    document.getElementById("telefonoCliente").textContent = perfil.telefono;
  }

  // ================= CHAT (modal o página) =================
  if (path.includes("chat.html")) {
    console.log("Cliente → Chat");

    const chatBox = document.getElementById("chatBox");
    const mensajes = [
      { autor: "Profesional", texto: "Hola, vi tu solicitud. ¿Podés darme más detalles?" },
      { autor: "Cliente", texto: "Sí, es un problema con la instalación eléctrica en la cocina." }
    ];

    function renderChat() {
      chatBox.innerHTML = "";
      mensajes.forEach(m => {
        chatBox.innerHTML += `
          <div class="mb-2">
            <strong>${m.autor}:</strong> ${m.texto}
          </div>
        `;
      });
    }

    renderChat();
  }
});
