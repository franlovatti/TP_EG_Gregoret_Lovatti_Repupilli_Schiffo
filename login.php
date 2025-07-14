<?php
function login(){
    require_once '../conexion.php';
    error_reporting(E_ERROR | E_PARSE); // Muestra solo errores fatales y errores de análisis
    ini_set('display_errors', 0);       // No mostrar errores al usuario
    global $login_error;
    $email = trim($_POST['email']);
    $mantenerSesionIniciada = $_POST['mantenerSesionIniciada'];
    $query = "SELECT * FROM usuario WHERE mail_usuario='$email' ";
    $resultados = mysqli_query($conexion,$query) or die("Hubo un error con la transacción:".mysqli_error($conexion));
    mysqli_close($conexion);
    $fila = mysqli_fetch_array($resultados);
    if(mysqli_num_rows($resultados) > 0){
      if (password_verify($_POST['password'], $fila['clave_usuario'])){
        $_SESSION['categoria'] = $fila['categoria'];
        $_SESSION['usuario'] = $fila['mail_usuario'];
        $_SESSION['tipoUsuario'] = $fila['tipo_usuario'];
        $_SESSION['idUsuario'] = $fila['id_usuario'];
        if ($fila['tipo_usuario'] === 'dueño') {
        $_SESSION['estado'] = $fila['estado'];
        }
        if($mantenerSesionIniciada=='si'){
          setcookie('mantenerSesionIniciada','si',time()+(60*60*24*365));
          setcookie('usuario',$fila['mail_usuario'],time()+(60*60*24*365));
          setcookie('tipoUsuario',$fila['tipo_usuario'],time()+(60*60*24*365));
          setcookie('categoriaCliente',$fila['categoriaCliente'],time()+(60*60*24*365));
          setcookie('idUsuario',$fila['id_usuario'],time()+(60*60*24*365));
        }
        if ($fila['tipo_usuario'] === 'dueño') {
        setcookie('estado', $fila['estado'], time()+(60*60*24*365)); 
        }
        $login_error = '';
        echo '<meta http-equiv="refresh" content="0;url=home.php">';
        exit();
      }
      else{
        $login_error = "Contraseña incorrecta.";
      }
    }
    else{
      $login_error = "El usuario no existe.";
    }
  }