<?php include '../conexion.php';

function redirigirConMensajeLocal($tipo, $mensaje) {
    $mensajeCodificado = urlencode($mensaje);
    header("Location: ../front/crearlocal.php?$tipo=$mensajeCodificado");
    exit;
}

$id_local=$_POST["id_local"];
$nombre_local=$_POST["nombre_local"];
$ubicacion=$_POST["ubicacion"];
$rubro=$_POST["rubro"];
$id_usuario=$_POST["id_usuario"];
$descripcion=$_POST["descripcion"];
$estado=$_POST["estado"];

$maxBytesImagen = 65535;
$queryMaxLen = "SELECT CHARACTER_MAXIMUM_LENGTH AS max_len
                FROM information_schema.COLUMNS
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'local'
                  AND COLUMN_NAME = 'imagen_local'";
$resultadoMaxLen = mysqli_query($conexion, $queryMaxLen);
if ($resultadoMaxLen && ($filaMaxLen = mysqli_fetch_assoc($resultadoMaxLen)) && !empty($filaMaxLen['max_len'])) {
    $maxBytesImagen = (int)$filaMaxLen['max_len'];
}

$imagen_binaria=null;
if (isset($_FILES['imagen_local']) && $_FILES['imagen_local']['error'] === UPLOAD_ERR_OK) {
        $tmpPath = $_FILES['imagen_local']['tmp_name'];
        $check = getimagesize($tmpPath);
        if ($check !== false) {
            $imagen_binaria = file_get_contents($tmpPath);
            if ($imagen_binaria === false) {
                redirigirConMensajeLocal('local_error', 'No se pudo leer la imagen cargada.');
            }

            if (strlen($imagen_binaria) > $maxBytesImagen) {
                $maxKb = (int) ceil($maxBytesImagen / 1024);
                redirigirConMensajeLocal('local_error', "La imagen es demasiado grande para guardar en la base de datos. Maximo permitido: {$maxKb} KB.");
            }
        
    } else {
        redirigirConMensajeLocal('local_error', 'El archivo no es una imagen valida.');
    }}

if ($imagen_binaria === null) {
    $vSQL = "UPDATE local 
              SET nombre_local = ?, ubicacion = ?, rubro = ?, descripcion = ?, estado = ?, id_usuario = ?
              WHERE id_local = ?";
    $stmt = $conexion->prepare($vSQL);
    if (!$stmt) {
        redirigirConMensajeLocal('local_error', 'Error al preparar la actualizacion del local: ' . $conexion->error);
    }
    $stmt->bind_param("sssssii", $nombre_local, $ubicacion, $rubro, $descripcion, $estado, $id_usuario, $id_local);
} else {
    $vSQL = "UPDATE local 
              SET nombre_local = ?, ubicacion = ?, rubro = ?, descripcion = ?, estado = ?, imagen_local = ?, id_usuario = ?
              WHERE id_local = ?";
    $stmt = $conexion->prepare($vSQL);
    if (!$stmt) {
        redirigirConMensajeLocal('local_error', 'Error al preparar la actualizacion del local: ' . $conexion->error);
    }
    $stmt->bind_param("sssssbii", $nombre_local, $ubicacion, $rubro, $descripcion, $estado, $imagen_binaria, $id_usuario, $id_local);
    $stmt->send_long_data(5, $imagen_binaria);
}
try {
    if ($stmt->execute()) {
        redirigirConMensajeLocal('local_ok', 'Registro actualizado exitosamente.');
    } else {
        redirigirConMensajeLocal('local_error', 'Error al actualizar el local: ' . $stmt->error);
    }
} catch (mysqli_sql_exception $e) {
    if (stripos($e->getMessage(), 'Data too long for column') !== false) {
        $maxKb = (int) ceil($maxBytesImagen / 1024);
        redirigirConMensajeLocal('local_error', "La imagen supera el tamano permitido por la columna imagen_local. Maximo: {$maxKb} KB.");
    }
    redirigirConMensajeLocal('local_error', 'Error al actualizar el local: ' . $e->getMessage());
}

$stmt->close();
mysqli_close($conexion);


?>