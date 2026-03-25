<?php
require_once '../conexion.php';
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">';

if (isset($_GET['id_usuario']) && isset($_GET['accion'])) {
  $id_usuario = intval($_GET['id_usuario']);
  $nuevo_estado = $_GET['accion'];

    if ($nuevo_estado === 'rechazar') {
    //Verificar si tiene locales asociados
    $checkLocales = mysqli_query($conexion, "SELECT COUNT(*) as total FROM local WHERE id_usuario = $id_usuario AND estado='activo'");
    $data = mysqli_fetch_assoc($checkLocales);

      if ($data['total'] > 0) {
          echo "<div class='alert alert-warning text-center'>
                  No se puede eliminar la cuenta porque tiene local asociado.<br>
                  Debe eliminarlos primero antes de rechazar la cuenta.
                </div>
                <div class='text-center mt-3'>
                  <a href='../front/solicitudesusuario.php' class='btn btn-secondary'>Volver</a>
                </div>";
      } else {
          $query = "DELETE FROM usuario WHERE id_usuario = $id_usuario";
          $resultado = mysqli_query($conexion, $query);

          if ($resultado) {
              header("Location: ../front/solicitudesusuario.php");
              exit;
          } else {
              echo "<div class='alert alert-danger text-center'>Error al eliminar el usuario: " . mysqli_error($conexion) . "</div>";
          }
      }
    }
    else{  
      $query = "UPDATE usuario SET estado = '$nuevo_estado', verificado = '1' WHERE id_usuario = $id_usuario AND tipo_usuario = 'dueño'";
      $resultado = mysqli_query($conexion, $query);

        if ($resultado) {
          header("Location:../front/solicitudesusuario.php");
          exit;
        } else {
          echo "<div class='alert alert-danger text-center'>Error al actualizar el estado: " . mysqli_error($conexion) . "</div>";
        }
      }
    }

mysqli_close($conexion);
?>
