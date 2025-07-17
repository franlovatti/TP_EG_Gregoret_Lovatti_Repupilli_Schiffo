<?php
require_once '../conexion.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear-local'])) {
  $id_usuario = intval($_POST['id_usuario']);
  $nombre_local = $_POST['nombre_local'];
  $ubicacion = $_POST['ubicacion'];
  $rubro = $_POST['rubro'];
  $descripcion = $_POST['descripcion'];
  $estado=$_POST['estado'];
}
$imagen_binaria=null;
if (isset($_FILES['imagen_local']) && $_FILES['imagen_local']['error'] === UPLOAD_ERR_OK) {
        $tmpPath = $_FILES['imagen_local']['tmp_name'];
        $check = getimagesize($tmpPath);
        if ($check !== false) {
            $imagen_binaria = file_get_contents($tmpPath);
        } else {
            die("⚠️ El archivo no es una imagen válida.");
        }
    } else {
        die("⚠️ No se pudo subir la imagen. Código de error: " . $_FILES['imagen_local']['error']);
    }

$vSQL="INSERT INTO LOCAL (nombre_local, ubicacion, rubro, id_usuario, descripcion,imagen_local) VALUES (?,?,?,?,?,?)";
$stmt=$conexion->prepare($vSQL);
$null=NULL;
$stmt->bind_param("sssisb",$nombre_local,$ubicacion,$rubro,$id_usuario,$descripcion,$null);
$stmt->send_long_data(5,$imagen_binaria);
if($stmt->execute()){
    echo "✅ Local cargado exitosamente.";
    header("Location: nuevolocal.php");
    exit;
}
else{
  echo "❌ Error: " . $stmt->error;
}
$stmt->close();
mysqli_close($conexion);


?>