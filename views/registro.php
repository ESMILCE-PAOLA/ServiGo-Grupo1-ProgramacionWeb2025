<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrar Cuenta - ServiGo</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> 
  <script src="registro.js"></script>


  <link rel="stylesheet" href="../../assets/css/registro.css">
</head>
<body>

  <?php require __DIR__ . '/../includes/header.php'; ?>
<?php require __DIR__ . '/../includes/navbar.php'; ?>
      <div class="container d-flex justify-content-center align-items-center mt-5">
        <section class="w-100 container section-container">
            <div class="card">
                <div class="card-body">
                     <div class="container">
                              <h3>⚡ ServiGo</h3>
                        <div>
                    <h5 class="card-title text-center mb-4">Registro de Cuenta</h5>

                    <div class="alert alert-danger d-none" id="alert"></div>

                    <form action="" method="POST" id="formulario">

                        <div class="mb-3">
                            <label for="nombre">Nombre completo</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]{6,40}"
                                placeholder="Juan Perez" required>
                            <p class="errorNombre text-danger"></p>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="jperez@correo.com" minlength="8" maxlength="80" required />
                            <p class="text-danger email-mal d-none"></p>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" placeholder="Contraseña"
                                name="password" minlength="6" maxlength="32" required>
                            <p class="text-danger clave-mal d-none"></p>
                        </div>
                        <div class="boton">
                            <input type="submit" value="Registrarse" name="enviar" class="btn enviar-btn">
                        </div>
                    </form>
                      <div id="regMsg" class="alert" style="display:none"></div>

                    <div class="text-center mt-3">
                        <p>¿Ya tenés una cuenta? <a href="login.php">Iniciar sesión</a></p>
                    </div>

                </div>
            </div>
        </section>
    </div>

    <?php require __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>

<!--

<script>
document.getElementById('fReg').addEventListener('submit', async (e)=>{
  e.preventDefault();
  const body = Object.fromEntries(new FormData(e.target).entries());
  try{
    const r = await api('/ServiGo/backend/api/usuarios/registrar.php', {method:'POST', body: JSON.stringify(body)});
    location.href = '/ServiGo/views/login.php';
  }catch(err){
    const m = document.getElementById('regMsg');
    m.textContent = err.message; m.className='alert error'; m.style.display='block';
  }
});

-->