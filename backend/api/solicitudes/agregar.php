<?php
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../../includes/guard_cliente.php';

header('Content-Type: application/json');

try {
    $titulo = trim($_POST['titulo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $id_localidad = intval($_POST['id_localidad'] ?? 0);
    $direccion = trim($_POST['direccion'] ?? '');

    if (empty($titulo) || empty($descripcion) || $id_localidad <= 0 || empty($direccion)) {
        throw new Exception("Complete todos los campos obligatorios.");
    }

    $sql = "INSERT INTO solicitudes (cliente_id, id_localidad, direccion, titulo, descripcion, estado, created_at) 
            VALUES (:cid, :loc, :dir, :tit, :desc, 'pendiente', NOW())";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':cid' => $_SESSION['user']['id'],
        ':loc' => $id_localidad,
        ':dir' => $direccion,
        ':tit' => $titulo,
        ':desc' => $descripcion
    ]);

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>