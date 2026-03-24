<?php
require_once '../conexion.php';

$query = "UPDATE promocion 
          SET estado = 'vencida' 
          WHERE estado = 'activa' 
          AND fecha_hasta < CURDATE()";

mysqli_query($conexion, $query);
?>