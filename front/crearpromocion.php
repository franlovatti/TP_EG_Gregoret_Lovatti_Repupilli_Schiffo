<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Promociones (dueño)</title>
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
    color: #e91e63; 
    font-weight: bold;
    }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">

<header class="p-3 text-bg-dark">
  <?php include '../header.php'; ?>
</header>
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        ¿Seguro que deseas eliminar esta promoción? Esta acción no se puede deshacer.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Eliminar</a>
      </div>
    </div>
  </div>
</div>

  <div class="container w-75 my-4">
  <div class="row align-items-center gy-2">
    <div class="col-lg-9 col-12">
      <label for="estado" class="form-label fw-semibold mb-1">
        Filtrar por estado de promoción:
      </label>
      <form class="d-flex" method="post" action="">
        <div class="input-group">
          <select class="form-select" name="estado" id="estado" required>
            <option value="pendiente">Promociones pendientes</option>
            <option value="activa">Promociones activas</option>
            <option value="rechazada">Promociones rechazadas</option>
          </select>
          <button class="btn btn-primary" type="submit">
            <i class="bi bi-search"></i>
          </button>
        </div>
      </form>
    </div>

    <div class="col-lg-3 col-12 text-lg-end text-start">
      <a href="nuevapromocion.php" class="btn btn-link p-0">Crear nueva promoción...</a>
    </div>
  </div>
</div>


<?php
require_once '../conexion.php';
$query = "SELECT * FROM promocion";
$resultado = mysqli_query($conexion, $query);
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}


if (isset($_POST["estado"])){
    while ($fila = mysqli_fetch_assoc($resultado)) {
        if($fila['estado']==$_POST["estado"]){
            if(!isset($bandera)){
                echo "<table class='table table-bordered'>";
                echo "<thead><tr><th>Descripción</th><th>Fecha desde</th><th>Fecha hasta</th><th>Categoría</th><th>Cant usos</th><th>Estado</th></tr></thead>";
                echo "<tbody>";
            }
            echo "<tr>";
            echo "<td>" . $fila['descripcion'] . "</td>";
            echo "<td>" . $fila['fecha_desde'] . "</td>";
            echo "<td>" . $fila['fecha_hasta'] . "</td>";
            echo "<td>" . $fila['categoria'] . "</td>";
            echo "<td> falta ver </td>";
            echo "<td>" . $fila['estado'] . "</td>";
            echo '<td><a href="#" class="btn btn-danger btn-sm" 
            data-bs-toggle="modal" 
            data-bs-target="#confirmDeleteModal" 
            data-id="' . $fila['id_promocion'] . '">Eliminar promoción</a></td>';
            echo "</tr>";
            $bandera=1;
        }
    }
    echo "</tbody></table>";
    if(!isset($bandera)){
        echo "<p class='text-center text-danger mt-3'>NO HAY PROMOCIONES CON ESTADO: ". $_POST["estado"].  "</p>";
    }
}
else {
        echo "<table class='table table-bordered'>";
        echo "<thead><tr><th>Descripción</th><th>Fecha desde</th><th>Fecha hasta</th><th>Categoría</th><th>Cant usos</th><th>Estado</th></tr></thead>";
        echo "<tbody>";
       while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>" . $fila['descripcion'] . "</td>";
            echo "<td>" . $fila['fecha_desde'] . "</td>";
            echo "<td>" . $fila['fecha_hasta'] . "</td>";
            echo "<td>" . $fila['categoria'] . "</td>";
            echo "<td> falta ver </td>";
            echo "<td>" . $fila['estado'] . "</td>";
            echo '<td><a href="#" class="btn btn-danger btn-sm" 
            data-bs-toggle="modal" 
            data-bs-target="#confirmDeleteModal" 
            data-id="' . $fila['id_promocion'] . '">Eliminar promoción</a></td>';
            echo "</tr>";
    }
    echo "</tbody></table>";
} 
mysqli_close($conexion);
?>
<footer class="footer mt-auto py-3 bg-body-tertiary">
  <?php include '../footer.php'; ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const confirmDeleteModal = document.getElementById('confirmDeleteModal');
  confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const id_promocion = button.getAttribute('data-id');
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    confirmBtn.href = 'eliminarpromocion.php?id=' + id_promocion;
  });
</script>
</body>
</html>