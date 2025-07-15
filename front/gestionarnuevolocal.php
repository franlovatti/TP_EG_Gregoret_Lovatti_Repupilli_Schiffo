<?php
require_once '../conexion.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear-local'])) {
  $id_usuario = intval($_POST['id_usuario']);
  $nombre_local = $_POST['nombre_local'];
  $ubicacion = $_POST['ubicacion'];
  $rubro = $_POST['rubro'];
  $descripcion = $_POST['descripcion'];
}

$query = "INSERT INTO local (nombre_local, ubicacion, rubro, id_usuario, descripcion)
          VALUES ('$nombre_local', '$ubicacion', '$rubro', '$id_usuario', '$descripcion')";
$resultado = mysqli_query($conexion, $query);
  if ($resultado) {
    header("Location:crearlocal.php");
  } else {
    echo "<div class='alert alert-danger text-center'>Error al crear el local: " . mysqli_error($conexion) . "</div>";
  }

mysqli_close($conexion);
?>