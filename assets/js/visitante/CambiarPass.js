const clave = document.getElementById("nuevaPass");
const clave2 = document.getElementById("ComparacionPass");
const email = document.getElementById("email");
const div1 = document.getElementById("DivnuevaPass");
const div2 = document.getElementById("DivCompararClaves");
const divMail = document.getElementById("DivEmail");
const form = document.getElementById("formCambiarPass");

document.addEventListener("DOMContentLoaded", function () {
  clave.addEventListener("input", validar);
  clave2.addEventListener("input", validar);
  email.addEventListener("input", validar);

  form.addEventListener("submit", (e) => {
    e.preventDefault();
    if (validar()) {
      // form.submit();
      //window.location.href = "ServiGo-Visitante/views/login.php";
      EncontrarUsuario();
    }
  });
});

function validar() {
  if (email.value.trim() === "") {
    divMail.textContent = "El email es obligatorio.";
    email.classList.add("is-invalid");
    return false;
  } else {
    // si ya hay algo, quitamos el aviso de vacío
    divMail.textContent = "";
    email.classList.remove("is-invalid");
  }

  if (clave.value === "") {
    div1.textContent = "La contraseña es obligatoria.";
    clave.classList.add("is-invalid");
    return false;
  } else {
    div1.textContent = "";
    clave.classList.remove("is-invalid");
  }

  if (clave2.value === "") {
    div2.textContent = "Repite la contraseña.";
    clave2.classList.add("is-invalid");
    return false;
  } else {
    div2.textContent = "";
    clave2.classList.remove("is-invalid");
  }

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const regex = /^(?=.[°|!"#$%&/()=?'¡¿´¨+{\[}\]\-\_:.,;><]).{8,}$/;

  let okE = emailRegex.test(email.value.trim());
  let ok1 = regex.test(clave.value);
  let ok2 = clave.value === clave2.value;

  divMail.textContent = okE ? "" : "Email no válido.";
  div1.textContent = ok1 ? "" : "Mínimo 8 caracteres y un símbolo.";
  div2.textContent = ok2 ? "" : "Las claves no coinciden.";

  email.classList.toggle("is-invalid", !okE);
  clave.classList.toggle("is-invalid", !ok1);
  clave2.classList.toggle("is-invalid", !ok2);

  return okE && ok1 && ok2;
}

async function EncontrarUsuario() {
  const url = "/ServiGo-Visitante/backend/api/usuarios/CambiarPass.php";

  const params = new URLSearchParams({
    email: email.value,
    nuevaPass: clave.value,
    ComparacionPass: clave2.value,
  });

  const respuesta = await fetch(url, {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: params,
  });

  const texto = await respuesta.text();
  console.log("RAW:", texto);
  const data = JSON.parse(texto);
  //const data = await respuesta.json();

  if (respuesta.ok && data.status !== "error") {
    console.log("respuesta del servidor", data);
    await Swal.fire({
      position: "top-end",
      icon: "success",
      title: "Contraseña cambiada",
      showConfirmButton: false,
      timer: 1500,
    });
    window.location.href = "/ServiGo-Visitante/views/login.php";
  } else {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: data.message, // <- aquí aparece tu error de PHP
    });
  }
}