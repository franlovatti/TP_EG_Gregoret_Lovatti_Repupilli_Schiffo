<?php
function actualizarCategoriaUsuario($id_uso) {
    require_once '../conexion.php';
    global $conexion;

    $media = 5; // Número de promociones aceptadas para ser media
    $alta = 8; // Número de promociones aceptadas para ser alta

    $query = "SELECT id_cliente FROM uso_promocion WHERE id_uso = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_uso);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id_usuario);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($id_usuario) {
        $query = "SELECT categoria FROM usuario WHERE id_usuario = ?";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_usuario);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $categoria);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        $query = "SELECT COUNT(*) AS total_aceptadas FROM uso_promocion WHERE id_cliente = ? AND estado = 'aceptada'";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_usuario);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $total_aceptadas);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        $nueva_categoria = $categoria;

        if ($total_aceptadas >= $alta) {
            $nueva_categoria = 'premium';
        } elseif ($total_aceptadas >= $media) {
            $nueva_categoria = 'medium';
        } else {
            $nueva_categoria = 'inicial';
        }

        if ($nueva_categoria === $categoria) {
            return; // No se necesita actualizar la categoría
        }

        $query = "UPDATE usuario SET categoria = ? WHERE id_usuario = ?";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "si", $nueva_categoria, $id_usuario);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

    } else {
        return; // No se encontró el usuario
    }
}
?>