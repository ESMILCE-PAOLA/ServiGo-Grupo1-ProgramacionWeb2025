<?php
// views/administrador/perfil_administrador.php

require_once 'verificar_admin.php';
require_once '../../backend/db.php'; 

$idUsuario = $_SESSION['id']; 

try {
    $sql = "SELECT nombre, email, created_at FROM usuarios WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idUsuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil | ServiGo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../../assets/css/admin.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

    <?php require_once '../../includes/navbar.php'; ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-profile">
                    <div class="profile-header"></div>
                    
                    <div class="card-body text-center pt-0">
                        <div class="d-flex justify-content-center mb-3">
                            <div class="avatar-circle">
                                </div>
                        </div>
                        
                        <h3 class="fw-bold"><?php echo htmlspecialchars($user['nombre']); ?></h3>
                        <p class="text-muted">Administrador</p>
                        <hr>
                        
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                        
                        <div class="d-grid gap-2 mt-4">
                            <a href="editar_perfil_administrador.php" class="btn btn-primary">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                            <a href="index.php" class="btn btn-outline-secondary">Volver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-auto"><?php require_once '../../includes/footer.php'; ?></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>