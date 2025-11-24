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

  $idProfesional = intval($user['id'] ?? 0);
  if ($idProfesional <= 0) {
    throw new Exception("Profesional no válido");
  }

  // Parámetros de filtros
  $fechaDesde = $_GET['fechaDesde'] ?? '';
  $fechaHasta = $_GET['fechaHasta'] ?? '';
  $estado     = $_GET['estado'] ?? '';
  $etapa      = $_GET['etapa'] ?? '';
  $localidad  = $_GET['localidad'] ?? '';

  // Consulta base
  $sql = "SELECT 
            s.id,
            u.nombre AS cliente,
            s.descripcion AS detalle,
            l.nombre AS localidad,
            DATE(s.created_at) AS fecha,
            sp.estado,
            COALESCE(sp.etapa, 'pendiente') AS etapa
          FROM solicitudes_profesionales sp
          JOIN solicitudes s ON s.id = sp.solicitud_id
          JOIN usuarios u ON u.id = s.cliente_id
          LEFT JOIN localidades l ON l.id = s.id_localidad
          WHERE sp.profesional_id = :profesional_id";


  $params = [':profesional_id' => $idProfesional];

  // Aplicar filtros dinámicamente
  if (!empty($fechaDesde)) {
    $sql .= " AND DATE(s.created_at) >= :desde";
    $params[':desde'] = $fechaDesde;
  }

  if (!empty($fechaHasta)) {
    $sql .= " AND DATE(s.created_at) <= :hasta";
    $params[':hasta'] = $fechaHasta;
  }

  if (!empty($estado)) {
    $sql .= " AND sp.estado = :estado";
    $params[':estado'] = $estado;
  }

  if (!empty($etapa)) {
    $sql .= " AND sp.etapa = :etapa";
    $params[':etapa'] = $etapa;
  }

  if (!empty($localidad)) {
    $sql .= " AND l.nombre = :localidad";
    $params[':localidad'] = $localidad;
  }

  $sql .= " ORDER BY s.created_at DESC";

  $stm = $pdo->prepare($sql);
  $stm->execute($params);
  $data = $stm->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode(['success' => true, 'data' => $data]);
  
} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode([
    'success' => false,
    'error' => 'Error en la consulta: ' . $e->getMessage()
  ]);
}
