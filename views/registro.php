<?php require __DIR__ . '/../includes/header.php'; ?>
<?php require __DIR__ . '/../includes/navbar.php'; ?>
<main class="container">
  <div class="card" style="max-width:640px;margin:0 auto;">
    <h2>Crear cuenta</h2>
    <form id="fReg">
      <div class="grid cols-2">
        <div>
          <label>Nombre</label>
          <input name="nombre" required>
        </div>
        <div>
          <label>Email</label>
          <input type="email" name="email" required>
        </div>
      </div>
      <div class="grid cols-2">
        <div>
          <label>Rol</label>
          <select name="rol_slug" required>
            <option value="cliente">Cliente</option>
            <option value="profesional">Profesional</option>
          </select>
        </div>
        <div>
          <label>Contraseña</label>
          <input type="password" name="password" required>
        </div>
      </div>
      <button class="btn primary" type="submit">Registrarme</button>
    </form>
    <div id="regMsg" class="alert" style="display:none"></div>
  </div>
</main>
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
</script>
<?php require __DIR__ . '/../includes/footer.php'; ?>
