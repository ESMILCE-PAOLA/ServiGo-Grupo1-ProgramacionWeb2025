// =================== DATOS HARCODEADOS ===================
let rolActual = "Administrador"; // Simulación del rol

const usuario = {
  id: "U01",
  dni: "30123456",
  nombre: "Ana Torres",
  email: "ana@mail.com",
  rol: "Profesional",
  estado: "Activo",
  solicitudes: [
    { id: "S01", servicio: "Electricidad", estado: "Pendiente" },
    { id: "S05", servicio: "Carpintería", estado: "Finalizado" }
  ],
  portafolio: [
    { titulo: "Instalación eléctrica", img: "https://picsum.photos/200/150?random=1" },
    { titulo: "Reparación de tablero", img: "https://picsum.photos/200/150?random=2" }
  ]
};

// =================== RENDER PERFIL ===================
function renderPerfil() {
  // Reset secciones
  document.getElementById("seccionSolicitudes").classList.add("d-none");
  document.getElementById("seccionPortafolio").classList.add("d-none");
  document.getElementById("accionesAdmin").classList.add("d-none");
  document.getElementById("menuNav").innerHTML = "";

  // Datos básicos
  document.getElementById("nombreUsuario").textContent = usuario.nombre;
  document.getElementById("dniUsuario").textContent = usuario.dni;
  document.getElementById("emailUsuario").textContent = usuario.email;
  document.getElementById("rolUsuario").textContent = usuario.rol;
  document.getElementById("estadoUsuario").textContent = usuario.estado;
  document.getElementById("estadoUsuario").className =
    "badge " + (usuario.estado === "Activo" ? "bg-success" : "bg-danger");

  // Navbar y secciones
  if (rolActual === "Cliente") {
    menuNav.innerHTML = `
      <li class="nav-item"><a class="nav-link active" href="#">Perfil</a></li>
      <li class="nav-item"><a class="nav-link" href="../cliente/Solicitudes.html">Solicitudes</a></li>
    `;
    document.getElementById("seccionSolicitudes").classList.remove("d-none");

  } else if (rolActual === "Profesional") {
    menuNav.innerHTML = `
      <li class="nav-item"><a class="nav-link active" href="#">Perfil</a></li>
    `;
    document.getElementById("seccionPortafolio").classList.remove("d-none");

    // Render portafolio
    const grid = document.getElementById("gridPortafolio");
    grid.innerHTML = "";
    usuario.portafolio.forEach(p => {
      grid.innerHTML += `
        <div class="col-md-4">
          <div class="card shadow-sm">
            <img src="${p.img}" class="card-img-top" alt="${p.titulo}">
            <div class="card-body">
              <h6>${p.titulo}</h6>
            </div>
          </div>
        </div>
      `;
    });

  } else if (rolActual === "Administrador") {
    menuNav.innerHTML = `
      <li class="nav-item"><a class="nav-link" href="../administrador/PerfilAdministrador.html">Panel Admin</a></li>
      <li class="nav-item"><a class="nav-link active" href="#">Ver Usuario</a></li>
    `;
    document.getElementById("accionesAdmin").classList.remove("d-none");
    document.getElementById("seccionSolicitudes").classList.remove("d-none");
  }
}

// =================== SELECTOR DE ROL ===================
document.getElementById("selectRol").addEventListener("change", e => {
  rolActual = e.target.value;
  renderPerfil();

  // Actualizar mensaje en el modal
  document.getElementById("mensajeModalRol").innerHTML =
    `Ahora estás viendo como <b>${rolActual}</b>`;

  // Mostrar modal
  const modal = new bootstrap.Modal(document.getElementById("modalRol"));
  modal.show();
});

// =================== HISTORIAL DE SOLICITUDES ===================
const tbody = document.getElementById("tablaHistorial");
if (tbody) {
  usuario.solicitudes.forEach(s => {
    tbody.innerHTML += `
      <tr>
        <td>${s.id}</td>
        <td>${s.servicio}</td>
        <td><span class="badge ${s.estado === "Pendiente" ? "bg-warning" : "bg-success"}">${s.estado}</span></td>
      </tr>
    `;
  });
}

// =================== BLOQUEAR / DESBLOQUEAR ===================
const btnBloquear = document.getElementById("btnBloquear");
if (btnBloquear) {
  btnBloquear.addEventListener("click", () => {
    if (usuario.estado === "Activo") {
      usuario.estado = "Bloqueado";
      btnBloquear.textContent = "Desbloquear";
      btnBloquear.classList.replace("btn-danger", "btn-success");
      document.getElementById("estadoUsuario").textContent = usuario.estado;
      document.getElementById("estadoUsuario").classList.replace("bg-success", "bg-danger");
    } else {
      usuario.estado = "Activo";
      btnBloquear.textContent = "Bloquear";
      btnBloquear.classList.replace("btn-success", "btn-danger");
      document.getElementById("estadoUsuario").textContent = usuario.estado;
      document.getElementById("estadoUsuario").classList.replace("bg-danger", "bg-success");
    }
  });
}

// =================== INICIALIZAR ===================
renderPerfil();
