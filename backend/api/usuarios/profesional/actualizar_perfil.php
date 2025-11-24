<?php
require_once __DIR__ . '/../../includes/db.php';
header('Content-Type: application/json');

// ================================
//  VALIDAR ID
// ================================
$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode(["success" => false, "error" => "ID no especificado"]);
    exit;
}

try {

    // ================================
    //  DATOS DEL FORMULARIO
    // ================================
    $nombre       = $_POST['nombre'] ?? '';
    $experiencia  = $_POST['experiencia'] ?? '';
    $descripcion  = $_POST['descripcion'] ?? '';
    $localidad_id = $_POST['localidad'] ?? '';
    $rubros       = $_POST['rubros'] ?? [];
    $fotoNueva    = $_FILES['foto'] ?? null;

    // Validación básica
    if (trim($nombre) === '' || trim($experiencia) === '' || trim($descripcion) === '') {
        echo json_encode(["success" => false, "error" => "Todos los campos son obligatorios."]);
        exit;
    }

    // ================================
    //  TRAER FOTO ACTUAL
    // ================================
    $sqlFoto = "SELECT foto FROM profesionales WHERE id = ?";
    $stmt = $pdo->prepare($sqlFoto);
    $stmt->execute([$id]);
    $prof = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$prof) {
        echo json_encode(["success" => false, "error" => "Profesional no encontrado."]);
        exit;
    }

    $fotoActual = $prof['foto'];

    // ================================
    //  PROCESAR FOTO NUEVA
    // ================================
    if ($fotoNueva && $fotoNueva['error'] === UPLOAD_ERR_OK) {

        $ext = pathinfo($fotoNueva['name'], PATHINFO_EXTENSION);
        $nombreArchivo = "prof_" . $id . "_" . time() . "." . $ext;

        // Ruta física real del proyecto
        $basePath = dirname(__DIR__, 4);

        // Carpeta donde se guardan las fotos
        $carpeta = $basePath . "/assets/uploads/profesionales";

        // Crear carpeta si no existe
        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        // Ruta final del archivo en el sistema
        $rutaDestino = $carpeta . "/" . $nombreArchivo;

        // Mover archivo subido
        if (!move_uploaded_file($fotoNueva['tmp_name'], $rutaDestino)) {
            echo json_encode(["success" => false, "error" => "Error al guardar la foto en el servidor."]);
            exit;
        }

        // Ruta pública que se guarda en BD
        $rutaBD = "/assets/uploads/profesionales/" . $nombreArchivo;

    } else {
        // Se conserva la foto actual
        $rutaBD = $fotoActual;
    }

    // ================================
    //  ACTUALIZAR TABLA `profesionales`
    // ================================
    $sql = "UPDATE profesionales 
            SET experiencia = ?, descripcion = ?, id_localidad = ?, foto = ?
            WHERE id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$experiencia, $descripcion, $localidad_id, $rutaBD, $id]);

    // ================================
    //  ACTUALIZAR NOMBRE EN `usuarios`
    // ================================
    $sqlU = "UPDATE usuarios 
             SET nombre = ? 
             WHERE id = (SELECT usuario_id FROM profesionales WHERE id = ?)";

    $stmt = $pdo->prepare($sqlU);
    $stmt->execute([$nombre, $id]);

    // ================================
    //  ACTUALIZAR RUBROS
    // ================================
    $pdo->prepare("DELETE FROM rubros_profesional WHERE profesional_id = ?")
        ->execute([$id]);

    $sqlInsert = "INSERT INTO rubros_profesional (profesional_id, rubro_id) VALUES (?, ?)";
    $stmtInsert = $pdo->prepare($sqlInsert);

    foreach ($rubros as $r) {
        $stmtInsert->execute([$id, $r]);
    }

    // ================================
    //  RESPUESTA EXITOSA
    // ================================
    echo json_encode([
        "success" => true,
        "message" => "Perfil actualizado correctamente.",
        "foto" => $rutaBD
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}
