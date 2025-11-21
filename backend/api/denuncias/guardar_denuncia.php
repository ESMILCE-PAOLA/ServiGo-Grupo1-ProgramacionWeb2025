<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/session.php';
require_once __DIR__ . '/../../../includes/auth.php';

header('Content-Type: application/json');

try {
    // 1. Validación de usuario logueado
    $user = $_SESSION['user'] ?? null;

    if (!$user || ($user['rol'] ?? '') !== 'profesional') {
        http_response_code(401);
        echo json_encode(['success' => false, 'error' => 'No autorizado']);
        exit;
    }

    // 2. Obtener datos enviados en JSON
    $input = json_decode(file_get_contents("php://input"), true);

    $idProfesional = intval($user['id'] ?? 0);
    $idSolicitud = intval($input['solicitud_id'] ?? 0);
    $motivo = trim($input['motivo'] ?? '');
    $detalle = trim($input['detalle'] ?? '');
    $idDenunciado = intval($input['denunciado_id'] ?? 0);

    // 3. Validaciones
    if ($idSolicitud <= 0) {
        echo json_encode(['success' => false, 'error' => 'ID de solicitud inválido']);
        exit;
    }

    if ($idDenunciado <= 0) {
        echo json_encode(['success' => false, 'error' => 'No se pudo determinar el usuario denunciado']);
        exit;
    }

    if (!$motivo) {
        echo json_encode(['success' => false, 'error' => 'Debe seleccionar un motivo de denuncia']);
        exit;
    }

    if (!$detalle) {
        echo json_encode(['success' => false, 'error' => 'Debe escribir un detalle']);
        exit;
    }

    // 4. Insertar denuncia
    $sql = "INSERT INTO denuncias 
            (reportante_id, denunciado_id, motivo, detalle, referencia_id, estado)
            VALUES 
            (:reportante, :denunciado, :motivo, :detalle, :referencia, 'pendiente')";

    $stm = $pdo->prepare($sql);
    $ok = $stm->execute([
        ':reportante' => $idProfesional,
        ':denunciado' => $idDenunciado,
        ':motivo'     => $motivo,
        ':detalle'    => $detalle,
        ':referencia' => $idSolicitud
    ]);

    if (!$ok) {
        echo json_encode(['success' => false, 'error' => 'No se pudo registrar la denuncia']);
        exit;
    }

    // 5. Cambiar estado en solicitudes_profesionales
    $sql2 = "UPDATE solicitudes_profesionales 
             SET estado = 'pendiente'
             WHERE solicitud_id = :idSolicitud AND profesional_id = :idProfesional";

    $stm2 = $pdo->prepare($sql2);
    $stm2->execute([
        ':idSolicitud' => $idSolicitud,
        ':idProfesional' => $idProfesional
    ]);

    echo json_encode(['success' => true, 'message' => 'Denuncia enviada correctamente']);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
