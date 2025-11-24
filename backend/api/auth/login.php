<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/session.php';

header('Content-Type: application/json; charset=utf-8');

// Sólo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'error'   => 'Método no permitido'
    ]);
    exit;
}

// Aceptar JSON o POST normal
$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    $input = $_POST;
}

$email    = trim($input['email']    ?? '');
$password = (string)($input['password'] ?? '');

// Validaciones básicas
if ($email === '' || $password === '') {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'error'   => 'Debe completar email y contraseña'
    ]);
    exit;
}

// Buscar usuario
$sql = "SELECT 
            u.id,
            u.nombre,
            u.email,
            u.password_hash,
            u.rol_id,
            u.activo,
            r.slug   AS rol_slug,
            r.nombre AS rol_nombre
        FROM usuarios u
        LEFT JOIN roles r ON r.id = u.rol_id
        WHERE u.email = :email
        LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->execute([':email' => $email]);
$user = $stmt->fetch();

if (!$user) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'error'   => 'Credenciales inválidas'
    ]);
    exit;
}

// Usuario desactivado
if ((int)$user['activo'] !== 1) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'error'   => 'Usuario inactivo'
    ]);
    exit;
}

// Verificar contraseña
if (!password_verify($password, $user['password_hash'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'error'   => 'Credenciales inválidas'
    ]);
    exit;
}

// ===============================
// Armar datos de sesión
// ===============================
$rolSlug = $user['rol_slug'] ?: 'visitante';

$_SESSION['user'] = [
    'id'       => (int)$user['id'],
    'nombre'   => $user['nombre'],
    'email'    => $user['email'],
    'rol'      => $rolSlug,
    'rol_id'   => (int)$user['rol_id'],
    'rol_name' => $user['rol_nombre'],
];

// Si es profesional → buscar id en tabla profesionales
if ($rolSlug === 'profesional') {
    $stmP = $pdo->prepare("SELECT id FROM profesionales WHERE usuario_id = :uid LIMIT 1");
    $stmP->execute([':uid' => $user['id']]);
    $prof = $stmP->fetch();

    if ($prof) {
        $_SESSION['user']['profesional_id'] = (int)$prof['id'];
    }
}

// Si quisieras, acá podrías hacer algo similar para cliente / admin

// Redirección según rol
switch ($rolSlug) {
    case 'administrador':
        $redirect = BASE_URL . '/views/administrador/index.php';
        break;
    case 'profesional':
        $redirect = BASE_URL . '/views/profesional/index.php';
        break;
    case 'cliente':
        $redirect = BASE_URL . '/views/cliente/index.php';
        break;
    default:
        $redirect = BASE_URL . '/views/visitante/home.php';
        break;
}

echo json_encode([
    'success'  => true,
    'message'  => 'Login correcto',
    'redirect' => $redirect
]);
