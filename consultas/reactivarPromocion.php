<?php
require_once '../conexion.php';

if (!isset($_GET['id'])) {
    header("Location: ../front/crearpromocion.php");
    exit;
}

$id_promocion = intval($_GET['id']);
$fecha_desde = $_GET['fecha_desde'];
$fecha_hasta = $_GET['fecha_hasta'];

$query = "UPDATE promocion 
          SET estado = 'pendiente',
              fecha_desde = '$fecha_desde',
              fecha_hasta = '$fecha_hasta'
          WHERE id_promocion = $id_promocion
          AND estado = 'vencida'";

$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    header("Location: ../front/crearpromocion.php");
} else {
    echo "<div class='alert alert-danger text-center'>Error al reactivar la promoción: " . mysqli_error($conexion) . "</div>";
}

mysqli_close($conexion);
?>