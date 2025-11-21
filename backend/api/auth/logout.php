<?php
require __DIR__ . '/../../../includes/session.php';
session_destroy();
header('Location: /ServiGo/');
