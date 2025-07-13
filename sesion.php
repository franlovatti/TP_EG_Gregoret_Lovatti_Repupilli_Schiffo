<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../login.php';
include '../signUp.php';

$login_error = "";
$signUp_error = "";
if (isset($_COOKIE['usuario']) && $_COOKIE['mantenerSesionIniciada'] == 'si' && !isset($_SESSION['usuario']) && empty($_SESSION['cerrarSesion'])) {
  $_SESSION['usuario'] = $_COOKIE['usuario'];
  $_SESSION['tipoUsuario'] = $_COOKIE['tipoUsuario'];
  $_SESSION['idUsuario'] = $_COOKIE['idUsuario'];
  $_SESSION['categoria'] = $_COOKIE['categoriaCliente'];
} elseif (isset($_POST['email']) && isset($_POST['password'])) {
  login();
} elseif (isset($_POST['correo']) && isset($_POST['clave']) && isset($_POST['clave2'])){
  signUp();
}
?>