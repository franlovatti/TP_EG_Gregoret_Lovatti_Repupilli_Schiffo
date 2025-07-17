<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Iniciar sesión</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="">
          <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="email" name="email" required />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required />
          </div>
          <div class="form-group form-check mb-3">
            <label class="form-check-label" for="mantenerSesionIniciada">Mantener sesión iniciada</label>
            <input type="hidden" name="mantenerSesionIniciada" value="no">
            <input type="checkbox" class="form-check-input" id="mantenerSesionIniciada" name="mantenerSesionIniciada" value="si">
          </div>
          <?php if (!empty($login_error)){ ?>
            <div class="alert alert-danger"><?= $login_error ?></div>
          <?php }; ?>
          <div class="mb-3">
            <small><a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#recuperarModal">¿Olvidaste tu contraseña?</a></small>
          </div>
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Ingresar</button>
          </div>
        </form>
        <div class="text-center mt-3">
          <small>¿No tenés cuenta? <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registroModal">Registrate</a></small>
        </div>
      </div>
    </div>
  </div>
</div>