<?php
// Load environment variables
require_once __DIR__ . '/config/Load.php';

// Get database credentials from environment (.env local or Railway vars)
$host = env('DB_HOST', env('MYSQLHOST'));
$usuario = env('DB_USER', env('MYSQLUSER'));
$clave = env('DB_PASSWORD', env('MYSQLPASSWORD', ''));
$baseDatos = env('DB_NAME', env('MYSQLDATABASE'));
$puerto = (int) env('DB_PORT', env('MYSQLPORT', 3306));

if (!$host || !$usuario || !$baseDatos) {
    die('Error: Variables de entorno de BD no configuradas. Definilas en Railway o en el archivo .env local.');
}

$conexion = mysqli_connect($host, $usuario, $clave, $baseDatos, $puerto);
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
return $conexion;
?>