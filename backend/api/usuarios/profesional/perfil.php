<?php
header('Content-Type: application/json');

// ===========================
// CARGAR CONFIG Y DB
// ===========================
require_once __DIR__ . '/../../../../backend/config.php';
require_once __DIR__ . '/../../../../includes/db.php';

// ===========================
// VALIDAR ID DEL PROFESIONAL
// ===========================
$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode(["success" => false, "error" => "ID no especificado"]);
    exit;
}

try {
    // ===========================
    // INFO PRINCIPAL
    // ===========================
    $sql = "
        SELECT 
            p.id AS profesional_id,
            u.id AS usuario_id,
            u.nombre,
            u.email,
            p.experiencia,
            p.descripcion,
            p.estado,
            p.foto,
            p.promedio,
            l.nombre AS localidad
        FROM profesionales p
        INNER JOIN usuarios u ON p.usuario_id = u.id
        LEFT JOIN localidades l ON p.id_localidad = l.id
        WHERE p.id = ?
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $profesional = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$profesional) {
        echo json_encode(["success" => false, "error" => "Profesional no encontrado"]);
        exit;
    }

    // ===========================
    // RUBROS
    // ===========================
    $sqlRubros = "
        SELECT r.nombre
        FROM rubros_profesional rp
        INNER JOIN rubros r ON rp.rubro_id = r.id
        WHERE rp.profesional_id = ?
    ";

    $stmt = $pdo->prepare($sqlRubros);
    $stmt->execute([$id]);
    $rubros = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // ===========================
    // RESEÑAS (ULTIMAS 5)
    // ===========================
    $sqlResenas = "
        SELECT 
            r.calificacion,
            r.comentario,
            r.created_at,
            u.nombre AS cliente
        FROM resenas r
        INNER JOIN usuarios u ON r.cliente_id = u.id
        WHERE r.profesional_id = ?
        ORDER BY r.created_at DESC
        LIMIT 5
    ";

    $stmt = $pdo->prepare($sqlResenas);
    $stmt->execute([$id]);
    $resenas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ===========================
    // TRABAJOS REALIZADOS
    // ===========================
    $sqlTrabajos = "
        SELECT titulo, descripcion, imagen
        FROM trabajos_profesional
        WHERE profesional_id = ?
        ORDER BY creado_en DESC
    ";

    $stmt = $pdo->prepare($sqlTrabajos);
    $stmt->execute([$id]);
    $trabajos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Ajustar rutas de imágenes
    foreach ($trabajos as &$t) {
        if ($t['imagen'] && !str_starts_with($t['imagen'], 'http')) {
            $t['imagen'] = BASE_URL . '/' . ltrim($t['imagen'], '/');
        }
    }

    // ===========================
    // RESPUESTA FINAL
    // ===========================
    echo json_encode([
        "success" => true,
        "data" => [
            "info" => $profesional,
            "rubros" => $rubros,
            "resenas" => $resenas,
            "trabajos" => $trabajos
        ]
    ]);

} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
