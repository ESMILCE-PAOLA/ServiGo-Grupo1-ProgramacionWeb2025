<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/auth.php';

// Iniciar sesión si no existe todavía
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ======================================================
//  MODO DESARROLLO TEMPORAL (solo mientras probás)
// ======================================================
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = [
        'id' => 3, // ID real del profesional en la tabla usuarios
        'nombre' => 'Pablo Profesional',
        'rol' => 'profesional'
    ];
}
// ======================================================

// Detectar si la petición viene de un fetch() (AJAX)
$isAjax =
    isset($_SERVER['HTTP_X_REQUESTED_WITH']) ||
    (isset($_SERVER['CONTENT_TYPE']) && str_contains($_SERVER['CONTENT_TYPE'], 'json'));

// Verificar rol
if (!isRole('profesional')) {

    // Si viene desde fetch() → devolver JSON
    if ($isAjax) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(403);
        echo json_encode([
            'success' => false,
            'error' => 'Acceso no autorizado o sin sesión activa.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Si viene desde navegador → redirigir
    else {
        header('Location: ' . BASE_URL . '/views/visitante/index.php');
        exit;
    }
}

/*
// Solo iniciamos sesión si no existe todavía
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Detectar si la petición viene de un fetch() (AJAX)
$isAjax = (
  isset($_SERVER['HTTP_X_REQUESTED_WITH']) ||
  (isset($_SERVER['CONTENT_TYPE']) && str_contains($_SERVER['CONTENT_TYPE'], 'json'))
);

//  Verificar rol
if (!isRole('profesional')) {
  if ($isAjax) {
    // Si viene desde fetch → devolver JSON
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(403);
    echo json_encode([
      'success' => false,
      'error' => 'Acceso no autorizado o sin sesión activa.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
  } else {
    // Si viene desde el navegador → redirigir
    header('Location: ' . BASE_URL . '/views/visitante/index.php');
    exit;
  }
}
*/