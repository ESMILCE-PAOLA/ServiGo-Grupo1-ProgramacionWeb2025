<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/session.php';

header('Content-Type: application/json; charset=utf-8');

// Validar método
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    exit;
}

// Leer JSON
$input = json_decode(file_get_contents('php://input'), true);

$idSolicitud = intval($input['id_solicitud'] ?? 0);
$nuevoEstado = trim($input['estado'] ?? '');
$idProfesional = $_SESSION['user']['id'] ?? 0;

// Verificar datos obligatorios
if ($idSolicitud <= 0 || !$nuevoEstado || !$idProfesional) {
    echo json_encode(['success' => false, 'error' => 'Parámetros inválidos']);
    exit;
}

// Solo permitir estos estados
$estadosPermitidos = ['aceptada', 'rechazada'];
if (!in_array($nuevoEstado, $estadosPermitidos)) {
    echo json_encode(['success' => false, 'error' => 'Estado inválido']);
    exit;
}

try {

    // Verificar relación solicitud-profesional
    $stmtCheck = $pdo->prepare("
        SELECT id 
        FROM solicitudes_profesionales
        WHERE solicitud_id = :s AND profesional_id = :p
    ");
    $stmtCheck->execute([
        ':s' => $idSolicitud,
        ':p' => $idProfesional
    ]);

    if (!$stmtCheck->fetch()) {
        echo json_encode(['success' => false, 'error' => 'No existe relación entre profesional y solicitud']);
        exit;
    }

    // Actualizar estado en la tabla correcta
    $stmtUpdate = $pdo->prepare("
        UPDATE solicitudes_profesionales
        SET estado = :estado, fecha_respuesta = NOW()
        WHERE solicitud_id = :s AND profesional_id = :p
    ");

    $stmtUpdate->execute([
        ':estado' => $nuevoEstado,
        ':s' => $idSolicitud,
        ':p' => $idProfesional
    ]);

    echo json_encode(['success' => true, 'message' => 'Estado actualizado correctamente']);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
