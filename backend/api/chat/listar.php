<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/session.php';
header('Content-Type: application/json');

try {
  $solicitud_id = intval($_GET['solicitud_id'] ?? 0);
  if ($solicitud_id <= 0) {
    echo json_encode(['success' => false, 'error' => 'ID de solicitud inválido']);
    exit;
  }

  // Buscar el chat asociado
  $sqlChat = "SELECT id, cliente_id, profesional_id 
              FROM chats 
              WHERE solicitud_id = :solicitud_id 
              LIMIT 1";
  $stmtChat = $pdo->prepare($sqlChat);
  $stmtChat->execute([':solicitud_id' => $solicitud_id]);
  $chat = $stmtChat->fetch(PDO::FETCH_ASSOC);

  if (!$chat) {
    echo json_encode(['success' => true, 'data' => []]);
    exit;
  }

  $chat_id = $chat['id'];
  $cliente_id = $chat['cliente_id'];
  $profesional_id = $chat['profesional_id'];

  // Obtener mensajes
// Obtener mensajes
  $sqlMensajes = "SELECT 
                    id,
                    contenido AS mensaje,
                    created_at,
                    CASE 
                      WHEN emisor_id = :cliente_id THEN 'cliente'
                      WHEN emisor_id = :profesional_id THEN 'profesional'
                      ELSE 'otro'
                    END AS tipo
                  FROM mensajes
                  WHERE chat_id = :chat_id
                  ORDER BY created_at ASC";

  $stmtMsg = $pdo->prepare($sqlMensajes);
  $stmtMsg->execute([
    ':chat_id' => $chat_id,
    ':cliente_id' => $cliente_id,
    ':profesional_id' => $profesional_id
  ]);

  $mensajes = $stmtMsg->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode(['success' => true, 'data' => $mensajes]);

} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
