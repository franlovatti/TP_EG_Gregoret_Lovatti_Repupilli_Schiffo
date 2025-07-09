<?php
function login(){
    error_reporting(E_ERROR | E_PARSE); // Muestra solo errores fatales y errores de análisis
    ini_set('display_errors', 0);       // No mostrar errores al usuario
    global $login_error;
    $email = trim($_POST['email']);
    $contrasena =$_POST['password'];
    $mantenerSesionIniciada = $_POST['mantenerSesionIniciada'];
    $query = "SELECT * FROM usuario WHERE mail_usuario='$email' ";
    $link= mysqli_connect("localhost","entornos","1234","shopping") or die("Hubo un error al conectarse con la base de datos");
    $resultados = mysqli_query($link,$query) or die("Hubo un error con la transacción:".mysqli_error($link));
    mysqli_close($link);
    $fila = mysqli_fetch_array($resultados);
    if(mysqli_num_rows($resultados) > 0){
      if ($contrasena == $fila['clave_usuario']){
        if ($tipoUsuario=='cliente'){
          $_SESSION['categoria'] = $fila['categoria'];
        }
        $_SESSION['usuario'] = $fila['mail_usuario'];
        $_SESSION['tipoUsuario'] = $fila['tipo_usuario'];
        $_SESSION['idUsuario'] = $fila['id_usuario'];
        if($mantenerSesionIniciada=='si'){
          setcookie('mantenerSesionIniciada','si',time()+(60*60*24*365));
          setcookie('usuario',$$fila['mail_usuario'],time()+(60*60*24*365));
          setcookie('tipoUsuario',$fila['tipo_usuario'],time()+(60*60*24*365));
          setcookie('categoriaCliente',$fila['categoriaCliente'],time()+(60*60*24*365));
          setcookie('idUsuario',$fila['id_usuario'],time()+(60*60*24*365));
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