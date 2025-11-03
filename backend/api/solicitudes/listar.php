<?php
require __DIR__ . '/../../db.php';
require __DIR__ . '/../../../includes/session.php';
header('Content-Type: application/json');
$q = $pdo->query('SELECT s.id, s.titulo, s.estado, s.created_at, c.nombre AS cliente
                  FROM solicitudes s JOIN usuarios c ON c.id = s.cliente_id
                  ORDER BY s.created_at DESC LIMIT 50');
echo json_encode(['success'=>true, 'data'=>$q->fetchAll()]);
