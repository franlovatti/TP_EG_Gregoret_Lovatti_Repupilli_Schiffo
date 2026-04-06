<div class="modal fade" id="cambiarClaveModal" tabindex="-1" aria-labelledby="cambiarClaveModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cambiarClaveModalLabel">Cambiar contraseña</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar">
          <span class="visually-hidden">Cerrar</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="home.php?cambiar=1"> 
          <div class="mb-3">
            <label for="claveNueva" class="form-label">Contraseña</label>
            <div class="input-group">
              <input type="password" class="form-control" id="claveNueva" name="claveNueva" required />
              <button type="button" class="btn btn-outline-secondary toggle-password-btn" aria-label="Mostrar contraseña">
                <span class="visually-hidden">Mostrar contraseña</span>
                <i class="bi bi-eye"></i>
              </button>
            </div>
          </div>
          <div class="mb-3">
            <label for="claveNueva2" class="form-label">Confirmar contraseña</label>
            <div class="input-group">
              <input type="password" class="form-control" id="claveNueva2" name="claveNueva2" required />
              <button type="button" class="btn btn-outline-secondary toggle-password-btn" aria-label="Mostrar contraseña">
                <span class="visually-hidden">Mostrar contraseña</span>
                <i class="bi bi-eye"></i>
              </button>
            </div>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
  var cambiarClaveModalElement = document.getElementById('cambiarClaveModal');
  if (!cambiarClaveModalElement) {
    return;
  }

  cambiarClaveModalElement.querySelectorAll('.toggle-password-btn').forEach(function (button) {
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

  cambiarClaveModalElement.addEventListener('hidden.bs.modal', function () {
    cambiarClaveModalElement.querySelectorAll('.toggle-password-btn').forEach(function (button) {
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