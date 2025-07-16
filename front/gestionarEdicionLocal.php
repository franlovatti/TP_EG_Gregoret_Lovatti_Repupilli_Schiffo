<?php include '../conexion.php';
$id_local=$_POST["id_local"];
$nombre_local=$_POST["nombre_local"];
$ubicacion=$_POST["ubicacion"];
$rubro=$_POST["rubro"];
$id_usuario=$_POST["id_usuario"];
$descripcion=$_POST["descripcion"];
$vSQL="UPDATE local set nombre_local='$nombre_local', ubicacion='$ubicacion', rubro='$rubro',id_usuario='$id_usuario', descripcion='$descripcion' where id_local='$id_local'";
mysqli_query($conexion,$vSQL);
mysqli_close($conexion); 
header("Location:crearlocal.php");

?>