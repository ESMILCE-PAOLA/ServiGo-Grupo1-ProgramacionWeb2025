<?php
require_once __DIR__ . '/../../../includes/db.php';
header('Content-Type: application/json');

try {

    $sql = "SELECT id, nombre FROM rubros ORDER BY nombre ASC";
    $stmt = $pdo->query($sql);
    $rubros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "data" => $rubros
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}
