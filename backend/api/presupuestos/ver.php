<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/session.php';

header("Content-Type: application/json");

try {
    $id = $_GET["id"] ?? 0;

    if (!$id) {
        echo json_encode(["success" => false, "error" => "ID inválido"]);
        exit;
    }

    // Presupuesto principal
    $sql = "SELECT p.*, u.nombre AS cliente
            FROM presupuestos p
            JOIN solicitudes s ON s.id = p.solicitud_id
            JOIN usuarios u ON u.id = s.cliente_id
            WHERE p.id = ?";
    $stm = $pdo->prepare($sql);
    $stm->execute([$id]);

    $presupuesto = $stm->fetch(PDO::FETCH_ASSOC);

    if (!$presupuesto) {
        echo json_encode(["success" => false, "error" => "Presupuesto no encontrado"]);
        exit;
    }

    // Detalle
    $sqlDet = "SELECT * FROM presupuesto_detalle WHERE presupuesto_id = ?";
    $stm2 = $pdo->prepare($sqlDet);
    $stm2->execute([$id]);

    $presupuesto["detalle"] = $stm2->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "data" => $presupuesto
    ]);

} catch (Throwable $e) {
    echo json_encode([
        "success" => false,
        "error" => "Error interno",
        "detalle" => $e->getMessage()
    ]);
}
