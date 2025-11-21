<?php
session_start();
require_once '../db.php'; // Debes crear este archivo para la conexión PDO/Mysqli

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 2) {
    header('Location: ../login.php');
    exit;
}

// Obtener solicitudes del cliente
$stmt = $pdo->prepare("SELECT s.*, l.nombre AS localidad FROM solicitudes s LEFT JOIN localidades l ON s.id_localidad = l.id WHERE s.cliente_id=? ORDER BY s.created_at DESC");
$stmt->execute([$_SESSION['usuario_id']]);
$solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Panel de Cliente | ServiGo</title>
</head>
<body>
    <h1>Bienvenido, <?=$_SESSION['nombre'] ?? 'Cliente'?></h1>
    <a href="nueva_solicitud.php">Crear Nueva Solicitud</a> | 
    <a href="perfil.php">Mi Perfil</a> | 
    <a href="../logout.php">Salir</a>
    <h2>Mis Solicitudes</h2>
    <table>
        <thead>
            <tr><th>ID</th><th>Título</th><th>Estado</th><th>Localidad</th><th>Creada</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            <?php foreach ($solicitudes as $sol) : ?>
            <tr>
                <td><?=$sol['id']?></td>
                <td><?=$sol['titulo']?></td>
                <td><?=$sol['estado']?></td>
                <td><?=$sol['localidad']?></td>
                <td><?=$sol['created_at']?></td>
                <td>
                    <a href="solicitud_cliente.php?id=<?=$sol['id']?>">Ver</a> | 
                    <a href="presupuestos.php?solicitud_id=<?=$sol['id']?>">Presupuestos</a>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</body>
</html>
