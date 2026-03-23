<div class="modal fade" id="modalEditarNovedad" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Editar novedad</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <form action="../consultas/gestionarEdicionNovedad.php" method="post">

       
          <input type="hidden" name="id_novedad" id="modal-id">

    
          <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea 
              class="form-control" 
              id="modal-desc" 
              name="descripcion_novedad" 
              rows="3" 
              required>
            </textarea>
          </div>

        
          <div class="mb-3">
            <label class="form-label">Fecha desde</label>
            <input 
              type="date" 
              class="form-control" 
              id="modal-desde" 
              name="fecha_desde" 
              required>
          </div>

         
          <div class="mb-3">
            <label class="form-label">Fecha hasta</label>
            <input 
              type="date" 
              class="form-control" 
              id="modal-hasta" 
              name="fecha_hasta" 
              required>
          </div>

          <div class="mb-3">
            <label class="form-label">Tipo de usuario</label>
            <select 
              class="form-select" 
              name="tipo_usuario" 
              id="modal-tipo" 
              required>

              <option value="Inicial">Inicial</option>
              <option value="Medium">Medium</option>
              <option value="Premium">Premium</option>

            </select>
          </div>

         
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              Cancelar
            </button>
            <button type="submit" class="btn btn-primary">
              Guardar cambios
            </button>
          </div>

        </form>

      </div>
    </div>
  </div>
</div>