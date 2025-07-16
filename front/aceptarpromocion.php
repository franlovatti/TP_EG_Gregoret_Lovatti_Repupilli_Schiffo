<?php
require_once '../conexion.php';

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>No se recibió ninguna promoción</div>";
    exit;
}

$id_promocion = intval($_GET['id']);
$query="UPDATE promocion SET estado = 'activa' WHERE id_promocion = $id_promocion ";
$resultado=mysqli_query($conexion, $query);
if ($resultado) {
    header("Location: aprobarpromocion.php");
    exit;
} else {
    echo "<div class='alert alert-danger text-center'>Error al aceptar la promoción " . mysqli_error($conexion) . "</div>";
}

mysqli_close($conexion);
?>