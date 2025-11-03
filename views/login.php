<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
<?php require __DIR__ . '/../includes/header.php'; ?>
<?php require __DIR__ . '/../includes/navbar.php'; ?>
  
<section class="section-container container d-flex justify-content-center align-items-center mt-5">
            <div class="container section-container w-100 ">
                <div id="CardLogin" class="card">
                    <div class="card-body">
                        <div class="container">
                              <h3>⚡ ServiGo</h3>
                        <div>
                        <h5 class="card-title text-center mb-4">Iniciar Sesión</h5>

                        <div class="alert alert-danger d-none" role="alert" id="alert"></div>

                        <form id="fLogin" action="" method="POST" id="formulario">

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" name="email" id="email"
                                    placeholder="Ingresa tu email" required>
                                <p class="text-danger email-mal d-none"></p>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password"
                                    placeholder="Ingresa tu contraseña" name="password" required>
                                <p class="text-danger clave-mal d-none"></p>
                            </div>
                            <div class="boton">
                                <input type="submit" value="Iniciar Sesión" class="btn iniciar-sesion">
                            </div>
                        </form>
                          <div id="loginMsg" class="alert" style="display:none"></div>
                        <div class="text-center mt-3">
                            <a class="enlace" href="#" data-bs-toggle="modal"
                                data-bs-target="#recuperarClaveModal">¿Olvidaste tu
                                contraseña?</a>
                            <!--Se activa el modal-->
                        </div>
                        <div class="text-center mt-2">
                            <p>¿No tenés una cuenta? <a class="enlace"
                                    href="./registro.php">Registrate</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</body>
</html>

<script>
document.getElementById('fLogin').addEventListener('submit', async (e)=>{
  e.preventDefault();
  const form = new FormData(e.target);
  const body = Object.fromEntries(form.entries());
  try{
    const r = await api('/ServiGo/backend/api/auth/login.php', {method:'POST', body: JSON.stringify(body)});
    location.href = r.redirect || '/ServiGo/';
  }catch(err){
    const m = document.getElementById('loginMsg');
    m.textContent = err.message; m.className='alert error'; m.style.display='block';
  }
});
</script>

