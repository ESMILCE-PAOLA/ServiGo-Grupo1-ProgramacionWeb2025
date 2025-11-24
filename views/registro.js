

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formulario");

    form.addEventListener("submit", function (e) {
        const nombre = document.getElementById("nombre").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value.trim();

        // Validar nombre
        if (nombre.length < 6) {
            alert("El nombre debe tener al menos 6 caracteres.");
            e.preventDefault();
            return;
        }

        // Validar email
        if (email === "" || !email.includes("@") || !email.includes(".")) {
            alert("Debes ingresar un email válido.");
            e.preventDefault();
            return;
        }

        // Validar contraseña
        if (password.length < 6) {
            alert("La contraseña debe tener al menos 6 caracteres.");
            e.preventDefault();
            return;
        }

        // Si todo está bien, el formulario se envía normalmente
    });
});
