document.addEventListener("DOMContentLoaded", () => {
  // ==========================
  // DATOS SIMULADOS
  // ==========================
  const solicitudes = [
    { id: 101, cliente: "María González", localidad: "González Catán", detalle: "Arreglo de instalación eléctrica en la cocina", fecha: "2025-09-25", estado: "respondida",  adjunto: "foto_cocina.jpg" },
    { id: 102, cliente: "Juan Pérez",     localidad: "La Matanza",     detalle: "Pérdida en la cañería del baño",           fecha: "2025-09-26", estado: "pendiente",  adjunto: null },
  ];


});
  // ==========================
  // LISTA + RENDER (Solicitudes)
  // ==========================
  document.addEventListener("DOMContentLoaded", () => {
  const path = window.location.pathname;
  document.querySelectorAll(".navbar-nav .nav-link").forEach(link => {
    if (path.includes(link.getAttribute("href").split("/").pop())) {
      link.classList.add("active");
    }
  });
});
  const lista = document.getElementById("listaSolicitudes");

  function renderSolicitudes(data = solicitudes) {
    if (!lista) return;
    lista.innerHTML = "";
    data.forEach(s => {
      const item = document.createElement("div");
      item.className = "list-group-item d-flex justify-content-between align-items-center";
      item.innerHTML = `
        <div>
          <strong>${s.cliente}</strong> (${s.localidad})<br>
          <small class="text-muted">${s.servicio || "Servicio"} · ${s.fecha}</small>
        </div>
        <div class="d-flex align-items-center gap-2">
          <span class="badge ${s.estado === "pendiente" ? "bg-warning text-dark" : "bg-success"}">${s.estado}</span>
          <a href="detalle_solicitud.html?id=${s.id}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-eye"></i> Ver
          </a>
        </div>
      `;
      lista.appendChild(item);
    });
  }
  if (lista) renderSolicitudes();

  // ==========================
  // FILTROS
  // ==========================
  const formFiltros   = document.getElementById("formFiltros");
  const inputLoc      = document.getElementById("filtroLocalidad");
  const selectEstado  = document.getElementById("filtroEstado");
  const inputFecha    = document.getElementById("filtroFecha");
  const btnLimpiar    = document.getElementById("btnLimpiarFiltros"); 

  if (formFiltros) {
    formFiltros.addEventListener("submit", (e) => {
      e.preventDefault();

      const loc    = (inputLoc?.value || "").toLowerCase().trim();
      const estado = (selectEstado?.value || "").toLowerCase().trim();
      const fecha  = (inputFecha?.value || "").trim();

      const filtradas = solicitudes.filter(s => {
        const coincideLocalidad = !loc    || s.localidad.toLowerCase().includes(loc);
        const coincideEstado    = !estado || s.estado.toLowerCase() === estado;
        const coincideFecha     = !fecha  || s.fecha === fecha;
        return coincideLocalidad && coincideEstado && coincideFecha;
      });

      renderSolicitudes(filtradas);
    });

    // Botón "Limpiar" 
    if (btnLimpiar) {
      btnLimpiar.addEventListener("click", () => {
        formFiltros.reset();
        renderSolicitudes(); // vuelve a mostrar todo
      });
    }
  }

  // ==========================
  // DETALLE DE SOLICITUD 
  // ==========================
  const detalleSolicitud = document.getElementById("detalleSolicitud");
  if (detalleSolicitud) {
    const params = new URLSearchParams(window.location.search);
    const id = parseInt(params.get("id")) || 101;
    const s = solicitudes.find(x => x.id === id);

    if (s) {
      detalleSolicitud.innerHTML = `
        <div class="card shadow-sm p-3 mb-4">
          <p><strong>Cliente:</strong> ${s.cliente}</p>
          <p><strong>Localidad:</strong> ${s.localidad}</p>
          <p><strong>Servicio:</strong> ${s.servicio}</p>
          <p><strong>Detalle:</strong> ${s.detalle}</p>
          <p><strong>Fecha:</strong> ${s.fecha}</p>
          <p><strong>Estado:</strong> ${s.estado}</p>
          ${s.adjunto ? `<p><i class="bi bi-paperclip"></i> <a href="#">${s.adjunto}</a></p>` : ""}
        </div>
      `;
    }

    document.getElementById("btnAceptar")?.addEventListener("click", () => alert("Solicitud aceptada (simulado)."));
    document.getElementById("btnRechazar")?.addEventListener("click", () => alert("Solicitud rechazada (simulado)."));
  }

  // ==========================
  // INICIO PROFESIONAL (grid de destacados)
  // ==========================
  const grid = document.getElementById("gridProfesionales");
  if (grid) {
    const idProfesionalLogueado = 1; // simulado

    function renderizarProfesionales(lista) {
      grid.innerHTML = "";
      lista.forEach(p => {
        const col = document.createElement("div");
        col.className = "col-12 col-md-6 col-lg-4";
        col.innerHTML = `
          <div class="card h-100 shadow-sm">
            <img src="${p.foto}" class="card-img-top" alt="Foto de ${p.nombre}">
            <div class="card-body">
              <h5 class="card-title mb-1">${p.nombre}</h5>
              <p class="mb-1">
                <span class="badge bg-primary">${p.rubro}</span>
                · <small class="text-muted">${p.localidad}</small>
              </p>
              <p class="text-warning">⭐ ${p.puntuacion}</p>
              <button class="btn btn-outline-primary w-100 btnVerPerfil" data-id="${p.id}">
                <i class="bi bi-eye"></i> Ver perfil
              </button>
            </div>
          </div>
        `;
        grid.appendChild(col);
      });

      document.querySelectorAll(".btnVerPerfil").forEach(btn => {
        btn.addEventListener("click", (e) => {
          const id = parseInt(e.currentTarget.dataset.id, 10);
          if (id === idProfesionalLogueado) {
            location.href = "perfil_profesional.html";
          } else {
            const modalAviso = new bootstrap.Modal(document.getElementById("modalAviso"));
            modalAviso.show();
          }
        });
      });
    }

    renderizarProfesionales([
      { id: 1, nombre: "Carlos López",  rubro: "Electricista", localidad: "González Catán", puntuacion: 4.9, foto: "imagenes/electricista_perfil.jpg" },
      { id: 2, nombre: "Ana Torres",    rubro: "Plomera",      localidad: "Ezeiza",      puntuacion: 4.6, foto: "https://picsum.photos/seed/pro2/600/400" },
      { id: 3, nombre: "Martín Díaz",   rubro: "Luthier",   localidad: "Morón",           puntuacion: 4.8, foto: "https://picsum.photos/seed/pro3/600/400" }
    ]);
  }

  // ==========================
  // CREAR PRESUPUESTO 
  // ==========================
  const detalleBody = document.getElementById("detalleBody");
  if (detalleBody) {
    const btnAgregarFila = document.getElementById("btnAgregarFila");
    const total = document.getElementById("total");

    function calcularTotales() {
      let suma = 0;
      detalleBody.querySelectorAll("tr").forEach(row => {
        const cant   = parseFloat(row.querySelector(".cantidad").value) || 0;
        const precio = parseFloat(row.querySelector(".precioUnitario").value) || 0;
        const sub = cant * precio;
        row.querySelector(".subtotal").value = sub.toFixed(2);
        suma += sub;
      });
      total.value = suma.toFixed(2);
    }

    btnAgregarFila?.addEventListener("click", () => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td><input type="number" class="form-control cantidad" value="1" required></td>
        <td><input type="text" class="form-control descripcion" placeholder="Trabajo a realizar" required></td>
        <td><input type="number" class="form-control precioUnitario" required></td>
        <td><input type="text" class="form-control subtotal" readonly></td>
        <td><button type="button" class="btn btn-outline-danger btn-sm btnEliminar"><i class="bi bi-trash"></i></button></td>
      `;
      detalleBody.appendChild(tr);
    });

    detalleBody.addEventListener("input", (e) => {
      if (e.target.classList.contains("cantidad") || e.target.classList.contains("precioUnitario")) {
        calcularTotales();
      }
    });

    detalleBody.addEventListener("click", (e) => {
      if (e.target.closest(".btnEliminar")) {
        e.target.closest("tr").remove();
        calcularTotales();
      }
    });

    calcularTotales();
  }

  // ==========================
  // BLOQUEO / DESBLOQUEO (solo admin)
  // ==========================
  const params = new URLSearchParams(window.location.search);
  if (params.get("admin") === "1") {
  document.querySelector("nav.navbar").innerHTML = `
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">⚡ ServiGo</a>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="../Administrador/DashboardAdministrador.html">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="../Administrador/PerfilAdministrador.html">Perfil</a></li>
        <li class="nav-item"><a class="nav-link" href="../Administrador/GestionDenuncias.html">Denuncias</a></li>
        <li class="nav-item"><a class="nav-link" href="../Administrador/GestionUsuarios.html">Usuarios</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="../visitante/index.html">Cerrar sesión</a></li>
      </ul>
    </div>
  `;
}
  if (params.get("admin") === "1") {
    const accionesAdmin = document.getElementById("accionesAdmin");
    const badgeEstado = document.getElementById("badgeEstado");
    const btnBloquear = document.getElementById("btnBloquear");
    const btnDesbloquear = document.getElementById("btnDesbloquear");
    const formBloqueo = document.getElementById("formBloqueo");
    const modalBloqueo = new bootstrap.Modal(document.getElementById("modalBloqueo"));
    const modalConfirmacion = new bootstrap.Modal(document.getElementById("modalConfirmacion"));
    const mensajeConfirmacion = document.getElementById("mensajeConfirmacion");

    accionesAdmin?.classList.remove("d-none");

    // Abrir modal bloqueo
    btnBloquear?.addEventListener("click", () => modalBloqueo.show());

    // Confirmar bloqueo
    formBloqueo?.addEventListener("submit", e => {
      e.preventDefault();
      const tipo = document.getElementById("tipoBloqueo").value;
      const motivo = document.getElementById("motivoBloqueo").value;

      badgeEstado.textContent = "Bloqueado";
      badgeEstado.className = "badge bg-danger";
      btnBloquear.classList.add("d-none");
      btnDesbloquear.classList.remove("d-none");

      mensajeConfirmacion.textContent =
        `Usuario bloqueado ${tipo === "indefinido" ? "indefinidamente" : "por " + tipo + " días"}.\nMotivo: ${motivo}`;
      modalBloqueo.hide();
      modalConfirmacion.show();
    });

    // Desbloquear
    btnDesbloquear?.addEventListener("click", () => {
      badgeEstado.textContent = "Activo";
      badgeEstado.className = "badge bg-success";
      btnDesbloquear.classList.add("d-none");
      btnBloquear.classList.remove("d-none");

      mensajeConfirmacion.textContent = "Usuario desbloqueado.";
      modalConfirmacion.show();
    });
  }


});
