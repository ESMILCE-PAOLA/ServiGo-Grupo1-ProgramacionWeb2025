// =================== DATOS HARCODEADOS ===================

// Solicitudes
const solicitudes = [
  { id: "S01", cliente: "María López", servicio: "Electricidad", profesional: "-", estado: "Pendiente" },
  { id: "S02", cliente: "Carlos Díaz", servicio: "Plomería", profesional: "Ana Torres", estado: "Finalizado" },
  { id: "S03", cliente: "Luis Pérez", servicio: "Carpintería", profesional: "Martín Díaz", estado: "En curso" }
];

// Usuarios
const usuarios = [
  { id: "U01", dni: "30123456", nombre: "Ana Torres", email: "ana@mail.com", rol: "Profesional", estado: "Activo" },
  { id: "U02", dni: "29876543", nombre: "Carlos López", email: "carlos@mail.com", rol: "Cliente", estado: "Bloqueado" },
  { id: "U03", dni: "31222444", nombre: "Admin Test", email: "admin@mail.com", rol: "Administrador", estado: "Activo" }
];


// Perfil de usuario (ejemplo fijo para test)
const perfilUsuario = {
  id: "U01",
  dni: "30123456",
  nombre: "Ana Torres",
  email: "ana@mail.com",
  rol: "Profesional",
  estado: "Activo",
  solicitudes: [
    { id: "S01", servicio: "Electricidad", estado: "Pendiente" },
    { id: "S05", servicio: "Carpintería", estado: "Finalizado" }
  ]
};

// =================== SOLICITUDES ===================
const tbodySolicitudes = document.querySelector("#tablaSolicitudes tbody");
if (tbodySolicitudes) {
  function mostrarSolicitudes(lista) {
    tbodySolicitudes.innerHTML = "";
    lista.forEach(s => {
      tbodySolicitudes.innerHTML += `
        <tr>
          <td>${s.id}</td>
          <td>${s.cliente}</td>
          <td>${s.servicio}</td>
          <td>${s.profesional}</td>
          <td><span class="badge ${
            s.estado === "Pendiente" ? "bg-warning" :
            s.estado === "En curso" ? "bg-info" :
            s.estado === "Finalizado" ? "bg-success" : "bg-danger"
          }">${s.estado}</span></td>
          <td>
            <button class="btn btn-primary btn-sm">Ver detalle</button>
            ${s.estado === "Pendiente" ? `<button class="btn btn-success btn-sm">Asignar</button>` : ""}
          </td>
        </tr>
      `;
    });
  }
  mostrarSolicitudes(solicitudes);

  document.getElementById("filtroEstado").addEventListener("change", e => {
    const estado = e.target.value;
    const filtradas = estado === "" ? solicitudes : solicitudes.filter(s => s.estado === estado);
    mostrarSolicitudes(filtradas);
  });
}

// =================== USUARIOS ===================
const tbodyUsuarios = document.querySelector("#tablaUsuarios tbody");
if (tbodyUsuarios) {
  function mostrarUsuarios(lista) {
    tbodyUsuarios.innerHTML = "";
    lista.forEach(u => {
      tbodyUsuarios.innerHTML += `
        <tr>
          <td>${u.id}</td>
          <td>${u.dni}</td>
          <td>${u.nombre}</td>
          <td>${u.email}</td>
          <td>${u.rol}</td>
          <td><span class="badge ${u.estado === "Activo" ? "bg-success" : "bg-danger"}">${u.estado}</span></td>
          <td>
            <a href="../comunes/Perfil.html?id=${u.id}" class="btn btn-info btn-sm">
              <i class="bi bi-person-lines-fill"></i> Ver Perfil
            </a>
          </td>
        </tr>
      `;
    });
  }
  mostrarUsuarios(usuarios);

  // Buscador + filtro
  document.getElementById("btnBuscar").addEventListener("click", () => {
    const texto = document.getElementById("buscador").value.toLowerCase();
    const rolSel = document.getElementById("filtroRol").value;

    const filtrados = usuarios.filter(u =>
      (u.id.toLowerCase().includes(texto) ||
       u.dni.includes(texto) ||
       u.nombre.toLowerCase().includes(texto)) &&
      (rolSel === "" || u.rol === rolSel)
    );
    mostrarUsuarios(filtrados);
  });

  document.getElementById("filtroRol").addEventListener("change", e => {
    const rolSel = e.target.value;
    const filtrados = rolSel === "" ? usuarios : usuarios.filter(u => u.rol === rolSel);
    mostrarUsuarios(filtrados);
  });
}

