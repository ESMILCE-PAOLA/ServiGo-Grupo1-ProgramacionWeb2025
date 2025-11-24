<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/session.php';

header('Content-Type: application/json');

$idSolicitud = intval($_GET['solicitud_id'] ?? 0);
$idProfesional = $_SESSION['user']['id'] ?? 0;

if ($idSolicitud <= 0 || $idProfesional <= 0) {
    echo json_encode(['success' => false, 'error' => 'Parámetros inválidos']);
    exit;
}

try {
    // Traer el presupuesto principal
    $sql = "SELECT * FROM presupuestos 
            WHERE solicitud_id = ? AND profesional_id = ?
            ORDER BY id DESC LIMIT 1";

    $stm = $pdo->prepare($sql);
    $stm->execute([$idSolicitud, $idProfesional]);

    $presupuesto = $stm->fetch(PDO::FETCH_ASSOC);

    if (!$presupuesto) {
        echo json_encode(['success' => false, 'error' => 'No hay presupuesto enviado']);
        exit;
    }

    // Traer detalle
    $sqlDet = "SELECT * FROM presupuesto_detalle WHERE presupuesto_id = ?";
    $stm2 = $pdo->prepare($sqlDet);
    $stm2->execute([$presupuesto['id']]);

    $detalle = $stm2->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => [
            'presupuesto' => $presupuesto,
            'detalle' => $detalle
        ]
    ]);

} catch (Throwable $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
