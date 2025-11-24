<?php
require __DIR__ . '/../conec.php';  // AJUSTA LA RUTA SI ES NECESARIO


// Solo si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // ------------------------------
    // VALIDACIONES EN PHP
    // ------------------------------

    // Nombre vacío o muy corto
    if ($nombre === '' || strlen($nombre) < 6) {
        header("Location: registro.php");
        exit;
    }

    // Validar email simple
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: registro.php");
        exit;
    }

    // Contraseña mínima
    if (strlen($password) < 6) {
        header("Location: registro.php");
        exit;
    }

    // ------------------------------
    // INSERTAR EN LA BASE DE DATOS
    // ------------------------------

    // IMPORTANTE: Encriptar la contraseña
    $passHash = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $nombre, $email, $passHash);

    if (mysqli_stmt_execute($stmt)) {
        // Registro OK → Va al login
        header("Location: login.php");
        exit;
    } else {
        // Error al insertar
        header("Location: registro.php");
        exit;
    }
}
?>
