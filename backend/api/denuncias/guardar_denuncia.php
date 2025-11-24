<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/session.php';

header('Content-Type: application/json');

try {
    if (!isset($_SESSION['user'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'error' => 'Debe iniciar sesión']);
        exit;
    }

    $user = $_SESSION['user'];
    $rol = $user['rol'];

    $input = json_decode(file_get_contents("php://input"), true);

    $motivo = trim($input['motivo'] ?? '');
    $detalle = trim($input['detalle'] ?? '');
    $idDenunciado = intval($input['denunciado_id'] ?? 0);
    $idSolicitud = intval($input['solicitud_id'] ?? 0);

    if (!$motivo) {
        echo json_encode(['success' => false, 'error' => 'Debe seleccionar un motivo']);
        exit;
    }
    if (!$detalle) {
        echo json_encode(['success' => false, 'error' => 'Debe detallar la denuncia']);
        exit;
    }
    if ($idDenunciado <= 0) {
        echo json_encode(['success' => false, 'error' => 'Usuario denunciado inválido']);
        exit;
    }

    // QUIÉN DENUNCIA SEGÚN ROL
    if ($rol === 'profesional') {
        $reportante_id = $user['id'];
    } elseif ($rol === 'cliente') {
        $reportante_id = $user['id'];
    } else {
        echo json_encode(['success' => false, 'error' => 'Este rol no puede denunciar']);
        exit;
    }

    // Insertar denuncia
    $stmt = $pdo->prepare("
        INSERT INTO denuncias (reportante_id, denunciado_id, motivo, detalle, referencia_id, estado)
        VALUES (:reportante, :denunciado, :motivo, :detalle, :referencia, 'pendiente')
    ");

    $stmt->execute([
        ':reportante' => $reportante_id,
        ':denunciado' => $idDenunciado,
        ':motivo' => $motivo,
        ':detalle' => $detalle,
        ':referencia' => ($idSolicitud > 0 ? $idSolicitud : null)
    ]);

    echo json_encode(['success' => true, 'message' => 'Denuncia enviada']);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
