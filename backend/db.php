<?php
$config = require __DIR__ . '/../config.php';

$dsn = sprintf(
  'mysql:host=%s;port=%s;dbname=%s;charset=%s',
  $config['db']['host'],
  $config['db']['port'],
  $config['db']['name'],
  $config['db']['charset']
);

$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => false,
];

try {
  $pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $options);
} catch (Throwable $e) {
  http_response_code(500);
  header('Content-Type: application/json');
  echo json_encode([
    'success' => false,
    'error' => 'DB connection failed',
    'detail' => $e->getMessage()
  ]);
  exit;
}
