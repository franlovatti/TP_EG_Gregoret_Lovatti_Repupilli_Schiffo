<?php
require_once '../conexion.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descripcion = trim($_POST['descripcion_novedad']);
    $fecha_desde = $_POST['fecha_desde'];
    $fecha_hasta = $_POST['fecha_hasta'];
    $tipo_usuario = $_POST['tipo_usuario'];
    if (empty($descripcion) || empty($fecha_desde) || empty($fecha_hasta) || empty($tipo_usuario)) {
        header("Location: ../front/nuevanovedad.php?error=campos");
    }
    if ($fecha_hasta < $fecha_desde) {
        header("Location: ../front/nuevanovedad.php?error=fechas");
        exit;
    }
    $query = "INSERT INTO novedad 
              (descripcion_novedad, fecha_desde, fecha_hasta, tipo_usuario, estado)
              VALUES 
              ('$descripcion', '$fecha_desde', '$fecha_hasta', '$tipo_usuario', 'activo')";
    $resultado = mysqli_query($conexion, $query);
    if ($resultado) {
        header("Location: ../front/crearnovedad.php");
    } else {
        echo "Error al crear la novedad: " . mysqli_error($conexion);
    }
} else {
    echo "Acceso no permitido";
}
mysqli_close($conexion);
?>