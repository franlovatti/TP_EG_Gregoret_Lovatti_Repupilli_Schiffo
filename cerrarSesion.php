<?php 
session_start();
$_SESSION=[];
session_unset();
session_destroy();
session_start();
$_SESSION['cerrarSesion'] = true;
setcookie('mantenerSesionIniciada','si',time()-(60*60*24*365));
setcookie('usuario',time()-(60*60*24*365));
setcookie('tipoUsuario',time()-(60*60*24*365));
setcookie('categoriaCliente',time()-(60*60*24*365));
header("Location: front/home.php");
exit();

?>