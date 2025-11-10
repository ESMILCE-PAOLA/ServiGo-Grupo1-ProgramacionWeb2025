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

  $estado = $_GET['estado'] ?? '';
  $fechaDesde = $_GET['fechaDesde'] ?? '';
  $fechaHasta = $_GET['fechaHasta'] ?? '';

  $sql = "SELECT 
            p.id,
            s.titulo AS solicitud,
            u.nombre AS cliente,
            p.monto,
            p.plazo_dias,
            p.validez_dias,
            p.estado,
            DATE(p.created_at) AS created_at
          FROM presupuestos p
          JOIN solicitudes s ON s.id = p.solicitud_id
          JOIN usuarios u ON u.id = s.cliente_id
          WHERE p.profesional_id = :pid";

  $params = [':pid' => $user['id']];

  if ($estado) {
    $sql .= " AND p.estado = :estado";
    $params[':estado'] = $estado;
  }

  if ($fechaDesde) {
    $sql .= " AND DATE(p.created_at) >= :desde";
    $params[':desde'] = $fechaDesde;
  }

  if ($fechaHasta) {
    $sql .= " AND DATE(p.created_at) <= :hasta";
    $params[':hasta'] = $fechaHasta;
  }

  $sql .= " ORDER BY p.created_at DESC";

  $stm = $pdo->prepare($sql);
  $stm->execute($params);
  $data = $stm->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode(['success' => true, 'data' => $data]);

} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
