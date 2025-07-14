<?php
require_once '../conexion.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
  $id_usuario = intval($_POST['id_usuario']);
  $nuevo_estado = $_POST['nuevo_estado'];}

$query = "UPDATE usuario SET estado = '$nuevo_estado' WHERE id_usuario = $id_usuario AND tipo_usuario = 'dueño'";
  $resultado = mysqli_query($conexion, $query);

  if ($resultado) {
    header("Location:solicitudesusuario.php");
  } else {
    echo "<div class='alert alert-danger text-center'>Error al actualizar el estado: " . mysqli_error($conexion) . "</div>";
  }

mysqli_close($conexion);
?>
