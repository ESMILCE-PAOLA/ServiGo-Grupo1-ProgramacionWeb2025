<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

$rol = $_GET['rol'] ?? null;

if (!$rol) {
    echo "Debe especificar rol";
    exit;
}

// Simulamos usuario según el rol
if ($rol === "profesional") {

    // BUSCAMOS UN PROFESIONAL DE LA BD
    $stmt = $pdo->query("SELECT usuarios.id AS usuario_id, profesionales.id AS profesional_id
                         FROM usuarios
                         INNER JOIN profesionales ON profesionales.usuario_id = usuarios.id
                         LIMIT 1");

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        $_SESSION['user'] = [
            "id" => $data['usuario_id'],
            "email" => "prof@test.com",
            "nombre" => "Profesional Test",
            "rol" => "profesional",
            "profesional_id" => $data['profesional_id']
        ];

        echo "Sesión iniciada como profesional (ID profesional: {$data['profesional_id']})";

    } else {
        echo "No existe ningún profesional en la BD.";
    }

} else {
    echo "Rol no soportado todavía.";
}
