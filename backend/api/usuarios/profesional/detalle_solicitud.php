<?php
require_once __DIR__ . '/../../../../includes/db.php';
require_once __DIR__ . '/../../../../includes/session.php';
require_once __DIR__ . '/../../../../includes/auth.php';

header('Content-Type: application/json');

try {

    // ============================
    //  VALIDAR SESIÓN
    // ============================
    $user = $_SESSION['user'] ?? null;

    if (!$user || ($user['rol'] ?? '') !== 'profesional') {
        http_response_code(401);
        echo json_encode(['success' => false, 'error' => 'No autorizado']);
        exit;
    }

    $idProfesional = intval($user['id'] ?? 0);
    $idSolicitud = intval($_GET['id'] ?? 0);

    if ($idSolicitud <= 0) {
        echo json_encode(['success' => false, 'error' => 'ID inválido']);
        exit;
    }

    // ===============================
    //  DETALLE PRINCIPAL DE LA SOLICITUD
    // ===============================
    $sql = "SELECT 
                s.id,
                s.titulo,
                s.descripcion,
                s.direccion,
                l.nombre AS localidad,
                s.estado,
                s.created_at,
                u.id AS cliente_id,
                u.nombre AS cliente,
                u.email
            FROM solicitudes s
            JOIN usuarios u ON u.id = s.cliente_id
            LEFT JOIN localidades l ON l.id = s.id_localidad
            WHERE s.id = :id
            LIMIT 1";

    $stm = $pdo->prepare($sql);
    $stm->execute([':id' => $idSolicitud]);
    $solicitud = $stm->fetch(PDO::FETCH_ASSOC);

    if (!$solicitud) {
        echo json_encode(['success' => false, 'error' => 'Solicitud no encontrada']);
        exit;
    }

    // ===============================
    //  ESTADO ENTRE PROFESIONAL Y CLIENTE
    // ===============================
    $sql2 = "SELECT estado, observacion, fecha_envio, fecha_respuesta
             FROM solicitudes_profesionales
             WHERE solicitud_id = :solicitud_id AND profesional_id = :profesional_id
             LIMIT 1";

    $stm2 = $pdo->prepare($sql2);
    $stm2->execute([
        ':solicitud_id' => $idSolicitud,
        ':profesional_id' => $idProfesional
    ]);

    $relacion = $stm2->fetch(PDO::FETCH_ASSOC);

    if ($relacion) {
        $solicitud['estado_relacion']   = $relacion['estado'] ?? '';
        $solicitud['observacion']       = $relacion['observacion'] ?? '';
        $solicitud['fecha_envio']       = $relacion['fecha_envio'] ?? '';
        $solicitud['fecha_respuesta']   = $relacion['fecha_respuesta'] ?? '';
    } else {
        $solicitud['estado_relacion'] = 'sin_registro';
    }

    // ===============================
    //   RUBROS DEL PROFESIONAL
    // ===============================
    $sql3 = "SELECT r.descripcion 
             FROM rubros r
             INNER JOIN rubros_profesional rp ON rp.rubro_id = r.id
             WHERE rp.profesional_id = :idProfesional";

    $stm3 = $pdo->prepare($sql3);
    $stm3->execute([':idProfesional' => $idProfesional]);

    $rubros = $stm3->fetchAll(PDO::FETCH_COLUMN);

    $solicitud['rubros_profesional'] = $rubros ?: ['Sin rubros asignados'];

    // ===============================
    //   ADJUNTOS DE LA SOLICITUD  
    // ===============================
    $sqlAdj = "SELECT ruta 
               FROM solicitud_adjuntos
               WHERE solicitud_id = :idSolicitud";

    $stmAdj = $pdo->prepare($sqlAdj);
    $stmAdj->execute([':idSolicitud' => $idSolicitud]);

    $adjuntos = $stmAdj->fetchAll(PDO::FETCH_COLUMN);

    // Agregar al array final
    $solicitud['adjuntos'] = $adjuntos ?: [];

    // ===============================
    //   RESPUESTA FINAL
    // ===============================
    echo json_encode(['success' => true, 'data' => $solicitud]);


} catch (Throwable $e) {

    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);

}
