<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ejemplo de Modal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<button type="button" class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#modalEjemplo"
        data-id="123"
        data-nombre="Panadería La Esquina"
        data-ubicacion="Calle Falsa 123">
    Editar Local
</button>

<div class="modal fade" id="modalEjemplo" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Local</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="modal-id">
          <div class="mb-3">
            <label for="modal-nombre" class="form-label">Nombre del Local</label>
            <input type="text" class="form-control" id="modal-nombre">
          </div>
          <div class="mb-3">
            <label for="modal-ubicacion" class="form-label">Ubicación</label>
            <input type="text" class="form-control" id="modal-ubicacion">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const modalEjemplo = document.getElementById('modalEjemplo');
    modalEjemplo.addEventListener('show.bs.modal', function (event) {
      // El botón que fue clicado y activó el modal
      const button = event.relatedTarget;

      // Obtener los valores de los atributos data-* del botón
      const id = button.getAttribute('data-id');
      const nombre = button.getAttribute('data-nombre');
      const ubicacion = button.getAttribute('data-ubicacion');
      
      // Asignar los valores a los campos del formulario
      document.getElementById('modal-id').value = id;
      document.getElementById('modal-nombre').value = nombre;
      document.getElementById('modal-ubicacion').value = ubicacion;
    });
</script>

</body>
</html>