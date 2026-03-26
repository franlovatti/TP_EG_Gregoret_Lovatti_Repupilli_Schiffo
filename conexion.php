<?php
// Load environment variables
require_once __DIR__ . '/config/Load.php';

// Get database credentials from .env
$host = env('DB_HOST');
$usuario = env('DB_USER');
$clave = env('DB_PASSWORD');
$baseDatos = env('DB_NAME');

if (!$host || !$usuario || !$clave || !$baseDatos) {
    die('Error: Variables de entorno de BD no configuradas. Verifica el archivo .env');
}

$conexion = mysqli_connect($host, $usuario, $clave, $baseDatos);
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
return $conexion;
?>