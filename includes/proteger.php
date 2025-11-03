<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$rolRequerido = $rolRequerido ?? null;

if (!$rolRequerido || $_SESSION['user']['rol'] !== $rolRequerido) {
  header('Location: /ServiGo/views/visitante/login.php');
  exit;
}
