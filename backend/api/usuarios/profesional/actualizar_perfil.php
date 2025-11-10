<?php
require_once __DIR__ . '/../../../../includes/db.php';
require_once __DIR__ . '/../../../../includes/session.php';
require_once __DIR__ . '/../../../../includes/auth.php';

header('Content-Type: application/json');

try {
  $user = $_SESSION['user'] ?? null;
  if (!$user || ($user['rol'] ?? '') !== 'profesional') {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit;
  }

  $nombre = trim($_POST['nombre'] ?? '');
  $localidad = trim($_POST['localidad'] ?? '');
  $experiencia = trim($_POST['experiencia'] ?? '');
  $rubros = trim($_POST['rubros'] ?? '');
  $descripcion = trim($_POST['descripcion'] ?? '');
  $foto = null;

  // Validaciones mínimas
  if (!$nombre || !$localidad) {
    echo json_encode(['success' => false, 'error' => 'Faltan campos obligatorios.']);
    exit;
  }

  // Subir imagen si se seleccionó una nueva
  if (!empty($_FILES['foto']['name'])) {
    $ruta = __DIR__ . '/../../../../assets/img/profesionales/';
    $nombreArchivo = 'perfil_' . $user['id'] . '_' . time() . '.jpg';
    move_uploaded_file($_FILES['foto']['tmp_name'], $ruta . $nombreArchivo);
    $foto = '/assets/img/profesionales/' . $nombreArchivo;
  }

  // Actualizar datos en la base
  $sql = "UPDATE usuarios 
          SET nombre = :nombre,
              localidad = :localidad,
              experiencia = :experiencia,
              rubros = :rubros,
              descripcion = :descripcion";

  if ($foto) $sql .= ", foto = :foto";
  $sql .= " WHERE id = :id";

  $params = [
    ':nombre' => $nombre,
    ':localidad' => $localidad,
    ':experiencia' => $experiencia,
    ':rubros' => $rubros,
    ':descripcion' => $descripcion,
    ':id' => $user['id']
  ];
  if ($foto) $params[':foto'] = $foto;

  $stm = $pdo->prepare($sql);
  $stm->execute($params);

  echo json_encode(['success' => true]);

} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
