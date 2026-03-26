<?php
function signUp() {
  require_once __DIR__ . '/config/Load.php';
  include __DIR__ . '/conexion.php';
  include __DIR__ . '/scriptPHPmailer.php';
  error_reporting(E_ERROR | E_PARSE); // Muestra solo errores fatales y errores de análisis
  ini_set('display_errors', 0);       // No mostrar errores al usuario
  global $signUp_error;
  $email = trim($_POST['correo']);
  $clave = $_POST['clave'];
  $clave2 = $_POST['clave2'];
  $estado = 'activo';
  $tipo = 'cliente';
  if (isset($_POST['esDueno']) && $_POST['esDueno'] === 'si') {
    $estado = 'pendiente';
    $tipo = 'dueño';
  }
  if ($clave !== $clave2) {
    $signUp_error = "Las contraseñas no coinciden.";
  }else {
    $clave = password_hash($clave, PASSWORD_DEFAULT);
    $query = "SELECT * FROM usuario WHERE mail_usuario='$email' ";
    $resultados = mysqli_query($conexion,$query) or die("Hubo un error con la transacción:".mysqli_error($conexion));
    if(mysqli_num_rows($resultados) > 0){
      $signUp_error = "El usuario ya existe.";
    } else {
      $selector = bin2hex(random_bytes(8));
      $token = bin2hex(random_bytes(32));
      $token_hash = password_hash($token, PASSWORD_DEFAULT);
      $query = "INSERT INTO usuario (mail_usuario, clave_usuario, tipo_usuario, estado, categoria, selector_verificado, token_verificado, verificado) VALUES ('$email', '$clave', '$tipo', '$estado', 'inicial', '$selector', '$token_hash', '0')";
      $resultados = mysqli_query($conexion, $query) or die("Hubo un error con la transacción:".mysqli_error($conexion));
      if ($resultados) {
        $appUrl = rtrim((string) env('APP_URL', ''), '/');
        if ($appUrl === '') {
          $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
          $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
          $appUrl = $scheme . '://' . $host;
        }
        $linkVerificacion = $appUrl . "/front/home.php?selector_verificado=" . $selector . "&token_verificado=" . $token;
        $asunto = "Verificacion de cuenta";
        $mensaje = "<p>Hola, te enviamos este correo para verificar tu cuenta. Por favor, haz clic en el siguiente enlace para verificarla:</p>
        <p><a href='".$linkVerificacion."'>Verificar cuenta</a></p>
        <p>Si no solicitaste esta verificación, puedes ignorar este mensaje.</p>";
        $respuesta = sendMail($email, $asunto, $mensaje);
        if ($respuesta) {
          mysqli_close($conexion);
          echo '<meta http-equiv="refresh" content="0;url=home.php?verificado=0">';
          exit();
        } else {
          $signUp_error = "Error al enviar el correo de verificación.";
        }
      } else {
        $signUp_error = "Error al registrar el usuario.";
      }
    }
  }
  mysqli_close($conexion);
}

function verificarRegistro(){
  require_once __DIR__ . '/conexion.php';
  global $signUp_error;
  if (!isset($_GET['selector_verificado']) || !isset($_GET['token_verificado'])) {return;}
  $selector = trim($_GET['selector_verificado']);
  $token = trim($_GET['token_verificado']);
  if ($selector === '' || $token === '') {return;}
  $query = "SELECT * FROM usuario WHERE selector_verificado='$selector'";
  $resultados = mysqli_query($conexion, $query) or die("Hubo un error con la transacción:".mysqli_error($conexion));
  if(mysqli_num_rows($resultados) > 0){
    $fila = mysqli_fetch_array($resultados);
    if (password_verify($token, $fila['token_verificado'])) {
      $query = "UPDATE usuario SET selector_verificado='', token_verificado='', verificado='1' WHERE mail_usuario='".$fila['mail_usuario']."'";
      $resultado = mysqli_query($conexion, $query) or die("Hubo un error con la transacción:".mysqli_error($conexion));
      if ($resultado) {
        $query = "SELECT * from usuario WHERE mail_usuario='".$fila['mail_usuario']."'";
        $resultado2 = mysqli_query($conexion, $query) or die("Hubo un error con la transacción:".mysqli_error($conexion));
        $fila = mysqli_fetch_array($resultado2);
        if (mysqli_num_rows($resultado2) > 0) {
          $_SESSION['usuario'] = $fila['mail_usuario'];
          $_SESSION['tipoUsuario'] = $fila['tipo_usuario'];
          $_SESSION['idUsuario'] = $fila['id_usuario'];
          $_SESSION['categoria'] = $fila['categoria'];
          $_SESSION['estado'] = $fila['estado'];
        } else {
          $signUp_error = "Error al recuperar los datos del usuario después de la verificación.";
        }
        echo '<meta http-equiv="refresh" content="0;url=home.php?verificado=1">';
        exit();
      } else {
        $signUp_error = "Error al verificar el registro.";
      }
    } else {
      $signUp_error = "Token de verificación inválido.";
    }
  } else {
    $signUp_error = "Selector de verificación no encontrado.";
  }
}
?>