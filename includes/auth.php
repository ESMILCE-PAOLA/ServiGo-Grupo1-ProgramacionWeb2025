<?php
require_once __DIR__ . '/session.php';

function require_login() {
    if (empty($_SESSION['user'])) {
        header('Location: /ServiGo/views/login.php');
        exit;
    }
}

function current_user() {
    return $_SESSION['user'] ?? null;
}

function require_role($roles = []) {
    $u = current_user();
    if (!$u || !in_array($u['rol_slug'] ?? '', $roles, true)) {
        http_response_code(403);
        echo 'Acceso denegado';
        exit;
    }
}
