<?php
require_once __DIR__ . '/../backend/config.php';
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/auth.php';

// Iniciar sesión si no existe todavía
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Detectar si la petición es AJAX/fetch()
$isAjax =
    isset($_SERVER['HTTP_X_REQUESTED_WITH']) ||
    (isset($_SERVER['CONTENT_TYPE']) && str_contains($_SERVER['CONTENT_TYPE'], 'json'));

// Verificar usuario logueado
if (!isset($_SESSION['user'])) {

    if ($isAjax) {
        // Respuesta JSON para Fetch
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'error' => 'Debe iniciar sesión.'
        ]);
        exit;
    }

    // Si no es AJAX → redirige
    header("Location: " . BASE_URL . "/views/login.php");
    exit;
}

// Verificar que sea profesional
if (($_SESSION['user']['rol'] ?? '') !== 'profesional') {

    if ($isAjax) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(403);
        echo json_encode([
            'success' => false,
            'error' => 'Acceso no autorizado.'
        ]);
        exit;
    }

    header("Location: " . BASE_URL . "/views/visitante/index.php");
    exit;
}

// Verificar que el profesional tenga ID relacionado
if (empty($_SESSION['user']['profesional_id'])) {

    if ($isAjax) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(403);
        echo json_encode([
            'success' => false,
            'error' => 'No tiene un perfil profesional asignado.'
        ]);
        exit;
    }

    echo "<h3>No tiene un perfil profesional asignado.</h3>";
    exit;
}
