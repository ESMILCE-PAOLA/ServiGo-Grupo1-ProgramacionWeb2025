<?php
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../../includes/session.php';
header('Content-Type: application/json');

// --- Validación del parámetro ---
$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
  http_response_code(400);
  echo json_encode(['success' => false, 'error' => 'ID inválido']);
  exit;
}

// --- Consulta de la solicitud ---
try {
  $sql = "SELECT 
            s.id,
            s.titulo,
            s.descripcion,
            s.direccion,
            l.nombre AS localidad,
            l.codigo_postal,
            s.created_at,
            s.estado,
            u.id AS cliente_id,
            u.nombre AS cliente,
            u.email AS cliente_email
          FROM solicitudes s
          JOIN usuarios u ON u.id = s.cliente_id
          LEFT JOIN localidades l ON l.id = s.id_localidad
          WHERE s.id = ?
          LIMIT 1";


  $stmt = $pdo->prepare($sql);
  $stmt->execute([$id]);
  $solicitud = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$solicitud) {
    http_response_code(404);
    echo json_encode(['success' => false, 'error' => 'Solicitud no encontrada']);
    exit;
  }

  echo json_encode(['success' => true, 'data' => $solicitud]);
  
} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode([
    'success' => false,
    'error' => 'Error al obtener solicitud',
    'detail' => $e->getMessage()
  ]);
}
