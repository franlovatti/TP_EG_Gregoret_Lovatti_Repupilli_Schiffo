
<?php
require_once '../conexion.php';

if(isset($_SESSION['idUsuario'])){
  $id_usuario=$_SESSION['idUsuario'];
}

$query = "SELECT l.nombre_local, l.ubicacion, l.rubro, l.imagen_local, p.*
          FROM local l
          INNER JOIN promocion p ON l.id_local = p.id_local AND p.estado = 'activa'
          WHERE l.id_usuario = $id_usuario";

$resultado = mysqli_query($conexion, $query);

mysqli_close($conexion);
?>