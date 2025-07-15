<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EDITAR ESTADO DE DUEÑO (ADMINISTRADOR)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <style>
    .scrollable-box {
      max-height: 400px;
      overflow-y: auto;
      border: 1px solid #ccc;
      padding: 10px;
    }
    footer {
      background-color: #f8f9fa;
      padding: 20px 0;
      text-align: center;
      font-size: 0.9rem;
    }
    .texto-destacado {
    color: #e91e63; /* rosa intenso como ejemplo */
    font-weight: bold;
    }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">

<header class="p-3 text-bg-dark">
  <?php include '../header.php'; ?>
</header>

<div class="modal fade" id="confirmRejectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar rechazo de cuenta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        ¿Seguro que deseas <span class="texto-destacado">rechazar</span> esta cuenta? Esta acción no se puede deshacer.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="confirmRejectBtn">Sí, rechazar</button>
      </div>
    </div>
  </div>
</div>

<?php 
if (isset($_GET['id'])) {
  $id_usuario = intval($_GET['id']);}?>
<div class="container my-5">
  <H4>Editar el estado del dueño: <?php echo "$id_usuario"; ?>
  <form id="estadoForm" method="post" action="gestionarCuenta.php">
    <div class="mb-3">
      <label for="nuevo_estado" class="form-label">Nuevo estado...</label>
      <select class="form-select" name="nuevo_estado" id="nuevo_estado" required>
        <option value="activo">Aprobar cuenta</option>
        <option value="rechazada">Rechazar cuenta</option>
      </select>
    </div>
    <input type="hidden" name="id_usuario" value="<?= $id_usuario ?>">
    <button type="submit" name="actualizar" class="btn btn-primary">Actualizar estado</button>
  </form>
</div>


<footer class="footer mt-auto py-3 bg-body-tertiary">
  <?php include '../footer.php'; ?>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('estadoForm');
  const selectEstado = document.getElementById('nuevo_estado');
  const rejectModal = new bootstrap.Modal(document.getElementById('confirmRejectModal'));
  const confirmRejectBtn = document.getElementById('confirmRejectBtn');

  form.addEventListener('submit', function(e) {
    // Si selecciona "rechazada", mostramos modal y detenemos envío
    if (selectEstado.value === 'rechazada') {
      e.preventDefault(); 
      rejectModal.show();
    }
  });

  // Si confirma en el modal, enviamos el formulario realmente
  confirmRejectBtn.addEventListener('click', () => {
    rejectModal.hide();
    form.submit();
  });
});
</script>
</body>
</html>