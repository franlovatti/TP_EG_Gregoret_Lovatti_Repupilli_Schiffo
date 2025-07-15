<?php
require_once '../conexion.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_promocion'])) {
  $descripcion = $_POST['descripcion'];  
  $id_local = intval($_POST['id_local']);
  $lunes = $_POST['lunes'];
  $martes = $_POST['martes'];
  $miercoles = $_POST['miercoles'];
  $jueves = $_POST['jueves'];
  $viernes = $_POST['viernes'];
  $sabado = $_POST['sabado'];
  $domingo = $_POST['domingo'];
  $categoria = $_POST['categoria'];
  $fecha_desde = $_POST['fecha_desde'];
  $fecha_hasta = $_POST['fecha_hasta'];
  $estado= 'pendiente';
}

$query = "INSERT INTO promocion (`descripcion`, `fecha_desde`, `fecha_hasta`, `categoria`, `id_local`, `estado`, `lunes`, `martes`, `miercoles`, `jueves`, `viernes`, `sabado`, `domingo`) VALUES ('$descripcion', '$fecha_desde', '$fecha_hasta', '$categoria', '$id_local', '$estado', '$lunes', '$martes', '$miercoles', '$jueves', '$viernes', '$sabado', '$domingo')";
$resultado = mysqli_query($conexion, $query);
  if ($resultado) {
    header("Location:crearpromocion.php");
  } else {
    echo "<div class='alert alert-danger text-center'>Error al crear la promoción: " . mysqli_error($conexion) . "</div>";
  }

mysqli_close($conexion);
?>