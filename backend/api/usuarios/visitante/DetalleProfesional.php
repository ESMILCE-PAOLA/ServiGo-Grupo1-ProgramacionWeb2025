<?php
  __DIR__ . include_once("../../backend/db.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST["id"];


    $sql = "SELECT id, nombre, email, created_At  FROM usuarios WHERE id = :id";

    $stmt = $conn->prepare($sql);
      $stmt->bindParam(":id", $id);
    $stmt->execute();
    $profesional = $stmt->fetch(PDO::FETCH_ASSOC);

     header('Content-Type: application/json');
    echo json_encode($profesional);
    exit;
}
?>
