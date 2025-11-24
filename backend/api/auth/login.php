<?php
require __DIR__ . '/../../db.php';
require __DIR__ . '/../../../includes/session.php';

$config = include __DIR__ . '/../config.php';
$BASE = $config['app']['base_url'];


$payload = json_decode(file_get_contents('php://input'), true) ?? [];
$email = trim($payload['email'] ?? '');
$pass  = $payload['password'] ?? '';

$stmt = $pdo->prepare('SELECT u.id, u.nombre, u.email, u.password_hash, r.slug AS rol_slug
                       FROM usuarios u
                       JOIN roles r ON r.id = u.rol_id
                       WHERE u.email = ? AND u.activo = 1 LIMIT 1');
$stmt->execute([$email]);
$u = $stmt->fetch();
if(!$u || !password_verify($pass, $u['password_hash'] ?? '')){
    http_response_code(401);
    echo json_encode(['success'=>false,'error'=>'Credenciales inválidas']);
    exit;
}
$_SESSION['user'] = ['id'=>$u['id'],'nombre'=>$u['nombre'],'email'=>$u['email'],'rol_slug'=>$u['rol_slug']];
$redir = '/ServiGo/';
if ($u['rol_slug']==='administrador') $redir ="<?= $BASE ?>/views/administrador/dashboard.php";
if ($u['rol_slug']==='cliente') $redir = "<?= $BASE ?>/views/cliente/dashboard.php";
if ($u['rol_slug']==='profesional') $redir = "<?= $BASE ?>/views/profesional/dashboard.php";

header('Content-Type: application/json');
echo json_encode(['success'=>true,'redirect'=>$redir]);
