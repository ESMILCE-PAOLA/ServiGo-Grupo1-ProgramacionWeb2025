<?php


// Seguridad y Conexión
require_once 'verificar_admin.php';
require_once '../../backend/db.php'; 

$mensaje = "";
$tipo_mensaje = "";


if (isset($_GET['accion']) && isset($_GET['id'])) {
    $idUsuario = $_GET['id'];
    $nuevoEstado = ($_GET['accion'] == 'bloquear') ? 0 : 1;
    
    try {
        $stmt = $pdo->prepare("UPDATE usuarios SET activo = ? WHERE id = ?");
        $stmt->execute([$nuevoEstado, $idUsuario]);
        $mensaje = ($nuevoEstado == 0) ? "Usuario bloqueado." : "Usuario activado.";
        $tipo_mensaje = "success";
    } catch (PDOException $e) {
        $mensaje = "Error: " . $e->getMessage();
        $tipo_mensaje = "danger";
    }
}

// Consulta de usuarios
try {

    $sql = "SELECT u.id, u.nombre, u.email, u.activo, r.nombre as nombre_rol 
            FROM usuarios u 
            LEFT JOIN roles r ON u.rol_id = r.id 
            ORDER BY u.id DESC";
    $stmt = $pdo->query($sql);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios | ServiGo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../../assets/css/admin.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

    <?php require_once '../../includes/navbar.php'; ?>

    <div class="container my-5">
        <?php if($mensaje): ?>
            <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show">
                <?php echo htmlspecialchars($mensaje); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card main-card">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-primary"><i class="bi bi-people"></i> Gestión de Usuarios</h4>
                <a href="usuarios-bloqueados.php" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-slash-circle"></i> Ver Bloqueados
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th class="ps-4">Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th class="text-end pe-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td class="ps-4 fw-bold"><?php echo htmlspecialchars($row['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><span class="badge bg-light text-dark border"><?php echo htmlspecialchars($row['nombre_rol'] ?? 'N/A'); ?></span></td>
                                <td>
                                    <?php echo $row['activo'] 
                                        ? '<span class="badge bg-success status-badge">Activo</span>' 
                                        : '<span class="badge bg-danger status-badge">Bloqueado</span>'; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <?php if($row['activo']): ?>
                                        <a href="?accion=bloquear&id=<?php echo $row['id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Bloquear usuario?');">
                                            <i class="bi bi-lock-fill"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="?accion=activar&id=<?php echo $row['id']; ?>" class="btn btn-outline-success btn-sm">
                                            <i class="bi bi-unlock-fill"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-auto"><?php require_once '../../includes/footer.php'; ?></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>