<div class="modal fade" id="registroDueñoModal" tabindex="-1" aria-labelledby="registrDoueñoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="registroDueñoModalLabel">Crear una cuenta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <form method="post" action=""> 
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
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-success">Registrarse</button>
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