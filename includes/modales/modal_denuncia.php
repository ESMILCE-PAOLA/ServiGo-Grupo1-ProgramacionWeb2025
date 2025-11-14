<div class="modal fade" id="modalDenuncia" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <form id="formDenuncia">

        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">
            <i class="bi bi-flag-fill"></i> Enviar denuncia
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <label class="form-label fw-bold">Motivo</label>
          <select id="motivoDenuncia" class="form-select mb-3" required>
            <option value="">Seleccione un motivo</option>
            <option value="inapropiado">Contenido inapropiado</option>
            <option value="falso">Información falsa</option>
            <option value="estafa">Sospecha de estafa</option>
            <option value="otro">Otro</option>
          </select>

          <label class="form-label fw-bold">Detalle</label>
          <textarea id="detalleDenuncia" class="form-control" rows="3" required></textarea>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Enviar denuncia</button>
        </div>

      </form>

    </div>
  </div>
</div>
