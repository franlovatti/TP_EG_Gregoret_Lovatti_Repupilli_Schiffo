<?php
function recuperar(){
    require_once '../conexion.php';
    require 'scriptPHPmailer.php';
    error_reporting(E_ERROR | E_PARSE); // Muestra solo errores fatales y errores de análisis
    ini_set('display_errors', 0);       // No mostrar errores al usuario
    global $recuperar;
    $email = trim($_POST['correoRecuperar']);
    $query = "SELECT * FROM usuario WHERE mail_usuario='$email' ";
    $resultados = mysqli_query($conexion,$query) or die("Hubo un error con la transacción:".mysqli_error($conexion));
    if(mysqli_num_rows($resultados) > 0){
      $selector = bin2hex(random_bytes(8));
      $token = bin2hex(random_bytes(32));
      $token_hash = password_hash($token, PASSWORD_DEFAULT);
      $expira = date('Y-m-d H:i:s', time() + 900); // 15 minutos de validez
      $query = "UPDATE usuario SET selector='$selector', token='$token_hash', token_tiempo='$expira' WHERE mail_usuario='$email'";
      $resultado = mysqli_query($conexion, $query) or die("Hubo un error con la transacción:".mysqli_error($conexion));
      if ($resultado) {
        $asunto = "Recuperacion de clave";
        $mensaje = "<p>Hola, hemos recibido una solicitud para recuperar tu contraseña. Por favor, haz clic en el siguiente enlace para restablecerla:</p>
        <p><a href='http://localhost/archivosXampp/front/home.php?selector=".$selector."&token=".$token."'>Restablecer contraseña</a></p>
        <p>Si no solicitaste este cambio, puedes ignorar este mensaje.</p>
        <p>Este enlace expirará en 15 minutos.</p>";
        $respuesta = sendMail($email, $asunto, $mensaje);
        if ($respuesta) {
          mysqli_close($conexion);
          echo '<meta http-equiv="refresh" content="0;url=home.php?recuperar=1">';
          exit();
        } else {
          $recuperar = "Error al enviar el correo de recuperación.";
        }
      }else {
        $recuperar = "Error al actualizar el token en la base de datos.";
      }
    }
    else{
      $recuperar = "El usuario no existe.";
    }
    mysqli_close($conexion);
}

function tokenClave(){
    require_once '../conexion.php';
    global $token_resultado;
    $token_resultado = '0';
    $selector = $_GET['selector'];
    $token = $_GET['token'];
    //echo $token;
    $query = "SELECT * FROM usuario WHERE selector='$selector'";
    $resultados = mysqli_query($conexion, $query) or die("Hubo un error con la transacción:".mysqli_error($conexion));
    if(mysqli_num_rows($resultados) > 0){
      $fila = mysqli_fetch_array($resultados);
      if (strtotime($fila['token_tiempo']) > time()) {
        if (password_verify($token, $fila['token'])) {
          // Mostrar formulario para cambiar la contraseña
          $_SESSION['usuario_cambio_clave'] = $fila['mail_usuario'];
          $token_resultado = '1';
        }
      }
    }
}

function cambiarClave(){
    require_once '../conexion.php';
    global $cambiar_error;
    if ($_POST['claveNueva'] !== $_POST['claveNueva2']) {
      $cambiar_error = "Las contraseñas no coinciden.";
      return;
    }else{
      $email = $_SESSION['usuario_cambio_clave'];
      $nuevaClave = $_POST['claveNueva'];
      $claveHash = password_hash($nuevaClave, PASSWORD_DEFAULT);
      $tiempo = date('Y-m-d H:i:s', time());
      $query = "UPDATE usuario SET clave_usuario='$claveHash', selector='', token='', token_tiempo='$tiempo' WHERE mail_usuario='$email'";
      $resultado = mysqli_query($conexion, $query) or die("Hubo un error con la transacción:".mysqli_error($conexion));
      if ($resultado) {
        // Limpiar el token y el selector
        $query = "SELECT * from usuario WHERE mail_usuario='$email'";
        $resultado2 = mysqli_query($conexion, $query) or die("Hubo un error con la transacción:".mysqli_error($conexion));
        $fila = mysqli_fetch_array($resultado2);
        if (mysqli_num_rows($resultado2) > 0) {
          $_SESSION['usuario'] = $fila['mail_usuario'];
          $_SESSION['tipoUsuario'] = $fila['tipo_usuario'];
          $_SESSION['idUsuario'] = $fila['id_usuario'];
          if ($_SESSION['tipoUsuario'] === 'dueño') {
            $_SESSION['estado'] = $fila['estado'];
          }
          $_SESSION['categoria'] = $fila['categoria'];
        } else {
          $cambiar_error = "Error al limpiar el token y selector. el numero de filas es: " . mysqli_num_rows($resultado2);
        }
      } else {
        $cambiar_error = "Error al cambiar la contraseña.";
      }
    }
    mysqli_close($conexion);
    if (empty($cambiar_error)) {
      echo '<meta http-equiv="refresh" content="0;url=home.php?cambiar=1">';
      exit();
    }
}