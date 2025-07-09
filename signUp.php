<?php
function signUp() {
  require_once '../conexion.php';
  error_reporting(E_ERROR | E_PARSE); // Muestra solo errores fatales y errores de análisis
  ini_set('display_errors', 0);       // No mostrar errores al usuario
  global $signUp_error;
  $email = trim($_POST['correo']);
  $clave = $_POST['clave'];
  $clave2 = $_POST['clave2'];
  if ($clave !== $clave2) {
    $signUp_error = "Las contraseñas no coinciden.";
  }else {
    $clave = password_hash($clave, PASSWORD_DEFAULT);
    $mantenerSesionIniciada = $_POST['mantenerSesionIniciada'];
    $query = "SELECT * FROM usuario WHERE mail_usuario='$email' ";
    $resultados = mysqli_query($conexion,$query) or die("Hubo un error con la transacción:".mysqli_error($conexion));
    if(mysqli_num_rows($resultados) > 0){
      $signUp_error = "El usuario ya existe.";
    } else {
      $query = "INSERT INTO usuario (mail_usuario, clave_usuario, tipo_usuario, categoria) VALUES ('$email', '$clave', 'cliente', 'inicial')";
      $resultados = mysqli_query($conexion, $query) or die("Hubo un error con la transacción:".mysqli_error($conexion));
      if ($resultados) {
        $query = "SELECT * FROM usuario WHERE mail_usuario='$email' ";
        $resultados = mysqli_query($conexion, $query) or die("Hubo un error con la transacción:".mysqli_error($conexion));
        $fila = mysqli_fetch_array($resultados);
        $_SESSION['usuario'] = $fila['mail_usuario'];
        $_SESSION['tipoUsuario'] = $fila['tipo_usuario'];
        $_SESSION['idUsuario'] = $fila['id_usuario'];
        if ($mantenerSesionIniciada == 'si') {
          setcookie('mantenerSesionIniciada', 'si', time() + (60 * 60 * 24 * 365));
          setcookie('usuario', $fila['mail_usuario'], time() + (60 * 60 * 24 * 365));
          setcookie('tipoUsuario', $fila['tipo_usuario'], time() + (60 * 60 * 24 * 365));
          setcookie('idUsuario', $fila['id_usuario'], time() + (60 * 60 * 24 * 365));
        }
        $signUp_error = '';
        echo '<meta http-equiv="refresh" content="0;url=home.php">';
        exit();
      } else {
        $signUp_error = "Error al registrar el usuario.";
      }
    }
  }
  mysqli_close($conexion);
}
?>