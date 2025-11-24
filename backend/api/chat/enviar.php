<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/session.php';
header('Content-Type: application/json');

try {
  // Leer el cuerpo JSON enviado por fetch()
  $input = json_decode(file_get_contents('php://input'), true);

  $user = $_SESSION['user'] ?? null;
  if (!$user) {
    echo json_encode(['success' => false, 'error' => 'No hay sesión activa']);
    exit;
  }

  $rol = $user['rol'] ?? '';
  $user_id = intval($user['id'] ?? 0);
  $solicitud_id = intval($input['solicitud_id'] ?? 0);
  $mensaje = trim($input['mensaje'] ?? '');

  if ($solicitud_id <= 0 || $mensaje === '') {
    echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
    exit;
  }

  // Buscar el chat asociado
  $stmtChat = $pdo->prepare("SELECT id, cliente_id, profesional_id 
                              FROM chats 
                              WHERE solicitud_id = :id LIMIT 1");
  $stmtChat->execute([':id' => $solicitud_id]);
  $chat = $stmtChat->fetch(PDO::FETCH_ASSOC);

  if (!$chat) {
    echo json_encode(['success' => false, 'error' => 'Chat no encontrado']);
    exit;
  }

  // Determinar emisor y receptor
  if ($rol === 'profesional') {
    $emisor_id = $chat['profesional_id'];
    $receptor_id = $chat['cliente_id'];
  } else {
    $emisor_id = $chat['cliente_id'];
    $receptor_id = $chat['profesional_id'];
  }

  // Insertar el mensaje
  $sql = "INSERT INTO mensajes (chat_id, emisor_id, receptor_id, contenido, created_at)
          VALUES (:chat_id, :emisor_id, :receptor_id, :contenido, NOW())";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':chat_id' => $chat['id'],
    ':emisor_id' => $emisor_id,
    ':receptor_id' => $receptor_id,
    ':contenido' => $mensaje
  ]);

  echo json_encode(['success' => true, 'message' => 'Mensaje enviado correctamente']);
} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
