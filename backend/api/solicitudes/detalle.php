<?php
require_once __DIR__ . '/../../../db.php';
require_once __DIR__ . '/../../../../includes/session.php';



header('Content-Type: application/json');

$id = intval($_GET['id'] ?? 0);
$profesionalId = $_SESSION['user']['id'] ?? 0;

if (!$id || !$profesionalId) {
  echo json_encode(['success' => false, 'error' => 'Parámetros inválidos']);
  exit;
}

try {
  // Trae la solicitud solo si pertenece al profesional
  $sql = "SELECT s.id, s.titulo, s.descripcion, s.direccion, s.estado,
                 s.created_at AS fecha,
                 u.nombre AS cliente,
                 l.nombre AS localidad
          FROM solicitudes s
          JOIN usuarios u ON u.id = s.cliente_id
          LEFT JOIN localidades l ON l.id = s.id_localidad
          JOIN solicitudes_profesionales sp ON sp.solicitud_id = s.id
          WHERE s.id = ? AND sp.profesional_id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$id, $profesionalId]);
  $solicitud = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$solicitud) {
    echo json_encode(['success' => false, 'error' => 'No se encontró la solicitud asignada']);
    exit;
  }

  // Adjuntos
  $stmtAdj = $pdo->prepare("SELECT ruta FROM solicitud_adjuntos WHERE solicitud_id = ?");
  $stmtAdj->execute([$id]);
  $solicitud['adjuntos'] = $stmtAdj->fetchAll(PDO::FETCH_COLUMN);

  // Presupuestos
  $stmtPresu = $pdo->prepare("SELECT id, monto, detalle, estado FROM presupuestos WHERE solicitud_id = ? AND profesional_id = ?");
  $stmtPresu->execute([$id, $profesionalId]);
  $solicitud['presupuestos'] = $stmtPresu->fetchAll(PDO::FETCH_ASSOC);

  // Chat (mensajes)
  $stmtMensajes = $pdo->prepare("
      SELECT m.contenido AS texto,
             CASE WHEN m.emisor_id = ? THEN 'profesional' ELSE 'cliente' END AS emisor,
             m.created_at
      FROM mensajes m
      JOIN chats c ON c.id = m.chat_id
      WHERE c.solicitud_id = ?
      ORDER BY m.created_at ASC
  ");
  $stmtMensajes->execute([$profesionalId, $id]);
  $solicitud['mensajes'] = $stmtMensajes->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode(['success' => true, 'data' => $solicitud]);

} catch (Exception $e) {
  echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
