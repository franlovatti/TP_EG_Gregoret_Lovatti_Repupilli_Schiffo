<?php
$loginEmailValue = '';
$loginPasswordValue = '';
$mantenerSesionChecked = false;
if (!empty($login_error) && isset($_POST['email']) && isset($_POST['password'])) {
  $loginEmailValue = htmlspecialchars((string) $_POST['email']);
  $loginPasswordValue = htmlspecialchars((string) $_POST['password']);
  $mantenerSesionChecked = isset($_POST['mantenerSesionIniciada']) && $_POST['mantenerSesionIniciada'] === 'si';
}
?>
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Iniciar sesión</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar">
          <span class="visually-hidden">Cerrar</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $loginEmailValue; ?>" required />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <div class="input-group">
              <input type="password" class="form-control" id="password" name="password" value="<?php echo $loginPasswordValue; ?>" required />
              <button type="button" class="btn btn-outline-secondary toggle-password-btn" aria-label="Mostrar contraseña">
                <span class="visually-hidden">Mostrar contraseña</span>
                <i class="bi bi-eye"></i>
              </button>
            </div>
          </div>
          <div class="form-group form-check mb-3">
            <label class="form-check-label" for="mantenerSesionIniciada">Mantener sesión iniciada</label>
            <input type="hidden" name="mantenerSesionIniciada" value="no">
            <input type="checkbox" class="form-check-input" id="mantenerSesionIniciada" name="mantenerSesionIniciada" value="si" <?php echo $mantenerSesionChecked ? 'checked' : ''; ?>>
          </div>
          <?php if (!empty($login_error)){ ?>
            <div class="alert alert-danger login-error-alert"><?= $login_error ?></div>
          <?php }; ?>
          <div class="mb-3">
            <small><a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#recuperarModal">¿Olvidaste tu contraseña?</a></small>
          </div>
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary" aria-label="Ingresar">Ingresar</button>
          </div>
        </form>
        <div class="text-center mt-3">
          <small>¿No tenés cuenta? <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registroModal">Registrate</a></small>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var loginModalElement = document.getElementById('loginModal');
  if (!loginModalElement) {
    return;
  }

  loginModalElement.querySelectorAll('.toggle-password-btn').forEach(function (button) {
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

  loginModalElement.addEventListener('hidden.bs.modal', function () {
    loginModalElement.querySelectorAll('.login-error-alert').forEach(function (alert) {
      alert.remove();
    });

    loginModalElement.querySelectorAll('.toggle-password-btn').forEach(function (button) {
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