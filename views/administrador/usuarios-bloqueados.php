<?php

require_once 'verificar_admin.php';
require_once '../../backend/db.php'; 

$mensaje = "";

if (isset($_GET['desbloquear'])) {
    $id = $_GET['desbloquear'];
    try {
        $stmt = $pdo->prepare("UPDATE usuarios SET activo = 1 WHERE id = ?");
        $stmt->execute([$id]);
        $mensaje = "Usuario desbloqueado.";
    } catch (PDOException $e) {
        $mensaje = "Error: " . $e->getMessage();
    }
}

try {
    $sql = "SELECT id, nombre, email, created_at FROM usuarios WHERE activo = 0";
    $stmt = $pdo->query($sql);
} catch (PDOException $e) {
    die("Error DB: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bloqueados | ServiGo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../../assets/css/admin.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-blocked">

    <?php require_once '../../includes/navbar.php'; ?>

    <div class="container my-5">
        <?php if($mensaje): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?php echo htmlspecialchars($mensaje); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header bg-white py-3 text-danger">
                <h4 class="mb-0"><i class="bi bi-lock-fill"></i> Lista Negra</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-danger">
                            <tr>
                                <th class="ps-4">Nombre</th>
                                <th>Email</th>
                                <th class="text-end pe-4">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td class="ps-4 fw-bold"><?php echo htmlspecialchars($row['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td class="text-end pe-4">
                                    <a href="?desbloquear=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">
                                       <i class="bi bi-unlock-fill"></i> Desbloquear
                                    </a>
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