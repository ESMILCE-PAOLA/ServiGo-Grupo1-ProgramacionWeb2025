<?php
header('Content-Type: application/json');

try {
    // Estados del profesional (tomados del ENUM de la BD)
    $estados = [
        'pendiente',
        'aceptada',
        'rechazada'
    ];

    // Etapas del proceso (tomadas del ENUM de la BD)
    $etapas = [
        'pendiente',
        'presupuesto',
        'en_servicio',
        'finalizado'
    ];

    echo json_encode([
        'success' => true,
        'data' => [
            'estados' => $estados,
            'etapas'  => $etapas
        ]
    ]);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
