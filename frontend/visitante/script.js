document.addEventListener("DOMContentLoaded", () => {
  // 1. Datos simulados de profesionales
  const profesionales = [
    { id: 1, nombre: "Carlos López", rubro: "Electricista", localidad: "González Catán", activo: true, puntuacion: 4.8, foto: "https://picsum.photos/seed/pro1/600/400" },
    { id: 2, nombre: "Ana Torres", rubro: "Plomera", localidad: "La Matanza", activo: false, puntuacion: 4.6, foto: "https://picsum.photos/seed/pro2/600/400" },
    { id: 3, nombre: "Martín Díaz", rubro: "Carpintero", localidad: "Morón", activo: true, puntuacion: 4.9, foto: "https://picsum.photos/seed/pro3/600/400" },
    { id: 4, nombre: "Lucía Fernández", rubro: "Barbera", localidad: "Lanús", activo: true, puntuacion: 4.7, foto: "https://picsum.photos/seed/pro4/600/400" },
    { id: 5, nombre: "Pedro Gómez", rubro: "Electricista", localidad: "Moreno", activo: true, puntuacion: 4.5, foto: "https://picsum.photos/seed/pro5/600/400" },
  ];

  // 2. Filtrar solo activos y mezclar
  let activos = profesionales.filter(p => p.activo);
  activos.sort((a, b) => a.rubro === b.rubro ? b.puntuacion - a.puntuacion : 0);
  activos = activos.sort(() => Math.random() - 0.5);

  const grid = document.getElementById("gridProfesionales");

  // Función para renderizar tarjetas
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
            <button class="btn btn-outline-primary w-100 btnVer" onclick="location.href='perfil.html'">
                <i class="bi bi-eye"></i> Ver perfil completo
            </button>
            </div>
        </div>
      `;
      grid.appendChild(col);
    });
  }

  // Render inicial
  renderizar(activos);

  // 3. Buscador
  const btnBuscar = document.getElementById("btnBuscar");
  let isLogged = false; // Cambiar a true si hay login real

  btnBuscar.addEventListener("click", (e) => {
    e.preventDefault();

    if (!isLogged) {
      const modalAviso = new bootstrap.Modal(document.getElementById("modalAviso"));
      modalAviso.show();
      return;
    }

    const servicio = document.getElementById("buscarServicio").value.toLowerCase();
    const localidad = document.getElementById("filtroLocalidad").value.toLowerCase();
    const ordenar = document.getElementById("ordenarPor").value;

    let filtrados = activos.filter(p => {
      const coincideServicio = servicio === "" || p.rubro.toLowerCase().includes(servicio);
      const coincideLocalidad = localidad === "" || p.localidad.toLowerCase() === localidad;
      return coincideServicio && coincideLocalidad;
    });

    // Ordenar según selección
    if (ordenar === "puntuacion") {
      filtrados.sort((a, b) => b.puntuacion - a.puntuacion);
    } else if (ordenar === "nombre") {
      filtrados.sort((a, b) => a.nombre.localeCompare(b.nombre));
    } else if (ordenar === "random") {
      filtrados = filtrados.sort(() => Math.random() - 0.5);
    }

    renderizar(filtrados);
  });

  // 4. Bloqueo para visitante en links y botones
  document.addEventListener("click", (e) => {
    if (!isLogged && (
        e.target.classList.contains("nav-link") ||
        e.target.classList.contains("btnVer") ||
        e.target.id === "btnBuscar")) {

      e.preventDefault();
      const modalAviso = new bootstrap.Modal(document.getElementById("modalAviso"));
      modalAviso.show();
    }
  });
});
