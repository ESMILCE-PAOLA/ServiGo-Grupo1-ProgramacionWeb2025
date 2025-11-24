<?php
require_once __DIR__ . '/../backend/config.php';
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/auth.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isAjax =
    isset($_SERVER['HTTP_X_REQUESTED_WITH']) ||
    (isset($_SERVER['CONTENT_TYPE']) && str_contains($_SERVER['CONTENT_TYPE'], 'json'));

// Validar sesión
if (!isset($_SESSION['user'])) {

    if ($isAjax) {
        header('Content-Type: application/json');
        http_response_code(401);
        echo json_encode(['success' => false, 'error' => 'Debe iniciar sesión.']);
        exit;
    }

    header("Location: " . BASE_URL . "/views/login.php");
    exit;
}

// Validar rol administrador
if (($_SESSION['user']['rol'] ?? '') !== 'administrador') {

    if ($isAjax) {
        header('Content-Type: application/json');
        http_response_code(403);
        echo json_encode(['success' => false, 'error' => 'Acceso no autorizado.']);
        exit;
    }

    header("Location: " . BASE_URL . "/views/visitante/index.php");
    exit;
}
