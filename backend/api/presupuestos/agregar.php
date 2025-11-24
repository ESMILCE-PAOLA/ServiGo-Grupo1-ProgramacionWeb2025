<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/session.php';

header('Content-Type: application/json');

// ========================
// 1. VALIDAR
// ========================
$solicitud_id   = $_POST['solicitud_id'] ?? null;
$profesional_id = $_POST['profesional_id'] ?? null;
$fecha_emision  = $_POST['fecha_emision'] ?? null;
$valido_hasta   = $_POST['valido_hasta'] ?? null;
$condiciones    = $_POST['condiciones'] ?? '';
$total          = $_POST['total'] ?? null;

$cantidades    = $_POST['cantidad'] ?? [];
$descripciones = $_POST['descripcion'] ?? [];
$precios       = $_POST['precio_unitario'] ?? [];
$subtotales    = $_POST['subtotal'] ?? [];

if (!$solicitud_id || !$profesional_id || !$fecha_emision || !$valido_hasta || !$total) {
    echo json_encode(["success" => false, "error" => "Faltan datos obligatorios"]);
    exit;
}

if (count($descripciones) === 0) {
    echo json_encode(["success" => false, "error" => "Debe agregar al menos un ítem"]);
    exit;
}

try {
    $pdo->beginTransaction();

    // ========================
    // 2. INSERTAR PRESUPUESTO
    // ========================
    $sql = "INSERT INTO presupuestos 
            (solicitud_id, profesional_id, fecha_emision, valido_hasta, total, condiciones, estado) 
            VALUES (?, ?, ?, ?, ?, ?, 'enviado')";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $solicitud_id,
        $profesional_id,
        $fecha_emision,
        $valido_hasta,
        $total,
        $condiciones
    ]);

    $presupuesto_id = $pdo->lastInsertId();

    // ========================
    // 3. INSERTAR DETALLE
    // ========================
    $sqlDet = "INSERT INTO presupuesto_detalle
               (presupuesto_id, cantidad, descripcion, precio_unitario, subtotal)
               VALUES (?, ?, ?, ?, ?)";

    $det = $pdo->prepare($sqlDet);

    for ($i = 0; $i < count($descripciones); $i++) {
        $det->execute([
            $presupuesto_id,
            $cantidades[$i],
            $descripciones[$i],
            $precios[$i],
            $subtotales[$i]
        ]);
    }

    // ========================
    // 4. ACTUALIZAR ETAPA
    // ========================
    $sqlUpd = "UPDATE solicitudes_profesionales
               SET etapa = 'presupuesto', fecha_envio = NOW()
               WHERE solicitud_id = ? AND profesional_id = ?";

    $upd = $pdo->prepare($sqlUpd);
    $upd->execute([$solicitud_id, $profesional_id]);

    $pdo->commit();

    echo json_encode([
        "success" => true,
        "message" => "Presupuesto enviado correctamente",
        "id_presupuesto" => $presupuesto_id
    ]);
    exit;

} catch (PDOException $e) {
    $pdo->rollBack();

    if ($e->getCode() == "23000") {
        echo json_encode([
            "success" => false,
            "error"   => "Ya enviaste un presupuesto para esta solicitud."
        ]);
        exit;
    }

    echo json_encode([
        "success" => false,
        "error" => "Error en BD",
        "detalle" => $e->getMessage()
    ]);
    exit;

} catch (Throwable $e) {
    $pdo->rollBack();

    echo json_encode([
        "success" => false,
        "error" => "Error inesperado",
        "detalle" => $e->getMessage()
    ]);
    exit;
}
