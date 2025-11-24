<?php
session_start();
session_unset();
session_destroy();

// Redirigir SIEMPRE al home del visitante
header("Location: /ServiGo/ServiGo-Grupo1-ProgramacionWeb2025/views/visitante/home.php");
exit;
