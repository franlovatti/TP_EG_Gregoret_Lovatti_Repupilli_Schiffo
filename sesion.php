<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../login.php';
include '../signUp.php';
include '../signUpD.php';
include '../recuperar.php';
date_default_timezone_set('America/Argentina/Buenos_Aires');

$login_error = "";
$signUp_error = "";
$recuperar = "";
$cambiar_error = "";
if (isset($_COOKIE['usuario']) && isset($_COOKIE['mantenerSesionIniciada']) && $_COOKIE['mantenerSesionIniciada'] === 'si' && !isset($_SESSION['usuario']) && empty($_SESSION['cerrarSesion'])) {
  $_SESSION['usuario'] = $_COOKIE['usuario'];
  $_SESSION['tipoUsuario'] = $_COOKIE['tipoUsuario'];
  $_SESSION['idUsuario'] = $_COOKIE['idUsuario'];
  if ($_SESSION['tipoUsuario'] === 'dueño' && isset($_COOKIE['estado'])) {
    $_SESSION['estado'] = $_COOKIE['estado'];
  }
  $_SESSION['categoria'] = $_COOKIE['categoriaCliente'];
} elseif (isset($_POST['email']) && isset($_POST['password'])) {
  login();
} elseif (isset($_POST['correo']) && isset($_POST['clave']) && isset($_POST['clave2']) && isset($_POST['esDueno']) && $_POST['esDueno'] === 'si') {
  signUpD();
} elseif (isset($_POST['correo']) && isset($_POST['clave']) && isset($_POST['clave2'])) {
  signUp();
} elseif (isset($_POST['correoRecuperar'])){
  recuperar();
} elseif (isset($_GET['token'])) {
  tokenClave();
} elseif (isset($_POST['claveNueva']) && isset($_POST['claveNueva2'])) {
  cambiarClave();
}
?>