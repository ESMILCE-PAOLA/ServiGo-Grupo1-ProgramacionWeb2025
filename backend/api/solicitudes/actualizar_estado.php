<?php
declare(strict_types=1);

require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../../includes/session.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['success' => false, 'error' => 'Método no permitido']);
  exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$id = intval($data['id'] ?? 0);
$nuevoEstado = trim($data['estado'] ?? '');
$profesionalId = $_SESSION['user']['id'] ?? 0;

if (!$id || !$nuevoEstado || !$profesionalId) {
  echo json_encode(['success' => false, 'error' => 'Parámetros inválidos']);
  exit;
}

try {
  $sql = "UPDATE solicitudes s
          JOIN solicitudes_profesionales sp ON sp.solicitud_id = s.id
          SET s.estado = :estado
          WHERE s.id = :id AND sp.profesional_id = :profesional";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':estado' => $nuevoEstado,
    ':id' => $id,
    ':profesional' => $profesionalId
  ]);

  if ($stmt->rowCount() === 0) {
    echo json_encode(['success' => false, 'error' => 'No se encontró la solicitud o no tiene permisos.']);
    exit;
  }

  echo json_encode(['success' => true, 'message' => 'Estado actualizado correctamente.']);
} catch (Exception $e) {
  echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
