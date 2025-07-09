<?php
$host = 'localhost';
$usuario = 'entornos';
$clave = '1234';
$baseDatos = 'shopping';
$conexion = mysqli_connect($host, $usuario, $clave, $baseDatos);
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
return $conexion;
?>