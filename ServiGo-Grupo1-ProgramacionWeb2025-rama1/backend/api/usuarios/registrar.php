<?php
require __DIR__ . '/../../db.php';

$payload = json_decode(file_get_contents('php://input'), true) ?? [];
$nombre = trim($payload['nombre'] ?? '');
$email  = trim($payload['email'] ?? '');
$rol    = trim($payload['rol_slug'] ?? '');
$pass   = $payload['password'] ?? '';

if(!$nombre || !$email || !$rol || !$pass){
  http_response_code(400);
  echo json_encode(['success'=>false,'error'=>'Campos incompletos']);
  exit;
}

$pdo->beginTransaction();
try{
  $stmt = $pdo->prepare('SELECT id FROM roles WHERE slug=?');
  $stmt->execute([$rol]);
  $rol_id = $stmt->fetchColumn();
  if(!$rol_id){
    throw new RuntimeError('Rol inválido');
  }
  $stmt = $pdo->prepare('INSERT INTO usuarios(nombre,email,rol_id,password_hash,activo) VALUES(?,?,?,?,1)');
  $stmt->execute([$nombre,$email,$rol_id,password_hash($pass, PASSWORD_BCRYPT)]);
  $pdo->commit();
  echo json_encode(['success'=>true]);
}catch(Throwable $e){
  $pdo->rollBack();
  http_response_code(400);
  echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
}
