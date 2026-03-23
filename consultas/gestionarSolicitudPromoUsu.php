<?php
require_once '../conexion.php';
require_once '../actualizarCategoriaUsuario.php';
require_once '../enviarMailPromo.php';

if(isset($_GET['id_uso'],$_GET['accion'])){
    $id_uso = $_GET['id_uso'];
    $accion = $_GET['accion'];

    $codigoUso = '';

    if($accion == "aceptar"){
        $estado = "aceptada";
        $codigoUso = generarCodigoUsoPromo();
        $query = "UPDATE uso_promocion
              SET estado = ? ,
                  fecha_uso = CURDATE(),
                    codigo_uso = ?
              WHERE id_uso = ?";
    } else if($accion == "rechazar"){
        $estado = "rechazada";
        $query = "UPDATE uso_promocion
              SET estado = ?,
                    codigo_uso = ?
              WHERE id_uso = ?";
    }

    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "ssi", $estado, $codigoUso, $id_uso);

    if(mysqli_stmt_execute($stmt)){
        if ($accion == "aceptar") {
            actualizarCategoriaUsuario($id_uso);
        }
        enviarMailPromo($id_uso, $estado);
        header("Location: ../front/gestionarPromoUsuario.php?estado=$estado");
        exit;
    } else {
        echo "Error: " . mysqli_error($conexion);
    }

}
?>