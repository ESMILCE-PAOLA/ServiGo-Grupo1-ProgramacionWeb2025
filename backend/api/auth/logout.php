<?php
require __DIR__ . '/../../../includes/session.php';
$config = include __DIR__ . '/../config.php';
$BASE = $config['app']['base_url'];
session_destroy();
header("Location: <?= $BASE ?>/");
