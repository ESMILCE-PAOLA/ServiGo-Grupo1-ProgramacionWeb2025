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

  $solicitud_id = intval($_POST['solicitud_id'] ?? 0);
  $monto = floatval($_POST['monto'] ?? 0);
  $plazo_dias = intval($_POST['plazo_dias'] ?? 0);
  $validez_dias = intval($_POST['validez_dias'] ?? 0);
  $metodo_pago = trim($_POST['metodo_pago'] ?? '');
  $descripcion = trim($_POST['descripcion'] ?? '');

  if ($solicitud_id <= 0 || $monto <= 0 || !$metodo_pago || !$descripcion) {
    echo json_encode(['success' => false, 'error' => 'Faltan datos obligatorios']);
    exit;
  }

  $sql = "INSERT INTO presupuestos (solicitud_id, profesional_id, monto, plazo_dias, validez_dias, metodo_pago, descripcion, estado, created_at)
          VALUES (:sid, :pid, :monto, :plazo, :validez, :metodo, :desc, 'Pendiente', NOW())";
  $stm = $pdo->prepare($sql);
  $stm->execute([
    ':sid' => $solicitud_id,
    ':pid' => $user['id'],
    ':monto' => $monto,
    ':plazo' => $plazo_dias,
    ':validez' => $validez_dias,
    ':metodo' => $metodo_pago,
    ':desc' => $descripcion
  ]);

  echo json_encode(['success' => true]);

} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
