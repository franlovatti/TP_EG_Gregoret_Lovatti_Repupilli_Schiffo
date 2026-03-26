<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Novedades (ADMINISTRADOR)</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link rel="stylesheet" href="estilos/global.css" />
 
</head>

<body class="d-flex flex-column min-vh-100">

<header class="p-3 text-bg-dark">
  <?php include '../header.php'; ?>
</header>

<?php include '../modals/modalEditarNovedad.php'; ?>


<div class="modal fade" id="confirmDeleteModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Confirmar eliminación</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        ¿Seguro que querés eliminar esta novedad?
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a id="confirmDeleteBtn" class="btn btn-danger">Eliminar</a>
      </div>
    </div>
  </div>
</div>

<div class="container mt-4">

  <div class="card shadow">
    <div class="card-body">

      <div class="d-flex justify-content-between mb-4">
        <h3>Gestión de Novedades</h3>
      </div>

      <div class="row">
        <div class="col-lg-6 mb-4">
          <form method="post">
            <div class="input-group">
              <input name="Buscar" class="form-control" placeholder="Buscar por descripción...">
              <button class="btn btn-primary">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </form>
        </div>

        <div class="col-lg-3 mb-4">
          <a href="nuevanovedad.php" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Nueva novedad
          </a>
        </div>
      </div>

<?php
require_once '../conexion.php';

$query = "SELECT * FROM novedad where estado='activo'";
$resultado = mysqli_query($conexion, $query);

$hayResultados = false;

echo "<div class='table-responsive'>";
echo "<table class='table table-hover table-bordered text-center'>";
echo "<thead class='table-dark'>
        <tr>
          <th>Descripción</th>
          <th>Desde</th>
          <th>Hasta</th>
          <th>Tipo Usuario</th>
          <th>Acciones</th>
        </tr>
      </thead>";
echo "<tbody>";

while ($fila = mysqli_fetch_assoc($resultado)) {

  if (isset($_POST["Buscar"])) {
    if (stripos($fila['descripcion_novedad'], $_POST["Buscar"]) === false) {
      continue;
    }
  }

  $hayResultados = true;

  echo "<tr>";
  echo "<td>{$fila['descripcion_novedad']}</td>";
  echo "<td>{$fila['fecha_desde']}</td>";
  echo "<td>{$fila['fecha_hasta']}</td>";
  echo "<td>{$fila['tipo_usuario']}</td>";

  echo "<td>";

  
  echo '<a href="#" class="btn btn-danger btn-sm me-2"
        data-bs-toggle="modal"
        data-bs-target="#confirmDeleteModal"
        data-id="'.$fila['id_novedad'].'">
        <i class="bi bi-trash"></i>
      </a>';

  
  echo '<button class="btn btn-primary btn-sm"
        data-id="'.$fila['id_novedad'].'"
        data-desc="'.$fila['descripcion_novedad'].'"
        data-desde="'.$fila['fecha_desde'].'"
        data-hasta="'.$fila['fecha_hasta'].'"
        data-tipo="'.$fila['tipo_usuario'].'"
        data-bs-toggle="modal"
        data-bs-target="#modalEditarNovedad">
        <i class="bi bi-pencil"></i>
      </button>';

  echo "</td>";
  echo "</tr>";
}

echo "</tbody></table>";
echo "</div>";

if (!$hayResultados) {
  echo "<div class='alert alert-info text-center'>No hay novedades</div>";
}

mysqli_close($conexion);
?>

    </div>
  </div>
</div>

<footer class="mt-auto">
  <?php include '../footer.php'; ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

document.getElementById('confirmDeleteModal')
.addEventListener('show.bs.modal', function (event) {
  const button = event.relatedTarget;
  const id = button.getAttribute('data-id');

  document.getElementById('confirmDeleteBtn').href =
    '../consultas/eliminarnovedad.php?id=' + id;
});


document.getElementById('modalEditarNovedad')
.addEventListener('show.bs.modal', function (event) {
  const button = event.relatedTarget;

  document.getElementById("modal-id").value =
    button.getAttribute('data-id');

  document.getElementById("modal-desc").value =
    button.getAttribute('data-desc');

  document.getElementById("modal-desde").value =
    button.getAttribute('data-desde');

  document.getElementById("modal-hasta").value =
    button.getAttribute('data-hasta');

  document.getElementById("modal-tipo").value =
    button.getAttribute('data-tipo');
});
</script>

</body>
</html>