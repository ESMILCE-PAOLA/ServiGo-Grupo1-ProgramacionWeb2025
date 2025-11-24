<?php
require __DIR__ . '/../../../config.php'; 
require __DIR__ . '/../../../backend/db.php';   

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $email  = trim($_POST['email']  ?? '');
    $pass1  = trim($_POST['nuevaPass']      ?? '');
    $pass2  = trim($_POST['ComparacionPass']?? '');


    if (empty($pass1) || empty($pass2) || empty($email)) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Completa todos los campos."]);
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Email inválido."]);
        exit();
    }

    if ($pass1 !== $pass2) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Las contraseñas no coinciden."]);
        exit();
    }


    $sql  = "SELECT id FROM usuarios WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(404);
        echo json_encode(["status" => "error", "message" => "Usuario no encontrado."]);
        exit();
    }


    $hash = password_hash($pass1, PASSWORD_DEFAULT);
    $sql  = "UPDATE usuarios SET password_hash = :hash WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['hash' => $hash, 'id' => $user['id']]);

    echo json_encode(["status" => "success", "message" => "Contraseña actualizada."]);
    exit();         
}