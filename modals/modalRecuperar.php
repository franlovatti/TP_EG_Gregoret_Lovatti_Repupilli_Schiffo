<div class="modal fade" id="recuperarModal" tabindex="-1" aria-labelledby="recuperarModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="registroModalLabel">Recuperar contraseña</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="">
          <div class="mb-3">
            <label for="correo" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="correo" name="correoRecuperar" required />
          </div>
          <?php if (isset($_GET['recuperar'])){?>
            <div class="alert alert-success">Correo de recuperación enviado correctamente, revisa tu bandeja de entrada.</div>
          <?php }elseif (!empty($recuperar)){ ?>
            <div class="alert alert-danger"><?php echo $recuperar ?></div>
          <?php } ?>
          <div class="d-grid gap-2">
            <button type="submit" id="recuperar" class="btn btn-success">Recuperar contraseña</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>