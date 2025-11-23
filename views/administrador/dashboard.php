<?php


// Seguridad: Verificamos si es admin antes de cargar
//require_once 'verificar_admin.php';

// Conexión DB: Para contar usuarios y denuncias
require_once '../../backend/db.php'; 

// Variables
$totalUsuarios = 0;
$denunciasPendientes = 0;
$bloqueados = 0;
$nombreAdmin = $_SESSION['nombre'] ?? 'Administrador';

try {
    // Consulta 1: Total Usuarios
    $stmt = $pdo->query("SELECT COUNT(*) FROM usuarios");
    $totalUsuarios = $stmt->fetchColumn();

    // Consulta 2: Denuncias Pendientes
    $stmt = $pdo->query("SELECT COUNT(*) FROM denuncias WHERE estado = 'pendiente'");
    $denunciasPendientes = $stmt->fetchColumn();

    // Consulta 3: Usuarios Bloqueados
    $stmt = $pdo->query("SELECT COUNT(*) FROM usuarios WHERE activo = 0");
    $bloqueados = $stmt->fetchColumn();

} catch (PDOException $e) {
    
    error_log("Error en dashboard: " . $e->getMessage());
}
?>

<?php require __DIR__ . '/../../includes/header.php'; ?>
<?php require __DIR__ . '/../../includes/navbar.php'; ?>

<link href="../../assets/css/admin.css" rel="stylesheet">

<main class="container my-5">
    
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-light mb-0">Panel de Administrador</h2>
                        <p class="text-muted mb-0">Bienvenido/a, <strong><?php echo htmlspecialchars($nombreAdmin); ?></strong></p>
                    </div>
                    <span class="badge bg-primary rounded-pill p-2">
                        <i class="bi bi-shield-check"></i> Admin
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-md-4">
            <a href="GestionUsuarios.php" class="text-decoration-none">
                <div class="card card-stat border-users h-100 p-3 text-center">
                    <div class="card-body">
                        <div class="icon-box mb-3 text-primary">
                            <i class="bi bi-people-fill fs-1"></i>
                        </div>
                        <h5 class="card-title text-dark">Gestión de Usuarios</h5>
                        <h2 class="fw-bold text-dark mb-0"><?php echo $totalUsuarios; ?></h2>
                        <small class="text-muted">Usuarios registrados</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="GestionDenuncias.php" class="text-decoration-none">
                <div class="card card-stat border-alert h-100 p-3 text-center">
                    <div class="card-body">
                        <div class="icon-box mb-3 text-warning">
                            <i class="bi bi-exclamation-triangle-fill fs-1"></i>
                        </div>
                        <h5 class="card-title text-dark">Denuncias</h5>
                        <h2 class="fw-bold text-dark mb-0"><?php echo $denunciasPendientes; ?></h2>
                        <small class="text-muted">Pendientes de revisión</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="usuarios-bloqueados.php" class="text-decoration-none">
                <div class="card card-stat border-block h-100 p-3 text-center">
                    <div class="card-body">
                        <div class="icon-box mb-3 text-danger">
                            <i class="bi bi-slash-circle-fill fs-1"></i>
                        </div>
                        <h5 class="card-title text-dark">Bloqueados</h5>
                        <h2 class="fw-bold text-dark mb-0"><?php echo $bloqueados; ?></h2>
                        <small class="text-muted">En lista negra</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6">
            <a href="perfil_administrador.php" class="text-decoration-none">
                <div class="card card-stat border-profile p-3 h-100 d-flex flex-row align-items-center justify-content-center">
                    <i class="bi bi-person-circle fs-2 text-success me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Mi Perfil</h5>
                        <small class="text-muted">Ver o editar mis datos</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6">
            <a href="../../backend/api/auth/logout.php" class="text-decoration-none">
                <div class="card card-stat border-secondary p-3 h-100 d-flex flex-row align-items-center justify-content-center bg-light">
                    <i class="bi bi-box-arrow-right fs-2 text-secondary me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Cerrar Sesión</h5>
                        <small class="text-muted">Salir del sistema de forma segura</small>
                    </div>
                </div>
            </a>
        </div>

    </div>

</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>