// =================== DENUNCIAS ===================
const denuncias = [
  // Perfil - Profesional
  { id: "D01", denunciante: "Juan López", dniDenunciante: "30123456", denunciado: "Pedro Gómez", dniDenunciado: "29888777", tipo: "perfil", motivo: "Incumplimiento en el servicio", fecha: "2025-09-20", estado: "pendiente", usuarioTipo: "Profesional" },
  { id: "D02", denunciante: "María Torres", dniDenunciante: "30122222", denunciado: "Ana Torres", dniDenunciado: "30123456", tipo: "perfil", motivo: "Perfil falso", fecha: "2025-09-18", estado: "resuelta", usuarioTipo: "Profesional" },

  // Comentario - Profesional
  { id: "D03", denunciante: "Marta Pérez", dniDenunciante: "31222444", denunciado: "Ana Torres", dniDenunciado: "30123456", tipo: "comentario", motivo: "Maltrato verbal en reseña", fecha: "2025-09-15", estado: "resuelta", usuarioTipo: "Profesional" },
  { id: "D04", denunciante: "Roberto Gómez", dniDenunciante: "30999888", denunciado: "Carlos López", dniDenunciado: "29876543", tipo: "comentario", motivo: "Comentario ofensivo", fecha: "2025-09-17", estado: "pendiente", usuarioTipo: "Profesional" },

  // Chat - Profesional
  { id: "D05", denunciante: "Laura Méndez", dniDenunciante: "31111444", denunciado: "Ana Torres", dniDenunciado: "30123456", tipo: "chat", motivo: "Lenguaje inapropiado en chat", fecha: "2025-09-10", estado: "en curso", usuarioTipo: "Profesional" },

  // Perfil - Cliente
  { id: "D06", denunciante: "Luis Díaz", dniDenunciante: "30111444", denunciado: "Carlos López", dniDenunciado: "29999888", tipo: "perfil", motivo: "Datos personales falsos", fecha: "2025-09-12", estado: "pendiente", usuarioTipo: "Cliente" },

  // Comentario - Cliente
  { id: "D07", denunciante: "Ana Ruiz", dniDenunciante: "31122333", denunciado: "Marcos Fernández", dniDenunciado: "30156789", tipo: "comentario", motivo: "Comentario ofensivo", fecha: "2025-09-14", estado: "en curso", usuarioTipo: "Cliente" },

  // Chat - Cliente
  { id: "D08", denunciante: "José Ramírez", dniDenunciante: "31233444", denunciado: "Sofía López", dniDenunciado: "30244555", tipo: "chat", motivo: "Acoso en chat privado", fecha: "2025-09-19", estado: "pendiente", usuarioTipo: "Cliente" },
  { id: "D09", denunciante: "Pablo Ortega", dniDenunciante: "31111111", denunciado: "Lucía Torres", dniDenunciado: "30222222", tipo: "chat", motivo: "Mensajes spam", fecha: "2025-09-11", estado: "resuelta", usuarioTipo: "Cliente" },

  // Caso mixto extra
  { id: "D10", denunciante: "Clara Gómez", dniDenunciante: "30155555", denunciado: "Federico Ríos", dniDenunciado: "30333333", tipo: "perfil", motivo: "Usurpación de identidad", fecha: "2025-09-13", estado: "en curso", usuarioTipo: "Profesional" }
];

const tablaDenuncias = document.querySelector("#tablaDenuncias");
if (tablaDenuncias) {
  const tbodyDenuncias = tablaDenuncias.querySelector("tbody");
  const contador = document.getElementById("contadorDenuncias");

  function badgeEstado(estado) {
    if (estado === "pendiente") return '<span class="badge bg-warning text-dark">Pendiente</span>';
    if (estado === "en curso")  return '<span class="badge bg-info text-dark">En curso</span>';
    return '<span class="badge bg-success">Resuelta</span>';
  }

  function mostrarDenuncias(lista) {
    tbodyDenuncias.innerHTML = "";
    lista.forEach(d => {
      tbodyDenuncias.innerHTML += `
        <tr>
          <td>${d.id}</td>
          <td>${d.denunciante}</td>
          <td>${d.dniDenunciante}</td>
          <td>${d.denunciado}</td>
          <td>${d.dniDenunciado}</td>
          <td>${d.tipo}</td>
          <td>${d.motivo}</td>
          <td>${d.fecha}</td>
          <td>${badgeEstado(d.estado)}</td>
          <td>
            <button class="btn btn-info btn-sm" onclick="irAGestionUsuario('${d.dniDenunciado}')">Ver Usuario</button>
          </td>
        </tr>
      `;
    });

    // contador y campanita
    if (contador) contador.textContent = `Se encontraron ${lista.length} denuncia(s).`;
    const badgeBell = document.getElementById("badgeDenuncias");
    if (badgeBell) badgeBell.textContent = denuncias.filter(x => x.estado === "pendiente").length;
  }

  // --- Filtros ---
  const selTipo    = document.getElementById("filtroTipo");
  const selUsuario = document.getElementById("filtroUsuario");
  const selEstado  = document.getElementById("filtroEstado");
  const fechaDesde = document.getElementById("fechaDesde");
  const fechaHasta = document.getElementById("fechaHasta");

  function filtrar() {
    const tipo       = selTipo.value;
    const usuarioTip = selUsuario.value;
    const estado     = selEstado.value;
    const fDesde     = fechaDesde.value;
    const fHasta     = fechaHasta.value;

    const res = denuncias.filter(d => {
      const okTipo   = !tipo || d.tipo === tipo;
      const okUsu    = !usuarioTip || d.usuarioTipo === usuarioTip;
      const okEstado = !estado || d.estado === estado;

      let okFecha = true;
      if (fDesde) okFecha = d.fecha >= fDesde;
      if (fHasta) okFecha = okFecha && d.fecha <= fHasta;

      return okTipo && okUsu && okEstado && okFecha;
    });

    mostrarDenuncias(res);
  }

  [selTipo, selUsuario, selEstado, fechaDesde, fechaHasta].forEach(el => {
    if (el) el.addEventListener("change", filtrar);
  });

  // Inicial
  mostrarDenuncias(denuncias);
}

// =================== REDIRECCIÓN A GESTIÓN DE USUARIOS ===================
function irAGestionUsuario(dni) {
  window.location.href = `GestionUsuarios.html?dni=${dni}`;
}
