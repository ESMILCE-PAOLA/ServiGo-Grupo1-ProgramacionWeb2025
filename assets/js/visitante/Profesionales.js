document.addEventListener("DOMContentLoaded", function () {
  VisualizarProf();
});

async function VisualizarProf() {
  let url = "../../backend/usuarios/visitante/VisualizarProf";

  const response = await fetch(url, {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
  });

  if (response.ok) {
    const data = await response.json();
    console.log("Respuesta del servidor:", data);
    procesarInformacion(data);
  } else {
    console.error("Error en la solicitud:", response.statusText);
  }
}

const procesarInformacion = function (data) {
  if (!data || data.length === 0) {
    let Alert = document.getElementById("AlertaNoProf");
    Alert.classList.remove("d-none");
  }

  console.log("Profesionales recibidos:", data);

  // Selecciono contenedor
  let contenedor = document.getElementById("contenedorTabla");
  contenedor.innerHTML = ""; // limpiar antes

  // Crear tabla
  let tabla = document.createElement("table");
  tabla.className = "table table-striped table-bordered";

  // Encabezado
  tabla.innerHTML = `
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody></tbody>
    `;

  let tbody = tabla.querySelector("tbody");

  // Rellenar filas
  data.forEach((prof) => {
    let fila = document.createElement("tr");

    fila.innerHTML = `
            <td>${prof.nombre}</td>
            <td>
                <button class="btn btn-primary btn-sm ver-mas" data-id="${prof.id}">
                    Ver más
                </button>
            </td>
        `;

    tbody.appendChild(fila);
  });

  contenedor.appendChild(tabla);

  // Agregar eventos a los botones "Ver más"
  document.querySelectorAll(".ver-mas").forEach((btn) => {
    btn.addEventListener("click", function () {
      let idProfesional = this.getAttribute("data-id");

      obtenerDetalle(idProfesional);
    });
  });
};

async function obtenerDetalle(id) {
  let url = "../../backend/usuarios/visitante/DetalleProfesional.php";

  const response = await fetch(url, {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `id=${id}`,
  });

  const data = await response.json();
  console.log(data);
  let modal = new bootstrap.Modal(document.getElementById("ProfModal"));
  modal.show();
  mostrarDatos(data);
}

function mostrarDatos(data) {
  let html = `
        <div class="d-flex align-items-center mb-3">
          <div>
            <h5 class="mb-1">${data.nombre}</h5>
            <small class="text-muted">${data.email || "Sin email"}</small>
            <p>Cuenta creada:${data.created_At}</p>
            </div>
        </div>

        <p class="text-muted">${
          data.descripcion || "No hay descripción disponible."
        }</p>
    `;

  document.getElementById("modalContenido").innerHTML = html;
}
