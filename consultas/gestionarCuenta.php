<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'editar_perfil') {
  $redirectTo = $_POST['redirect_to'] ?? '/front/home.php';
  if (strpos($redirectTo, '/') !== 0) {
    $redirectTo = '/front/home.php';
  }

  if (empty($_SESSION['idUsuario'])) {
    $_SESSION['perfil_error'] = 'Debes iniciar sesion para editar tu perfil.';
    header('Location: ' . $redirectTo);
    exit;
  }

  $nombreNuevo = trim((string) ($_POST['nombrePerfil'] ?? ''));
  $_SESSION['perfil_form_nombre'] = $nombreNuevo;

  if ($nombreNuevo === '') {
    $_SESSION['perfil_error'] = 'El nombre no puede estar vacío.';
    header('Location: ' . $redirectTo);
    exit;
  }

  $claveNueva = $_POST['claveNueva'] ?? '';
  $claveNueva2 = $_POST['claveNueva2'] ?? '';

  if (($claveNueva === '' && $claveNueva2 !== '') || ($claveNueva !== '' && $claveNueva2 === '')) {
    $_SESSION['perfil_error'] = 'Si querés cambiar la contraseña, completa ambos campos.';
    header('Location: ' . $redirectTo);
    exit;
  }

  if ($claveNueva !== '' && $claveNueva !== $claveNueva2) {
    $_SESSION['perfil_error'] = 'Las contraseñas no coinciden.';
    header('Location: ' . $redirectTo);
    exit;
  }

  $idUsuario = (int) $_SESSION['idUsuario'];
  $nombreActual = trim((string) ($_SESSION['nombre'] ?? ''));
  $cambiaNombre = $nombreNuevo !== $nombreActual;
  $cambiaClave = $claveNueva !== '';

  if (!$cambiaNombre && !$cambiaClave) {
    $_SESSION['perfil_error'] = 'No hay cambios para guardar.';
    header('Location: ' . $redirectTo);
    exit;
  }

  if ($cambiaNombre && $cambiaClave) {
    $claveHash = password_hash($claveNueva, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conexion, 'UPDATE usuario SET nombre_usuario = ?, clave_usuario = ? WHERE id_usuario = ?');
    if ($stmt) {
      mysqli_stmt_bind_param($stmt, 'ssi', $nombreNuevo, $claveHash, $idUsuario);
    }
  } elseif ($cambiaNombre) {
    $stmt = mysqli_prepare($conexion, 'UPDATE usuario SET nombre_usuario = ? WHERE id_usuario = ?');
    if ($stmt) {
      mysqli_stmt_bind_param($stmt, 'si', $nombreNuevo, $idUsuario);
    }
  } else {
    $claveHash = password_hash($claveNueva, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conexion, 'UPDATE usuario SET clave_usuario = ? WHERE id_usuario = ?');
    if ($stmt) {
      mysqli_stmt_bind_param($stmt, 'si', $claveHash, $idUsuario);
    }
  }

  if (empty($stmt)) {
    $_SESSION['perfil_error'] = 'No se pudo actualizar el perfil.';
    header('Location: ' . $redirectTo);
    exit;
  }

  $ok = mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  if ($ok) {
    if ($cambiaNombre) {
      $_SESSION['nombre'] = $nombreNuevo;
      if (isset($_COOKIE['nombre'])) {
        setcookie('nombre', $nombreNuevo, time() + (60 * 60 * 24 * 365), '/');
      }
    }
    unset($_SESSION['perfil_form_nombre']);
    $_SESSION['perfil_ok'] = 'Perfil actualizado correctamente.';
  } else {
    $_SESSION['perfil_error'] = 'No se pudo actualizar el perfil.';
  }

  mysqli_close($conexion);
  header('Location: ' . $redirectTo);
  exit;
}

if (isset($_GET['id_usuario']) && isset($_GET['accion'])) {
  $id_usuario = intval($_GET['id_usuario']);
  $nuevo_estado = $_GET['accion'];
  
  if ($nuevo_estado === 'rechazar') {
    //Verificar si tiene locales asociados
    $checkLocales = mysqli_query($conexion, "SELECT COUNT(*) as total FROM local WHERE id_usuario = $id_usuario AND estado='activo'");
    $data = mysqli_fetch_assoc($checkLocales);
    
    if ($data['total'] > 0) {
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">';
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
      $query = "UPDATE usuario SET estado = '$nuevo_estado' WHERE id_usuario = $id_usuario AND tipo_usuario = 'dueño'";
      $resultado = mysqli_query($conexion, $query);

        if ($resultado) {
          header("Location:../front/solicitudesusuario.php");
          exit;
        } else {
          echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">';
          echo "<div class='alert alert-danger text-center'>Error al actualizar el estado: " . mysqli_error($conexion) . "</div>";
        }
      }
    }

mysqli_close($conexion);
?>
