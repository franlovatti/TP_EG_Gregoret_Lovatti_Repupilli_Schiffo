<?php
require_once '../conexion.php';

echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
  $id_novedad = intval($_GET['id']);
  $query = "UPDATE novedad 
            SET estado = 'inactivo' 
            WHERE id_novedad = $id_novedad";

  $resultado = mysqli_query($conexion, $query);
  if ($resultado) {
    header("Location: ../front/crearnovedad.php");
  } else {
    echo "<div class='alert alert-danger text-center'>
            Error al eliminar la novedad
          </div>
          <div class='text-center mt-3'>
            <a href='../front/novedades.php' class='btn btn-secondary'>Volver</a>
          </div>";
  }
} else {
  echo "<div class='alert alert-warning text-center'>
          id no válido
        </div>
        <div class='text-center mt-3'>
          <a href='../front/novedades.php' class='btn btn-secondary'>Volver</a>
        </div>";
}
mysqli_close($conexion);
?>