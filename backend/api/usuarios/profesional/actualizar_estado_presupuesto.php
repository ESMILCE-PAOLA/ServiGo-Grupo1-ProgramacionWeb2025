<?php
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../../includes/session.php';
header('Content-Type: application/json');

$profId = $_SESSION['user']['id'] ?? 0;
if(!$profId){ echo json_encode(['success'=>false,'error'=>'Sin sesión']); exit; }

$id = intval($_POST['id'] ?? 0);
$estado = $_POST['estado'] ?? '';
$permitidos = ['enviado','aceptado','rechazado','cancelado'];
if($id<=0 || !in_array($estado,$permitidos)){ echo json_encode(['success'=>false,'error'=>'Datos inválidos']); exit; }

$stm = $pdo->prepare("UPDATE presupuestos SET estado=? WHERE id=? AND profesional_id=?");
$ok = $stm->execute([$estado,$id,$profId]);

echo json_encode(['success'=>$ok]);
