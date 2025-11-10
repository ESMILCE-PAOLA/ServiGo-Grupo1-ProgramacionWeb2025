<div class="modal fade" id="modalBloqueo" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formBloqueo">
        <div class="modal-header">
          <h5 class="modal-title">Bloquear usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <label for="tipoBloqueo" class="form-label">Duración del bloqueo</label>
          <select id="tipoBloqueo" class="form-select mb-3">
            <option value="7">7 días</option>
            <option value="30">30 días</option>
            <option value="90">90 días</option>
            <option value="indefinido">Indefinido</option>
          </select>
          <label for="motivoBloqueo" class="form-label">Motivo</label>
          <textarea id="motivoBloqueo" class="form-control" rows="3"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Confirmar bloqueo</button>
        </div>
      </form>
    </div>
  </div>
</div>
