<?php
//session_start();
//require_once '../db.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 2) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? null;
    $params = [$nombre, $email, $_SESSION['usuario_id']];

    if ($password) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre=?, email=?, password_hash=? WHERE id=?");
        $params = [$nombre, $email, $password_hash, $_SESSION['usuario_id']];
    } else {
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre=?, email=? WHERE id=?");
    }
    $stmt->execute($params);
    $_SESSION['nombre'] = $nombre;
    header('Location: perfil.php');
    exit;
}

// Cargar datos actuales
$stmt = $pdo->prepare("SELECT nombre, email FROM usuarios WHERE id=?");
$stmt->execute([$_SESSION['usuario_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Perfil</title>
</head>
<body>
    <h1>Editar Datos</h1>
    <form method="POST">
        <label>Nombre: <input name="nombre" value="<?=$user['nombre']?>" required></label><br>
        <label>Email: <input name="email" value="<?=$user['email']?>" required></label><br>
        <label>Nueva contraseña (dejar vacío si no se cambia): <input type="password" name="password"></label><br>
        <input type="submit" value="Guardar cambios">
    </form>
    <a href="perfil.php">Volver</a>
</body>
</html>
