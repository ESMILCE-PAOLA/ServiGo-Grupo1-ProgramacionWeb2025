<?php
require_once __DIR__ . '/../../db.php';
header('Content-Type: application/json');
try {
    $stmt = $pdo->query("SELECT id, nombre FROM localidades ORDER BY nombre ASC");
    echo json_encode(['success' => true, 'data' => $stmt->fetchAll()]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}