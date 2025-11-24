<?php


require_once 'verificar_admin.php';
require_once '../../backend/db.php'; 

$mensaje = "";

// Procesar acciones (Resolver / Rechazar)
if (isset($_GET['accion']) && isset($_GET['id'])) {
    $idDenuncia = $_GET['id'];
    $nuevoEstado = ($_GET['accion'] == 'resolver') ? 'resuelta' : 'rechazada';

    try {
        $stmt = $pdo->prepare("UPDATE denuncias SET estado = ? WHERE id = ?");
        $stmt->execute([$nuevoEstado, $idDenuncia]);
        header("Location: GestionDenuncias.php?msg=ok");
        exit;
    } catch (PDOException $e) {
        $mensaje = "Error: " . $e->getMessage();
    }
}

if (isset($_GET['msg'])) $mensaje = "Estado actualizado correctamente.";

// Listar denuncias
try {
    $sql = "SELECT d.id, u.nombre AS reportante, u2.nombre AS denunciado, 
                   d.tipo, d.motivo, d.estado, d.created_at
            FROM denuncias d
            JOIN usuarios u ON d.reportante_id = u.id
            LEFT JOIN usuarios u2 ON d.denunciado_id = u2.id
            ORDER BY d.created_at DESC";
    $stmt = $pdo->query($sql);
} catch (PDOException $e) {
    die("Error DB: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Denuncias | ServiGo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../../assets/css/admin.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

    <?php require_once '../../includes/navbar.php'; ?>

    <div class="container my-5">
        <?php if($mensaje): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?php echo htmlspecialchars($mensaje); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card main-card">
            <div class="card-header bg-white py-3">
                <h4 class="mb-0 text-primary"><i class="bi bi-flag"></i> Denuncias</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Reportante</th>
                                <th>Denunciado</th>
                                <th>Motivo</th>
                                <th>Estado</th>
                                <th class="text-end pe-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td class="ps-4 fw-bold"><?php echo htmlspecialchars($row['reportante']); ?></td>
                                <td><?php echo htmlspecialchars($row['denunciado'] ?? 'Sistema'); ?></td>
                                <td><small><?php echo htmlspecialchars($row['motivo']); ?></small></td>
                                <td>
                                    <?php 
                                        $clase = match($row['estado']) {
                                            'pendiente' => 'badge-pendiente',
                                            'resuelta' => 'badge-resuelta',
                                            'rechazada' => 'badge-rechazada',
                                            default => 'bg-secondary'
                                        };
                                    ?>
                                    <span class="badge <?php echo $clase; ?>"><?php echo ucfirst($row['estado']); ?></span>
                                </td>
                                <td class="text-end pe-4">
                                    <?php if($row['estado'] == 'pendiente'): ?>
                                        <a href="?accion=resolver&id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm" title="Aceptar"><i class="bi bi-check-lg"></i></a>
                                        <a href="?accion=rechazar&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" title="Rechazar"><i class="bi bi-x-lg"></i></a>
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