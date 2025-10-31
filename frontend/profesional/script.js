document.addEventListener("DOMContentLoaded", () => {
  const path = window.location.pathname;

  // ================= INDEX PROFESIONAL =================
  if (path.includes("index.html")) {
    console.log("Profesional → Index");

    const profesionales = [
      { id: 1, nombre: "Carlos López", rubro: "Electricista", localidad: "González Catán", activo: true, puntuacion: 4.8, foto: "imagenes/electricista_perfil.jpg" },
      { id: 2, nombre: "Ana Torres", rubro: "Plomera", localidad: "San Justo", activo: true, puntuacion: 4.6, foto: "https://picsum.photos/seed/pro2/600/400" },
      { id: 3, nombre: "Martín Díaz", rubro: "Carpintero", localidad: "Morón", activo: true, puntuacion: 4.9, foto: "https://picsum.photos/seed/pro3/600/400" },
    ];

    const grid = document.getElementById("gridProfesionales");

    function renderProfesionales(lista) {
      grid.innerHTML = "";
      lista.forEach(p => {
        const col = document.createElement("div");
        col.className = "col-12 col-md-6 col-lg-4";
        col.innerHTML = `
          <div class="card h-100 shadow-sm">
            <img src="${p.foto}" class="card-img-top" alt="${p.nombre}">
            <div class="card-body">
              <h5 class="card-title mb-1">${p.nombre}</h5>
              <p class="mb-1"><span class="badge bg-primary">${p.rubro}</span> · <small class="text-muted">${p.localidad}</small></p>
              <p class="text-warning">⭐ ${p.puntuacion}</p>
              <button class="btn btn-outline-primary w-100 btnVerPerfil" data-id="${p.id}">
                <i class="bi bi-eye"></i> Ver perfil
              </button>
            </div>
          </div>
        `;
        grid.appendChild(col);
      });

      // Acción al ver perfil
      grid.querySelectorAll(".btnVerPerfil").forEach(btn => {
        btn.addEventListener("click", () => {
          location.href = "perfil_profesional.html";
        });
      });
    }

    renderProfesionales(profesionales);
  }

  // ================= SOLICITUDES PROFESIONAL =================
  if (path.includes("solicitudes-profesional.html")) {
    console.log("Profesional → Solicitudes");

    const solicitudes = [
      { id: 101, cliente: "María González", localidad: "González Catán", detalle: "Instalación eléctrica cocina", fecha: "2025-09-25", estado: "Pendiente" },
      { id: 102, cliente: "Juan Pérez", localidad: "San Justo", detalle: "Pérdida en cañería baño", fecha: "2025-09-26", estado: "Aceptada" },
      { id: 103, cliente: "Sofía Arias", localidad: "Morón", detalle: "Carpintería: reparación de puerta", fecha: "2025-09-27", estado: "Rechazada" },
    ];

    const tbody = document.getElementById("tablaSolicitudes");
    const form = document.getElementById("formFiltros");
    const fechaDesde = document.getElementById("fechaDesde");
    const fechaHasta = document.getElementById("fechaHasta");
    const localidad = document.getElementById("filtroLocalidad");
    const estado = document.getElementById("filtroEstado");

    function renderSolicitudes(lista) {
      tbody.innerHTML = "";
      lista.forEach(s => {
        tbody.innerHTML += `
          <tr>
            <td>${s.id}</td>
            <td>${s.cliente}</td>
            <td>${s.detalle}</td>
            <td>${s.localidad}</td>
            <td>${s.fecha}</td>
            <td><span class="badge ${
              s.estado === "Pendiente" ? "bg-warning text-dark" :
              s.estado === "Aceptada" ? "bg-success" : "bg-secondary"
            }">${s.estado}</span></td>
            <td>
              <a href="detalle_solicitud.html?id=${s.id}" class="btn btn-info btn-sm">
                <i class="bi bi-envelope"></i> Ver mensaje
              </a>
            </td>
          </tr>
        `;
      });
    }

    function aplicarFiltros() {
      let filtradas = solicitudes;

      if (fechaDesde.value) filtradas = filtradas.filter(s => s.fecha >= fechaDesde.value);
      if (fechaHasta.value) filtradas = filtradas.filter(s => s.fecha <= fechaHasta.value);
      if (localidad.value) filtradas = filtradas.filter(s => s.localidad.toLowerCase().includes(localidad.value.toLowerCase()));
      if (estado.value) filtradas = filtradas.filter(s => s.estado === estado.value);

      renderSolicitudes(filtradas);
    }

    form?.addEventListener("submit", e => {
      e.preventDefault();
      aplicarFiltros();
    });

    renderSolicitudes(solicitudes);
  }

  // ================= DETALLE SOLICITUD =================
  if (path.includes("detalle_solicitud.html")) {
    console.log("Profesional → Detalle Solicitud");

    const params = new URLSearchParams(window.location.search);
    const id = parseInt(params.get("id")) || 101;

    const solicitudes = [
      { id: 101, cliente: "María González", detalle: "Instalación eléctrica cocina", fecha: "2025-09-25", estado: "Pendiente", mensaje: "Hola, necesito arreglar instalación." },
      { id: 102, cliente: "Juan Pérez", detalle: "Pérdida en cañería baño", fecha: "2025-09-26", estado: "Aceptada", mensaje: "Tengo pérdida en caño." }
    ];

    const solicitud = solicitudes.find(s => s.id === id);

    const detalle = document.getElementById("detalleSolicitud");
    if (solicitud && detalle) {
      detalle.innerHTML = `
        <div class="card shadow-sm p-3">
          <h5>Solicitud #${solicitud.id}</h5>
          <p><strong>Cliente:</strong> ${solicitud.cliente}</p>
          <p><strong>Detalle:</strong> ${solicitud.detalle}</p>
          <p><strong>Fecha:</strong> ${solicitud.fecha}</p>
          <p><strong>Mensaje:</strong> ${solicitud.mensaje}</p>
          <div class="mt-3">
            <a href="crear_presupuesto.html?id=${solicitud.id}" class="btn btn-primary btn-sm">
              <i class="bi bi-receipt"></i> Crear presupuesto
            </a>
            <button id="btnAceptar" class="btn btn-success btn-sm">
              <i class="bi bi-check2-circle"></i> Aceptar
            </button>
            <button id="btnRechazar" class="btn btn-danger btn-sm">
              <i class="bi bi-x-circle"></i> Rechazar
            </button>
          </div>
        </div>
      `;
    }

    document.getElementById("btnAceptar")?.addEventListener("click", () => {
      const modal = new bootstrap.Modal(document.getElementById("modalConfirmacion"));
      modal.show();
    });
    document.getElementById("btnRechazar")?.addEventListener("click", () => {
      const modal = new bootstrap.Modal(document.getElementById("modalConfirmacion"));
      modal.show();
    });
  }

  // ================= CREAR PRESUPUESTO =================
  if (path.includes("crear_presupuesto.html")) {
    console.log("Profesional → Crear Presupuesto");

    const detalleBody = document.getElementById("detalleBody");
    const btnAgregarFila = document.getElementById("btnAgregarFila");
    const total = document.getElementById("total");

    function calcularTotales() {
      let suma = 0;
      detalleBody.querySelectorAll("tr").forEach(row => {
        const cant = parseFloat(row.querySelector(".cantidad").value) || 0;
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
        <td><input type="number" class="form-control cantidad" value="1"></td>
        <td><input type="text" class="form-control descripcion" placeholder="Trabajo a realizar"></td>
        <td><input type="number" class="form-control precioUnitario"></td>
        <td><input type="text" class="form-control subtotal" readonly></td>
        <td><button type="button" class="btn btn-danger btn-sm btnEliminar"><i class="bi bi-trash"></i></button></td>
      `;
      detalleBody.appendChild(tr);
    });

    detalleBody?.addEventListener("input", calcularTotales);
    detalleBody?.addEventListener("click", (e) => {
      if (e.target.closest(".btnEliminar")) {
        e.target.closest("tr").remove();
        calcularTotales();
      }
    });

    calcularTotales();
  }

  // ================= PERFIL PROFESIONAL (Admin) =================
  if (path.includes("perfil_profesional.html")) {
    console.log("Profesional → Perfil (Admin)");

    const accionesAdmin = document.getElementById("accionesAdmin");
    const badgeEstado = document.getElementById("badgeEstado");
    const btnBloquear = document.getElementById("btnBloquear");
    const btnDesbloquear = document.getElementById("btnDesbloquear");
    const formBloqueo = document.getElementById("formBloqueo");
    const tipoBloqueo = document.getElementById("tipoBloqueo");
    const motivoBloqueo = document.getElementById("motivoBloqueo");

    const modalBloqueo = new bootstrap.Modal(document.getElementById("modalBloqueo"));
    const modalConfirmacion = new bootstrap.Modal(document.getElementById("modalConfirmacion"));
    const mensajeConfirmacion = document.getElementById("mensajeConfirmacion");

    // Mostrar bloque admin
    accionesAdmin?.classList.remove("d-none");

    btnBloquear?.addEventListener("click", () => modalBloqueo.show());

    formBloqueo?.addEventListener("submit", (e) => {
      e.preventDefault();
      const tipo = tipoBloqueo.value;
      const motivo = motivoBloqueo.value;

      badgeEstado.textContent = "Bloqueado";
      badgeEstado.className = "badge bg-danger";
      btnBloquear.classList.add("d-none");
      btnDesbloquear.classList.remove("d-none");

      mensajeConfirmacion.textContent = `Usuario bloqueado ${tipo === "indefinido" ? "indefinidamente" : "por " + tipo + " días"}.\nMotivo: ${motivo}`;
      modalBloqueo.hide();
      modalConfirmacion.show();
    });

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
