<?php
require_once '../conexion.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id_novedad']);
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
    $query = "UPDATE novedad SET 
                descripcion_novedad = '$descripcion',
                fecha_desde = '$fecha_desde',
                fecha_hasta = '$fecha_hasta',
                tipo_usuario = '$tipo_usuario'
              WHERE id_novedad = $id";
    $resultado = mysqli_query($conexion, $query);
    if ($resultado) {
        header("Location: ../front/crearnovedad.php");
    } else {
        echo "Error al actualizar la novedad: " . mysqli_error($conexion);
    }
} else {
    echo "Acceso no permitido";
}
mysqli_close($conexion);
?>