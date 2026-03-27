<div class="modal fade" id="cambiarClaveModal" tabindex="-1" aria-labelledby="cambiarClaveModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cambiarClaveModalLabel">Cambiar contraseña</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="home.php?cambiar=1"> 
          <div class="mb-3">
            <label for="claveNueva" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="claveNueva" name="claveNueva" required />
          </div>
          <div class="mb-3">
            <label for="claveNueva2" class="form-label">Confirmar contraseña</label>
            <input type="password" class="form-control" id="claveNueva2" name="claveNueva2" required />
          </div>
          <?php if (!empty($cambiar_error)) { ?>
            <div class="alert alert-danger"><?php echo $cambiar_error ?></div>
          <?php }?>
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success">Registrar nueva contraseña</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>