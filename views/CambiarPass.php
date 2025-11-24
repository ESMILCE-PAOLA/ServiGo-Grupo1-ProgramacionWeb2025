<?php
    
    $config = include __DIR__ . '/../config.php';
    $BASE = $config['app']['base_url'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="<?= $BASE ?>/assets/css/CambiarPass.css">
    <script defer src="<?= $BASE ?>/assets/js/visitante/CambiarPass.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

  <main id="main">
        <section class="section-container container d-flex justify-content-center align-items-center mt-5">
            <div class="container section-container w-100">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-4">Nueva contraseña</h5>
                        <form action="" method="POST" id="formCambiarPass">
                             <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico:</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="usuario@ejemplo.com" required>
                                <div id="DivEmail" class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="nuevaPass" class="form-label">Contraseña:</label>
                                <input type="password" class="form-control" id="nuevaPass" name="nuevaPass" required>
                                <div id="DivnuevaPass" class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="ComparacionPass" class="form-label">Reingrese su contraseña:</label>
                                <input type="password" class="form-control" id="ComparacionPass" name="ComparacionPass" required>
                                <div id="DivCompararClaves" class="invalid-feedback"></div>
                            </div>

                            <button type="submit" id="btnCambiarPass" class="btn btn-primary w-100">Cambiar Contraseña</button>
                        </form>
                        <div class="text-center mt-2">
                            <p>¿No tienes una cuenta? <a class="enlace" href="./registro.php">Regístrate</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
</body>
</html>