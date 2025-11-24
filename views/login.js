
let form = document.getElementById("formulario");
let email = document.getElementById("email");
let password = document.getElementById("password");
let alert = document.getElementById("alert");

form.onsubmit = function (e) {

    alert.classList.add("d-none");

    // Validar email vacío
    if (email.value.trim() === "") {
        e.preventDefault();
        alert.textContent = "El email es obligatorio.";
        alert.classList.remove("d-none");
        return;
    }

    // Validar email con @
    if (!email.value.includes("@")) {
        e.preventDefault();
        alert.textContent = "El email debe contener @.";
        alert.classList.remove("d-none");
        return;
    }

    // Validar contraseña vacía
    if (password.value.trim() === "") {
        e.preventDefault();
        alert.textContent = "La contraseña es obligatoria.";
        alert.classList.remove("d-none");
        return;
    }

    // Validar contraseña corta
    if (password.value.length < 6) {
        e.preventDefault();
        alert.textContent = "La contraseña debe tener al menos 6 caracteres.";
        alert.classList.remove("d-none");
        return;
    }
};
