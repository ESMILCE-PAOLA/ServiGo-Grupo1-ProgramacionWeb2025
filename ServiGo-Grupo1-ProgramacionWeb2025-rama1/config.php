<?php
// Configuración de entorno (simple). Puedes usar .env si prefieres.
return [
    'db' => [
        'host' => '127.0.0.1',
        'port' => '3306',
        'name' => 'servigo',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4'
    ],
    'app' => [
        'base_url' => '/ServiGo' // Ajusta según tu carpeta/public path
    ]
];
