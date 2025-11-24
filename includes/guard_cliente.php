<?php
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../backend/config.php';

// ==============================================================================
// 🚧 MODO PRUEBA (SOLO PARA DESARROLLO DEL MÓDULO CLIENTE)
// Si no hay nadie logueado, simulamos ser el Cliente ID 2 (Claudia Cli)
// El líder del proyecto puede borrar este bloque cuando integre el login real.
// ==============================================================================
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = [
        'id' => 2, 
        'nombre' => 'Claudia Cli (Test)', 
        'email' => 'cliente@test.com', 
        'rol' => 'cliente'
    ];
}
// ==============================================================================

// Validación de Seguridad Real
if (!function_exists('isRole') || !isRole('cliente')) {
    // Si es petición AJAX, devolver JSON error
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) || (isset($_SERVER['CONTENT_TYPE']) && str_contains($_SERVER['CONTENT_TYPE'], 'json'))) {
        http_response_code(403);
        echo json_encode(['success' => false, 'error' => 'No autorizado']);
        exit;
    }
    // Si es navegador, mandar al login
    header("Location: " . BASE_URL . "/views/login.php");
    exit;
}
?>