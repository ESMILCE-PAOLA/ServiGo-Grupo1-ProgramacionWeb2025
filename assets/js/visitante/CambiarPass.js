const clave = document.getElementById("password");
const errorClave = document.querySelector(".clave1-mal");
const clave2 = document.getElementById("password2");
const errorClave2 = document.querySelector(".clave2-mal");
const btnEnviar = document.querySelector(".enviar-btn");
let clave1Bien = false;
let clave2Bien = false;

const verificarClaves = function () {
  const regex = /^(?=.*[°|!"#$%&/()=?'¡¿´¨*+{\[}\]\-\_:.,;><]).{8,}$/;

  clave.addEventListener("input", function () {
    if (!regex.test(clave.value)) {
      errorClave.textContent = clave.title;
      errorClave.classList.remove("d-none");
      clave1Bien = false;
    } else {
      clave1Bien = true;
      errorClave.classList.add("d-none");
    }
  });
  clave2.addEventListener("input", function () {
    if (clave2.value !== clave.value) {
      errorClave2.textContent = "Las claves no coinciden";
      errorClave2.classList.remove("d-none");
      clave2Bien = false;
    } else {
      clave2Bien = true;
      errorClave2.classList.add("d-none");
    }
  });
};
addEventListener("DOMContentLoaded", verificarClaves);

btnEnviar.addEventListener("click", function (e) {
  e.preventDefault();

  if (clave1Bien && clave2Bien) {
    clave.value = "";
    clave2.value = "";
    window.location.href = "../Main/main.html";
  } else {
    if (!clave1Bien) {
      errorClave.textContent = clave.title;
      errorClave.classList.remove("d-none");
    }
    errorClave2.classList.remove("d-none");
  }
});
