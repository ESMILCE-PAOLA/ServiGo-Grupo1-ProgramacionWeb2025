<?php
require_once __DIR__ . '/../../../includes/db.php';

header('Content-Type: application/json');

// ==========================
// VALIDAR ID
// ==========================
$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    echo json_encode([
        "success" => false,
        "error" => "ID inválido"
    ]);
    exit;
}

try {

    // ==========================
    // 1. OBTENER EL PRESUPUESTO
    // ==========================
    $sql = "SELECT 
                p.id,
                p.solicitud_id,
                p.profesional_id,
                p.fecha_emision,
                p.valido_hasta,
                p.total,
                p.condiciones,
                s.created_at AS fecha_solicitud,
                u.nombre AS cliente
            FROM presupuestos p
            JOIN solicitudes s ON s.id = p.solicitud_id
            JOIN usuarios u ON u.id = s.cliente_id
            WHERE p.id = :id
            LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    $presupuesto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$presupuesto) {
        echo json_encode([
            "success" => false,
            "error" => "Presupuesto no encontrado"
        ]);
        exit;
    }

    // ==========================
    // 2. OBTENER DETALLE
    // ==========================
    $sqlDet = "SELECT 
                    cantidad,
                    descripcion,
                    precio_unitario,
                    subtotal
               FROM presupuesto_detalle
               WHERE presupuesto_id = :id";

    $stmtDet = $pdo->prepare($sqlDet);
    $stmtDet->bindParam(":id", $id, PDO::PARAM_INT);
    $stmtDet->execute();

    $detalle = $stmtDet->fetchAll(PDO::FETCH_ASSOC);

    // ==========================
    // ARMAR RESPUESTA JSON
    // ==========================
    echo json_encode([
        "success" => true,
        "data" => [
            "id"              => $presupuesto["id"],
            "solicitud_id"    => $presupuesto["solicitud_id"],
            "cliente"         => $presupuesto["cliente"],
            "fecha_solicitud" => substr($presupuesto["fecha_solicitud"], 0, 10),
            "fecha_emision"   => $presupuesto["fecha_emision"],
            "valido_hasta"    => $presupuesto["valido_hasta"],
            "condiciones"     => $presupuesto["condiciones"],
            "total"           => $presupuesto["total"],
            "detalle"         => $detalle
        ]
    ]);

} catch (Throwable $e) {

    echo json_encode([
        "success" => false,
        "error" => "Error en servidor",
        "detalle" => $e->getMessage()
    ]);
}
