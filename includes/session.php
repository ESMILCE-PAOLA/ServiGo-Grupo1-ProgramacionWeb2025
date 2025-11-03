<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Si no hay usuario logueado, asignar visitante por defecto
if (!isset($_SESSION['user'])) {
  $_SESSION['user'] = [
    'id' => null,
    'nombre' => 'Visitante',
    'rol' => 'visitante'
  ];
}

// Acceso rápido al rol
$rol = $_SESSION['user']['rol'];
