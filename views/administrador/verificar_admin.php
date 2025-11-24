<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está logueado (Campo 'id')
if (!isset($_SESSION['id'])) {

    if (isset($_SESSION['usuario_id'])) {
        $_SESSION['id'] = $_SESSION['usuario_id'];
    } else {
      
        header('Location: ../../views/visitante/login.php');
        exit;
    }
}

// Verificar si es Administrador

if (!isset($_SESSION['rol_id']) || $_SESSION['rol_id'] != 1) {

    header('Location: ../../index.php');
    exit;
}

//  Verificar nombre 
if (!isset($_SESSION['nombre'])) {
    $_SESSION['nombre'] = 'Administrador';
}
?>