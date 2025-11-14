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

    // ============================
    //  OBTENER CHAT
    // ============================
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

    // ============================
    //  OBTENER MENSAJES + NOMBRE
    // ============================
    $sqlMensajes = "SELECT 
                      m.id,
                      m.contenido AS mensaje,
                      m.created_at,
                      m.emisor_id,
                      u.nombre AS nombre_usuario,
                      CASE 
                        WHEN m.emisor_id = :cliente_id THEN 'cliente'
                        WHEN m.emisor_id = :profesional_id THEN 'profesional'
                        ELSE 'otro'
                      END AS tipo
                    FROM mensajes m
                    LEFT JOIN usuarios u ON u.id = m.emisor_id
                    WHERE m.chat_id = :chat_id
                    ORDER BY m.created_at ASC";

    $stmtMsg = $pdo->prepare($sqlMensajes);
    $stmtMsg->execute([
        ':chat_id'       => $chat_id,
        ':cliente_id'    => $cliente_id,
        ':profesional_id'=> $profesional_id
    ]);

    $mensajesRaw = $stmtMsg->fetchAll(PDO::FETCH_ASSOC);

    // ============================
    // FORMATEAR RESPUESTA
    // ============================
    $mensajes = array_map(function($m) {
        return [
            'id'        => $m['id'],
            'mensaje'   => $m['mensaje'],
            'created_at'=> $m['created_at'],
            'tipo'      => $m['tipo'],
            'nombre'    => $m['nombre_usuario'] ?? 'Usuario'
        ];
    }, $mensajesRaw);

    echo json_encode(['success' => true, 'data' => $mensajes]);


} catch (Throwable $e) {

    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
