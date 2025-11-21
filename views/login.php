<?php require __DIR__ . '/../includes/header.php'; ?>
<?php require __DIR__ . '/../includes/navbar.php'; ?>
<main class="container">
  <div class="card" style="max-width:480px;margin:0 auto;">
    <h2>Iniciar sesión</h2>
    <form id="fLogin">
      <label>Email</label>
      <input type="email" name="email" required>
      <label>Contraseña</label>
      <input type="password" name="password" required>
      <button class="btn primary" type="submit">Ingresar</button>
    </form>
    <div id="loginMsg" class="alert" style="display:none"></div>
  </div>
</main>
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
<?php require __DIR__ . '/../includes/footer.php'; ?>
