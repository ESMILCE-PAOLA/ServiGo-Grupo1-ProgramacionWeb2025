<?php


// Solo validar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validaciones simples
    if ($email === '' || !str_contains($email, '@')) {
        header("Location: login.php");
        exit;
    }

    if ($password === '' || strlen($password) < 6) {
        header("Location: login.php");
        exit;
    }

    // Si todo está bien, en esta parte después conectarás con la base de datos
    // Ejemplo de éxito:
    header("");
    exit;
}
?>