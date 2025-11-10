<?php
require_once __DIR__ . '/../../../../includes/db.php';
require_once __DIR__ . '/../../../../includes/session.php';
require_once __DIR__ . '/../../../../includes/auth.php';
header('Content-Type: application/json');

try {
  $user = $_SESSION['user'] ?? null;
  if (!$user || ($user['rol'] ?? '') !== 'profesional') {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit;
  }

  $id = intval($_GET['id'] ?? 0);
  if ($id <= 0) {
    echo json_encode(['success' => false, 'error' => 'ID inválido']);
    exit;
  }

  $sql = "SELECT 
            s.id,
            s.titulo,
            s.descripcion,
            s.direccion,
            l.nombre AS localidad,
            l.codigo_postal,
            s.estado,
            s.created_at,
            u.id AS cliente_id,
            u.nombre AS cliente,
            u.email
          FROM solicitudes s
          JOIN usuarios u ON u.id = s.cliente_id
          LEFT JOIN localidades l ON l.id = s.id_localidad
          WHERE s.id = :id
          LIMIT 1";

  $stm = $pdo->prepare($sql);
  $stm->execute([':id' => $id]);
  $solicitud = $stm->fetch(PDO::FETCH_ASSOC);

  if (!$solicitud) {
    echo json_encode(['success' => false, 'error' => 'Solicitud no encontrada']);
    exit;
  }

  echo json_encode(['success' => true, 'data' => $solicitud]);

} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
