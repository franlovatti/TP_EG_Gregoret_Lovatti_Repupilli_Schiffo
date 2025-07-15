<?php
require_once '../conexion.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
  $id_local = intval($_GET['id']);
}

$query="delete from local where (`id_local` = '$id_local')";
$resultado = mysqli_query($conexion, $query);
if ($resultado) {
    header("Location:crearlocal.php");
  } else {
    echo "<div class='alert alert-danger text-center'>Error al eliminar el local: " . mysqli_error($conexion) . "</div>";
  }

mysqli_close($conexion);
?>