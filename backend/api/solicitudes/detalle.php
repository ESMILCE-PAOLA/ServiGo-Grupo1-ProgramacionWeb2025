<?php
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../../includes/guard_cliente.php';

header('Content-Type: application/json');

$id = intval($_GET['id'] ?? 0);

try {
    // 1. Obtener la solicitud
    $sql = "SELECT s.*, l.nombre as localidad_nombre 
            FROM solicitudes s
            LEFT JOIN localidades l ON s.id_localidad = l.id
            WHERE s.id = :id AND s.cliente_id = :cid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id, ':cid' => $_SESSION['user']['id']]);
    $solicitud = $stmt->fetch();

    if (!$solicitud) throw new Exception("Solicitud no encontrada.");

    // 2. Obtener presupuestos
    $sqlP = "SELECT p.id, p.total, p.condiciones, p.estado, p.created_at, u.nombre as profesional_nombre
             FROM presupuestos p
             INNER JOIN usuarios u ON p.profesional_id = u.id
             WHERE p.solicitud_id = :sid";
    $stmtP = $pdo->prepare($sqlP);
    $stmtP->execute([':sid' => $id]);

    echo json_encode([
        'success' => true, 
        'data' => [
            'solicitud' => $solicitud,
            'presupuestos' => $stmtP->fetchAll()
        ]
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>