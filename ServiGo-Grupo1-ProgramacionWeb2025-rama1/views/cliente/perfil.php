<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 2) {
    header('Location: ../login.php');
    exit;
}

$stmt = $pdo->prepare("SELECT nombre, email FROM usuarios WHERE id=?");
$stmt->execute([$_SESSION['usuario_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mi Perfil</title>
</head>
<body>
    <h1>Mi Perfil</h1>
    <form>
        <label>Nombre: <input value="<?=$user['nombre']?>" disabled></label><br>
        <label>Email: <input value="<?=$user['email']?>" disabled></label><br>
    </form>
    <a href="editar_perfil.php">Editar datos</a><br>
    <a href="index.php">Volver al panel</a>
</body>
</html>
