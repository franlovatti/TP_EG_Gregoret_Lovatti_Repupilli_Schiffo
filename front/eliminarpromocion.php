<?php
require_once '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id'])) {
    header("Location: crearpromocion.php?error=id_invalido");
    exit();
}

$id_promocion = intval($_GET['id']);

/* Buscar estado actual y cantidad de usos */
$queryVerificar = "
    SELECT estado
    FROM promocion
    WHERE id_promocion = $id_promocion
";

$resultadoVerificar = mysqli_query($conexion, $queryVerificar);

if (!$resultadoVerificar || mysqli_num_rows($resultadoVerificar) === 0) {
    header("Location: crearpromocion.php?error=no_existe");
    exit();
}
$fila = mysqli_fetch_assoc($resultadoVerificar);
$estado = $fila['estado'];

if ($estado === 'activa') {
    header("Location: crearpromocion.php?error=no_eliminar");
    exit();
}

/* Eliminación lógica */
$query = "
    UPDATE promocion 
    SET estado = 'eliminada'
    WHERE id_promocion = $id_promocion
";

$resultado = mysqli_query($conexion, $query);
if ($resultado) {
    header("Location: crearpromocion.php?ok=eliminada");
    exit();
} else {
    header("Location: crearpromocion.php?error=db");
    exit();
}

mysqli_close($conexion);
?>