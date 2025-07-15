<?php
require_once '../conexion.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
  $id_promocion = intval($_GET['id']);
}

$query="delete from promocion where (`id_promocion` = '$id_promocion')";
$resultado = mysqli_query($conexion, $query);
if ($resultado) {
    header("Location:crearpromocion.php");
  } else {
    echo "<div class='alert alert-danger text-center'>Error al eliminar la promoción: " . mysqli_error($conexion) . "</div>";
  }

mysqli_close($conexion);
?>