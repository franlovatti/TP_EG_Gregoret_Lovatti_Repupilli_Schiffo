<?php
require_once '../conexion.php';

if(isset($_GET['id_uso'],$_GET['accion'])){
    $id_uso = $_GET['id_uso'];
    $accion = $_GET['accion'];

    if($accion == "aceptar"){
        $estado = "aceptada";
    } else if($accion == "rechazar"){
        $estado = "rechazada";
    }

    $query = "UPDATE uso_promocion
              SET estado = ? 
              WHERE id_uso = ?";

    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "si", $estado, $id_uso);

    if(mysqli_stmt_execute($stmt)){
        header("Location: ../front/gestionarPromoUsuario.php?estado=$estado");
        exit;
    } else {
        echo "Error: " . mysqli_error($conexion);
    }

}
?>