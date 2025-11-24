<?php
require_once __DIR__ . '/../../db.php';
// Usamos el guard_cliente para asegurar la sesión (y el modo prueba)
require_once __DIR__ . '/../../../includes/guard_cliente.php';

header('Content-Type: application/json');

try {
    $cliente_id = $_SESSION['user']['id'];

    $sql = "SELECT s.id, s.titulo, s.estado, s.created_at, l.nombre as localidad
            FROM solicitudes s
            LEFT JOIN localidades l ON s.id_localidad = l.id
            WHERE s.cliente_id = :cid
            ORDER BY s.created_at DESC";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':cid' => $cliente_id]);
    
    echo json_encode(['success' => true, 'data' => $stmt->fetchAll()]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>