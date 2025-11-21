<?php
require_once __DIR__ . '/../../../includes/db.php';
header('Content-Type: application/json');

try {
  $sql = "SELECT nombre FROM localidades ORDER BY nombre";
  $stm = $pdo->query($sql);
  $data = $stm->fetchAll(PDO::FETCH_COLUMN);
  echo json_encode(['success' => true, 'data' => $data]);
} catch (Throwable $e) {
  echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
