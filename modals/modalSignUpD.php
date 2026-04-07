<?php
$isSignUpDuenoPost = isset($_POST['correo'], $_POST['clave'], $_POST['clave2'], $_POST['esDueno'])
  && $_POST['esDueno'] === 'si';
$signUpDCorreoValue = $isSignUpDuenoPost ? htmlspecialchars((string) $_POST['correo']) : '';
$signUpDClaveValue = $isSignUpDuenoPost ? htmlspecialchars((string) $_POST['clave']) : '';
$signUpDClave2Value = $isSignUpDuenoPost ? htmlspecialchars((string) $_POST['clave2']) : '';
$mostrarErrorSignUpDueno = !empty($signUp_error) && (($signUp_modal ?? 'registroModal') === 'registroDueñoModal');
?>
<div class="modal fade" id="registroDueñoModal" tabindex="-1" role="dialog" aria-labelledby="registroDueñoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="registroDueñoModalLabel">Crear una cuenta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar">
            <span class="visually-hidden">Cerrar</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post"> 
            <div class="mb-3">
              <label for="nombreDueno" class="form-label">Nombre y apellido</label>
              <input type="text" class="form-control" id="nombreDueno" name="nombre" value="<?php echo $signUpNombreValue; ?>" required />
            </div>
            <div class="mb-3">
              <label for="correoDueno" class="form-label">Correo electrónico</label>
              <input type="email" class="form-control" id="correoDueno" name="correo" value="<?php echo $signUpDCorreoValue; ?>" required />
            </div>
            <div class="mb-3">
              <label for="claveDueno" class="form-label">Contraseña</label>
              <div class="input-group">
                <input type="password" class="form-control" id="claveDueno" name="clave" value="<?php echo $signUpDClaveValue; ?>" required />
                <button type="button" class="btn btn-outline-secondary toggle-password-btn" aria-label="Mostrar contraseña">
                  <span class="visually-hidden">Mostrar contraseña</span>
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </div>
            <div class="mb-3">
              <label for="clave2Dueno" class="form-label">Confirmar contraseña</label>
              <div class="input-group">
                <input type="password" class="form-control" id="clave2Dueno" name="clave2" value="<?php echo $signUpDClave2Value; ?>" required />
                <button type="button" class="btn btn-outline-secondary toggle-password-btn" aria-label="Mostrar contraseña">
                  <span class="visually-hidden">Mostrar contraseña</span>
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </div>
            <div id="error-pass-dueno" class="text-danger mt-1" style="display: none;"></div>
            <?php if ($mostrarErrorSignUpDueno){ ?>
            <div class="alert alert-danger signup-error-alert"><?= $signUp_error ?></div>
            <?php }; ?>
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-success" aria-label="Registrarse">Registrarse</button>
            </div>
          <input type="hidden" name="esDueno" value="si">
          </form>
          <div class="text-center mt-3">
            <small>¿Quieres registrarte como cliente? <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registroModal">Registrate</a></small><br>
            <small>¿Ya tenés cuenta? <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Ingresá</a></small>
          </div>
        </div>
      </div>
    </div>
  </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var registroDuenoModalElement = document.getElementById('registroDueñoModal');
  if (!registroDuenoModalElement) {
    return;
  }

  registroDuenoModalElement.querySelectorAll('.toggle-password-btn').forEach(function (button) {
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

  registroDuenoModalElement.addEventListener('hidden.bs.modal', function () {
    registroDuenoModalElement.querySelectorAll('.signup-error-alert').forEach(function (alert) {
      alert.remove();
    });

    registroDuenoModalElement.querySelectorAll('.toggle-password-btn').forEach(function (button) {
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