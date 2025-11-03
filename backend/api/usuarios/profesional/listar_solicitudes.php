<?php
require_once __DIR__ . '/../../../db.php';
require_once __DIR__ . '/../../../../includes/session.php';

header('Content-Type: application/json');

$profId = $_SESSION['user']['id'] ?? 0;
if(!$profId){
    echo json_encode(['success'=>false,'error'=>'Sin sesión activa']);
    exit;
}

// Ejemplo: traer solicitudes abiertas (ajustá a tu esquema real)
try {
    $sql = "SELECT s.id, s.titulo, s.descripcion, s.direccion,
                l.nombre AS localidad, l.codigo_postal,
                u.nombre AS cliente, s.created_at
            FROM solicitudes s
            JOIN usuarios u ON u.id = s.cliente_id
            LEFT JOIN localidades l ON l.id = s.id_localidad
            WHERE s.estado = 'abierta'
            ORDER BY s.created_at DESC";


    $stm = $pdo->query($sql);
    $data = $stm->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $data]);
} catch (Throwable $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
