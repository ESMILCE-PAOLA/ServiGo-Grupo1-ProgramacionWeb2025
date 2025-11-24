<?php
require_once __DIR__ . '/../../../includes/db.php';
header('Content-Type: application/json');

try {
    $sql = "SELECT id, nombre FROM localidades ORDER BY nombre ASC";
    $stm = $pdo->query($sql);
    $data = $stm->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $data
    ]);

} catch (Throwable $e) {

    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
