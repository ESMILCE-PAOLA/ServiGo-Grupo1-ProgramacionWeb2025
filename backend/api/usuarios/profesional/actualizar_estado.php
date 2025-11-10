<?php
require_once __DIR__ . '/../../../../includes/db.php';
require_once __DIR__ . '/../../../../includes/session.php';
header('Content-Type: application/json');

try {
  $user = $_SESSION['user'] ?? null;
  if (!$user || ($user['rol'] ?? '') !== 'profesional') {
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit;
  }

  $input = json_decode(file_get_contents('php://input'), true);
  $idSolicitud = intval($input['id_solicitud'] ?? 0);
  $nuevoEstado = trim($input['estado'] ?? '');

  if ($idSolicitud <= 0 || !in_array($nuevoEstado, ['aceptada', 'rechazada'])) {
    echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
    exit;
  }

  $idProfesional = intval($user['id']);

  // Verificar que la relación solicitud-profesional existe
  $stmtCheck = $pdo->prepare("
    SELECT id 
    FROM solicitudes_profesionales 
    WHERE solicitud_id = :solicitud_id AND profesional_id = :profesional_id
  ");
  $stmtCheck->execute([
    ':solicitud_id' => $idSolicitud,
    ':profesional_id' => $idProfesional
  ]);

  if (!$stmtCheck->fetch()) {
    echo json_encode(['success' => false, 'error' => 'No existe relación entre profesional y solicitud']);
    exit;
  }

  // Actualizar estado
  $stmtUpdate = $pdo->prepare("
    UPDATE solicitudes_profesionales
    SET estado = :estado, fecha_respuesta = NOW()
    WHERE solicitud_id = :solicitud_id AND profesional_id = :profesional_id
  ");
  $stmtUpdate->execute([
    ':estado' => $nuevoEstado,
    ':solicitud_id' => $idSolicitud,
    ':profesional_id' => $idProfesional
  ]);

  echo json_encode(['success' => true, 'message' => 'Estado actualizado correctamente']);

} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
