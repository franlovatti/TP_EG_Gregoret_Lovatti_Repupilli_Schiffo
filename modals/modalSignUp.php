<?php
$isSignUpClientePost = isset($_POST['correo'], $_POST['clave'], $_POST['clave2'])
  && (!isset($_POST['esDueno']) || $_POST['esDueno'] !== 'si');
$signUpNombreValue = ($isSignUpClientePost && isset($_POST['nombre'])) ? htmlspecialchars((string) $_POST['nombre']) : '';
$signUpCorreoValue = $isSignUpClientePost ? htmlspecialchars((string) $_POST['correo']) : '';
$signUpClaveValue = $isSignUpClientePost ? htmlspecialchars((string) $_POST['clave']) : '';
$signUpClave2Value = $isSignUpClientePost ? htmlspecialchars((string) $_POST['clave2']) : '';
$mostrarErrorSignUpCliente = !empty($signUp_error) && (($signUp_modal ?? 'registroModal') === 'registroModal');
?>
  <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="registroModalLabel">Crear una cuenta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar">
            <span class="visually-hidden">Cerrar</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" action="">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre y apellido</label>
              <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $signUpNombreValue; ?>" required />
            </div>
            <div class="mb-3">
              <label for="correo" class="form-label">Correo electrónico</label>
              <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $signUpCorreoValue; ?>" required />
            </div>
            <div class="mb-3">
              <label for="clave" class="form-label">Contraseña</label>
              <div class="input-group">
                <input type="password" class="form-control" id="clave" name="clave" value="<?php echo $signUpClaveValue; ?>" required />
                <button type="button" class="btn btn-outline-secondary toggle-password-btn" aria-label="Mostrar contraseña">
                  <span class="visually-hidden">Mostrar contraseña</span>
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </div>
            <div class="mb-3">
              <label for="clave2" class="form-label">Confirmar contraseña</label>
              <div class="input-group">
                <input type="password" class="form-control" id="clave2" name="clave2" value="<?php echo $signUpClave2Value; ?>" required />
                <button type="button" class="btn btn-outline-secondary toggle-password-btn" aria-label="Mostrar contraseña">
                  <span class="visually-hidden">Mostrar contraseña</span>
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </div>
            <div id="error-pass" class="text-danger mt-1" style="display: none;"></div>
            <?php if ($mostrarErrorSignUpCliente){ ?>
            <div class="alert alert-danger signup-error-alert"><?= $signUp_error ?></div>
            <?php }; ?>
            <input type="hidden" name="esDueno" value="no">
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

<script>
document.addEventListener('DOMContentLoaded', function () {
  var registroModalElement = document.getElementById('registroModal');
  if (!registroModalElement) {
    return;
  }

  registroModalElement.querySelectorAll('.toggle-password-btn').forEach(function (button) {
    button.addEventListener('click', function () {
      var input = button.closest('.input-group').querySelector('input');
      var icon = button.querySelector('i');
      var isPassword = input.type === 'password';

      input.type = isPassword ? 'text' : 'password';
      icon.classList.toggle('bi-eye', !isPassword);
      icon.classList.toggle('bi-eye-slash', isPassword);
      button.setAttribute('aria-label', isPassword ? 'Ocultar contraseña' : 'Mostrar contraseña');
    });
  });

  registroModalElement.addEventListener('hidden.bs.modal', function () {
    registroModalElement.querySelectorAll('.signup-error-alert').forEach(function (alert) {
      alert.remove();
    });

    registroModalElement.querySelectorAll('.toggle-password-btn').forEach(function (button) {
      var input = button.closest('.input-group').querySelector('input');
      var icon = button.querySelector('i');
      input.type = 'password';
      icon.classList.remove('bi-eye-slash');
      icon.classList.add('bi-eye');
      button.setAttribute('aria-label', 'Mostrar contraseña');
    });
  });
});
</script>