<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 2) {
    header('Location: ../login.php');
    exit;
}

$sid = $_GET['solicitud_id'] ?? null;

// Validar propiedad
$stmt = $pdo->prepare("SELECT id FROM solicitudes WHERE id=? AND cliente_id=?");
$stmt->execute([$sid, $_SESSION['usuario_id']]);
if (!$stmt->fetch()) {
    echo "Solicitud no válida.";
    exit;
}

// Obtener presupuestos
$stmt = $pdo->prepare("SELECT p.*, u.nombre AS profesional FROM presupuestos p JOIN usuarios u ON u.id=p.profesional_id WHERE p.solicitud_id=?");
$stmt->execute([$sid]);
$presupuestos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Presupuestos</title>
</head>
<body>
    <h1>Presupuestos para Solicitud #<?=$sid?></h1>
    <table>
        <tr>
            <th>Profesional</th>
            <th>Monto</th>
            <th>Detalle</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
        <?php foreach($presupuestos as $p): ?>
        <tr>
            <td><?=$p['profesional']?></td>
            <td>$<?=number_format($p['monto'], 2)?></td>
            <td><?=$p['detalle']?></td>
            <td><?=$p['estado']?></td>
            <td><?=$p['created_at']?></td>
            <td>
            <?php if ($p['estado'] == 'enviado'): ?>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="pid" value="<?=$p['id']?>">
                    <input type="submit" name="accion" value="Aceptar">
                    <input type="submit" name="accion" value="Rechazar">
                </form>
            <?php else: ?>
                <?=$p['estado']?>
            <?php endif;?>
            </td>
        </tr>
        <?php endforeach;?>
    </table>
    <a href="solicitud_cliente.php?id=<?=$sid?>">Volver a Solicitud</a>
</body>
</html>
<?php
// Acción aceptar/rechazar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pid = $_POST['pid'] ?? null;
    $accion = $_POST['accion'] ?? '';
    if ($pid && in_array($accion, ['Aceptar', 'Rechazar'])) {
        $nuevo_estado = $accion == 'Aceptar' ? 'aceptado' : 'rechazado';
        $stmt = $pdo->prepare("UPDATE presupuestos SET estado=? WHERE id=? AND solicitud_id=?");
        $stmt->execute([$nuevo_estado, $pid, $sid]);
        header("Location: presupuestos.php?solicitud_id=$sid");
        exit;
    }
}
?>
