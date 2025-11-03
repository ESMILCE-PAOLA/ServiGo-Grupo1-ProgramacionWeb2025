<?php
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../../includes/session.php';
header('Content-Type: application/json');

$profId = $_SESSION['user']['id'] ?? 0;
if(!$profId){ echo json_encode(['success'=>false,'error'=>'Sin sesión']); exit; }

$sql = "SELECT p.id, p.monto, p.plazo_dias, p.estado, p.created_at,
               s.titulo AS solicitud, u.nombre AS cliente, s.localidad
        FROM presupuestos p
        JOIN solicitudes s ON s.id = p.solicitud_id
        JOIN usuarios u ON u.id = s.cliente_id
        WHERE p.profesional_id = ?
        ORDER BY p.created_at DESC";
$stm = $pdo->prepare($sql);
$stm->execute([$profId]);

echo json_encode(['success'=>true,'data'=>$stm->fetchAll()]);
