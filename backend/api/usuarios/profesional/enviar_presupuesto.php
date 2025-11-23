<?php
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../../includes/session.php';
header('Content-Type: application/json');

$profId = $_SESSION['user']['id'] ?? 0;
if(!$profId){ http_response_code(401); echo json_encode(['success'=>false,'error'=>'Sin sesión']); exit; }

$solicitud_id = intval($_POST['solicitud_id'] ?? 0);
$monto        = floatval($_POST['monto'] ?? 0);
$plazo_dias   = intval($_POST['plazo_dias'] ?? 0);
$detalle      = trim($_POST['detalle'] ?? '');

if($solicitud_id<=0 || $monto<=0 || $plazo_dias<=0 || $detalle===''){
  echo json_encode(['success'=>false,'error'=>'Datos inválidos']); exit;
}

$stm = $pdo->prepare("INSERT INTO presupuestos (solicitud_id, profesional_id, monto, plazo_dias, detalle, estado, created_at)
                      VALUES (?,?,?,?,?,'enviado',NOW())");
$ok = $stm->execute([$solicitud_id, $profId, $monto, $plazo_dias, $detalle]);

echo json_encode(['success'=>$ok]);
