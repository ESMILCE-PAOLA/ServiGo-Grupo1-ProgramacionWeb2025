<?php
session_start();
$rol = $_GET['rol'] ?? 'visitante';
$_SESSION['user'] = ['id' => 1, 'nombre' => ucfirst($rol), 'rol' => $rol];
echo "Sesión iniciada como: $rol";
