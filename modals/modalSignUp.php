  <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="registroModalLabel">Crear una cuenta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <form method="post" action="">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre completo</label>
              <input type="text" class="form-control" id="nombre" name="nombre" required />
            </div>
            <div class="mb-3">
              <label for="correo" class="form-label">Correo electrónico</label>
              <input type="email" class="form-control" id="correo" name="correo" required />
            </div>
            <div class="mb-3">
              <label for="clave" class="form-label">Contraseña</label>
              <input type="password" class="form-control" id="clave" name="clave" required />
            </div>
            <div class="mb-3">
              <label for="clave2" class="form-label">Confirmar contraseña</label>
              <input type="password" class="form-control" id="clave2" name="clave2" required />
            </div>
            <div id="error-pass" class="text-danger mt-1" style="display: none;"></div>
            <?php if (!empty($signUp_error)){ ?>
            <div class="alert alert-danger"><?= $signUp_error ?></div>
            <?php }; ?>
            <div class="d-grid gap-2">
              <button type="submit" id="signup" class="btn btn-success">Registrarse</button>
            </div>
          </form>
          <div class="text-center mt-3">
            <small>¿Sos dueño de un local? <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registroDueñoModal">Regristrarse como dueño</a></small><br>     
            <small>¿Ya tenés cuenta? <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Ingresá</a></small>
          </div>
        </div>
      </div>
    </div>
  </div>