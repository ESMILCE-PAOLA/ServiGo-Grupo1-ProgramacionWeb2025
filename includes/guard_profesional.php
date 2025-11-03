<?php
require_once __DIR__ . '/session.php';

$rol = $_SESSION['user']['rol_slug'] ?? $_SESSION['user']['rol'] ?? 'visitante';
if ($rol !== 'profesional') {
  header('Location: /ServiGo/ServiGo-Grupo1-ProgramacionWeb2025/views/visitante/dashboard.php');
  exit;
}
