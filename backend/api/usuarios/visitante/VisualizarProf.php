<?php
  __DIR__ . include_once("../../backend/db.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $sql = "SELECT id, nombre  FROM usuarios WHERE rol_id = 3 && activo = 1";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $profesionales = $stmt->fetchAll(PDO::FETCH_ASSOC);

     header('Content-Type: application/json');
    echo json_encode($profesionales);
    exit;
}
?>
