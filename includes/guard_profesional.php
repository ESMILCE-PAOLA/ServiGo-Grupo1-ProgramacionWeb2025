<?php
require_once __DIR__ . '/session.php';

$rol = $_SESSION['user']['rol_slug'] ?? $_SESSION['user']['rol'] ?? 'visitante';
if ($rol !== 'profesional') {
  header('Location: /ServiGo/views/visitante/index.php');
  exit;
}
