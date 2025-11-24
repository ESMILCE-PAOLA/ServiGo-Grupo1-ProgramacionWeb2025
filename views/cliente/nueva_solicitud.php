<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 2) {
    header('Location: ../login.php');
    exit;
}

// Obtener localidades
$stmt = $pdo->query("SELECT id, nombre FROM localidades");
$localidades = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $localidad = $_POST['localidad'] ?? null;
    $direccion = $_POST['direccion'] ?? '';

    $stmt = $pdo->prepare("INSERT INTO solicitudes (cliente_id, id_localidad, direccion, titulo, descripcion) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['usuario_id'], $localidad, $direccion, $titulo, $descripcion]);
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Nueva solicitud</title>
</head>
<body>
    <h1>Crear nueva solicitud</h1>
    <form method="POST">
        <label>Localidad:
            <select name="localidad" required>
                <option value="">Seleccione...</option>
                <?php foreach($localidades as $l) : ?>
                <option value="<?=$l['id']?>"><?=$l['nombre']?></option>
                <?php endforeach;?>
            </select>
        </label><br>
        <label>Dirección: <input name="direccion" required></label><br>
        <label>Título: <input name="titulo" maxlength="140" required></label><br>
        <label>Descripción:<br><textarea name="descripcion" required></textarea></label><br>
        <input type="submit" value="Crear">
    </form>
    <a href="index.php">Volver</a>
</body>
</html>
