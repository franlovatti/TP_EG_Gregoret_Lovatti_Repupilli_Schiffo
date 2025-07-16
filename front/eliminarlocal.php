<?php
require_once '../conexion.php';
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
  $id_local = intval($_GET['id']);
}
$result = mysqli_query($conexion, "SELECT COUNT(*) as total FROM promocion WHERE id_local = $id_local");
$row = mysqli_fetch_assoc($result);
if ($row['total'] > 0) {
    echo "<div class='alert alert-warning text-center'>
                  No se puede eliminar local porque tiene promociones asociadas.<br>
                  Debe eliminarlas primero antes de eliminar el local.
                </div>
                <div class='text-center mt-3'>
                  <a href='crearlocal.php' class='btn btn-secondary'>Volver</a>
                </div>";
} else {
  $query="UPDATE local SET estado = 'eliminado' WHERE id_local = $id_local";
  $resultado = mysqli_query($conexion, $query);
  if ($resultado) {
      header("Location:crearlocal.php");
    } else {
      echo "<div class='alert alert-danger text-center'>Error al eliminar el local </div>";
    }
  }
mysqli_close($conexion);
?>