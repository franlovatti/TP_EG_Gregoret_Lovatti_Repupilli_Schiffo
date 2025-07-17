<?php include '../conexion.php';
$id_local=$_POST["id_local"];
$nombre_local=$_POST["nombre_local"];
$ubicacion=$_POST["ubicacion"];
$rubro=$_POST["rubro"];
$id_usuario=$_POST["id_usuario"];
$descripcion=$_POST["descripcion"];
$estado=$_POST["estado"];
$imagen_binaria=null;
if (isset($_FILES['imagen_local']) && $_FILES['imagen_local']['error'] === UPLOAD_ERR_OK) {
        $tmpPath = $_FILES['imagen_local']['tmp_name'];
        $check = getimagesize($tmpPath);
        if ($check !== false) {
            $imagen_binaria = file_get_contents($tmpPath);
        
    } else {
        die("⚠️ No se pudo subir la imagen. Código de error: " . $_FILES['imagen_local']['error']);
    }}

$vSQL = "UPDATE LOCAL 
              SET nombre_local = ?, ubicacion = ?, rubro = ?, descripcion = ?, estado = ?, imagen_local = ?, id_usuario = ?
              WHERE id_local = ?";

$stmt=$conexion->prepare($vSQL);
if ($imagen_binaria === null) {
        $null = NULL;
        $stmt->bind_param("sssssbii", $nombre_local, $ubicacion, $rubro, $descripcion, $estado, $null,$id_usuario ,$id_local);
        $stmt->send_long_data(5,$imagen_binaria);
    } else {
        $stmt->bind_param("sssssbii", $nombre_local, $ubicacion, $rubro, $descripcion, $estado, $imagen_binaria,$id_usuario, $id_local);
        $stmt->send_long_data(5,$imagen_binaria);
    }
if ($stmt->execute()) {
        echo "✅ Registro actualizado exitosamente.";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

$stmt->close();
mysqli_close($conexion);
header("Location:crearlocal.php");

?>