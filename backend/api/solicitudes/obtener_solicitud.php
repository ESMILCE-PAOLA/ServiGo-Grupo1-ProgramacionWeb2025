<?php  
require_once __DIR__ . '/../../../includes/db.php';

header('Content-Type: application/json');

$id = intval($_GET['id'] ?? 0);
if(!$id){
  echo json_encode(['success'=>false, 'error'=>'ID no válido']);
  exit;
}

try {
    $sql = "SELECT 
                s.id,
                s.titulo,
                s.descripcion,
                s.created_at,
                s.estado,                     
                s.direccion,
                l.nombre AS localidad,         
                u.nombre AS cliente
            FROM solicitudes s
            JOIN usuarios u ON u.id = s.cliente_id
            LEFT JOIN localidades l ON l.id = s.id_localidad
            WHERE s.id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode(['success'=>true,'data'=>$res]);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error en la consulta',
        'detalle' => $e->getMessage()
    ]);
}
