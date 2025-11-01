<?php
require __DIR__ . '/../../db.php';
require __DIR__ . '/../../../includes/session.php';
header('Content-Type: application/json');

$payload = json_decode(file_get_contents('php://input'), true) ?? [];
$solicitud_id = (int)($payload['solicitud_id'] ?? 0);
$monto = (float)($payload['monto'] ?? 0);
$detalle = trim($payload['detalle'] ?? '');
$prof_id = $_SESSION['user']['id'] ?? 0;

if(!$prof_id || !$solicitud_id || $monto<=0){
  http_response_code(400);
  echo json_encode(['success'=>false,'error'=>'Datos inválidos']);
  exit;
}

try{
  $stmt = $pdo->prepare('INSERT INTO presupuestos(solicitud_id, profesional_id, monto, detalle) VALUES (?,?,?,?)');
  $stmt->execute([$solicitud_id,$prof_id,$monto,$detalle]);
  echo json_encode(['success'=>true]);
}catch(Throwable $e){
  http_response_code(400);
  echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
}
