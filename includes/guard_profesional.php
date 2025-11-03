<?php
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/auth.php';

if (!isRole('profesional')) {
  header('Location: ' . BASE_URL . '/views/visitante/index.php');
  exit;
}
