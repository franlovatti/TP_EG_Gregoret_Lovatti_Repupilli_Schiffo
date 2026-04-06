<?php
$perfilError = $_SESSION['perfil_error'] ?? '';
$perfilOk = $_SESSION['perfil_ok'] ?? '';
$perfilNombreForm = $_SESSION['perfil_form_nombre'] ?? ($_SESSION['nombre'] ?? '');
unset($_SESSION['perfil_error'], $_SESSION['perfil_ok']);
unset($_SESSION['perfil_form_nombre']);
$redirectTo = $_SERVER['REQUEST_URI'] ?? '/front/home.php';
?>

<div class="modal fade" id="editarPerfilModal" tabindex="-1" aria-labelledby="editarPerfilModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-white text-dark">
      <div class="modal-header bg-light text-dark">
        <h5 class="modal-title text-dark" id="editarPerfilModalLabel">Editar perfil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar">
          <span class="visually-hidden">Cerrar</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="../consultas/gestionarCuenta.php">
          <input type="hidden" name="accion" value="editar_perfil" />
          <input type="hidden" name="redirect_to" value="<?php echo htmlspecialchars((string) $redirectTo); ?>" />
          <div class="mb-3">
            <label for="nombrePerfil" class="form-label text-dark">Nombre y apellido</label>
            <input type="text" class="form-control" id="nombrePerfil" name="nombrePerfil" value="<?php echo htmlspecialchars((string) $perfilNombreForm); ?>" required />
          </div>
          <div class="mb-3">
            <label for="claveNueva" class="form-label text-dark">Contraseña</label>
            <div class="input-group">
              <input type="password" class="form-control" id="claveNueva" name="claveNueva" />
              <button type="button" class="btn btn-outline-secondary toggle-password-btn" aria-label="Mostrar contraseña">
                <span class="visually-hidden">Mostrar contraseña</span>
                <i class="bi bi-eye"></i>
              </button>
            </div>
            <small class="text-muted">Dejá este campo vacío si no querés cambiar la contraseña.</small>
          </div>
          <div class="mb-3">
            <label for="claveNueva2" class="form-label text-dark">Confirmar contraseña</label>
            <div class="input-group">
              <input type="password" class="form-control" id="claveNueva2" name="claveNueva2" />
              <button type="button" class="btn btn-outline-secondary toggle-password-btn" aria-label="Mostrar contraseña">
                <span class="visually-hidden">Mostrar contraseña</span>
                <i class="bi bi-eye"></i>
              </button>
            </div>
          </div>
          <?php if (!empty($perfilError)) { ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars((string) $perfilError); ?></div>
          <?php }?>
          <?php if (!empty($perfilOk)) { ?>
            <div class="alert alert-success"><?php echo htmlspecialchars((string) $perfilOk); ?></div>
          <?php }?>
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success">Guardar cambios</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var editarPerfilModalElement = document.getElementById('editarPerfilModal');
  if (!editarPerfilModalElement) {
    return;
  }

  var abrirModalPorFlash = <?php echo (!empty($perfilError) || !empty($perfilOk)) ? 'true' : 'false'; ?>;
  if (abrirModalPorFlash) {
    bootstrap.Modal.getOrCreateInstance(editarPerfilModalElement).show();
  }

  editarPerfilModalElement.querySelectorAll('.toggle-password-btn').forEach(function (button) {
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

  editarPerfilModalElement.addEventListener('hidden.bs.modal', function () {
    editarPerfilModalElement.querySelectorAll('.toggle-password-btn').forEach(function (button) {
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