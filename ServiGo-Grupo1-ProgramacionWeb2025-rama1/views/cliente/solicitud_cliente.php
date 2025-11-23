<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 2) {
    header('Location: ../login.php');
    exit;
}

$id = $_GET['id'] ?? null;
$stmt = $pdo->prepare("SELECT s.*, l.nombre AS localidad FROM solicitudes s LEFT JOIN localidades l ON s.id_localidad = l.id WHERE s.id=? AND s.cliente_id=?");
$stmt->execute([$id, $_SESSION['usuario_id']]);
$solicitud = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$solicitud) {
    echo "Solicitud no encontrada.";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detalle de Solicitud</title>
</head>
<body>
    <h1><?=$solicitud['titulo']?></h1>
    <strong>Estado:</strong> <?=$solicitud['estado']?><br>
    <strong>Localidad:</strong> <?=$solicitud['localidad']?><br>
    <strong>Dirección:</strong> <?=$solicitud['direccion']?><br>
    <strong>Descripción:</strong> <?=$solicitud['descripcion']?><br>
    <strong>Creada:</strong> <?=$solicitud['created_at']?><br>
    <a href="presupuestos.php?solicitud_id=<?=$solicitud['id']?>">Ver Presupuestos</a><br>
    <a href="index.php">Volver</a>
</body>
</html>
