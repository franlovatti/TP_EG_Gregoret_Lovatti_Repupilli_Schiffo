<?php
require_once '../conexion.php';

function redirigirConMensajeLocal($destino, $tipo, $mensaje) {
  $mensajeCodificado = urlencode($mensaje);
  header("Location: ../front/$destino?$tipo=$mensajeCodificado");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear-local'])) {
  $id_usuario = intval($_POST['id_usuario']);
  $nombre_local = $_POST['nombre_local'];
  $ubicacion = $_POST['ubicacion'];
  $rubro = $_POST['rubro'];
  $descripcion = $_POST['descripcion'];
  $estado=$_POST['estado'];
}

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
                redirigirConMensajeLocal('nuevolocal.php', 'local_error', 'No se pudo leer la imagen cargada.');
            }

            if (strlen($imagen_binaria) > $maxBytesImagen) {
                $maxKb = (int) ceil($maxBytesImagen / 1024);
                redirigirConMensajeLocal('nuevolocal.php', 'local_error', "La imagen es demasiado grande para guardar en la base de datos. Maximo permitido: {$maxKb} KB.");
            }
        } else {
            redirigirConMensajeLocal('nuevolocal.php', 'local_error', 'El archivo no es una imagen valida.');
        }
    } else {
        $codigoError = $_FILES['imagen_local']['error'] ?? 'desconocido';
        redirigirConMensajeLocal('nuevolocal.php', 'local_error', "No se pudo subir la imagen. Codigo de error: $codigoError");
    }

$vSQL="INSERT INTO local (nombre_local, ubicacion, rubro, id_usuario, descripcion,imagen_local) VALUES (?,?,?,?,?,?)";
$stmt=$conexion->prepare($vSQL);
$null=NULL;
$stmt->bind_param("sssisb",$nombre_local,$ubicacion,$rubro,$id_usuario,$descripcion,$null);
$stmt->send_long_data(5,$imagen_binaria);
try {
    if($stmt->execute()){
            redirigirConMensajeLocal('crearlocal.php', 'local_ok', 'Local cargado exitosamente.');
            exit;
    }
    else{
        redirigirConMensajeLocal('nuevolocal.php', 'local_error', 'Error al crear el local: ' . $stmt->error);
    }
} catch (mysqli_sql_exception $e) {
    if (stripos($e->getMessage(), 'Data too long for column') !== false) {
        $maxKb = (int) ceil($maxBytesImagen / 1024);
        redirigirConMensajeLocal('nuevolocal.php', 'local_error', "La imagen supera el tamano permitido por la columna imagen_local. Maximo: {$maxKb} KB.");
    }
    redirigirConMensajeLocal('nuevolocal.php', 'local_error', 'Error al crear el local: ' . $e->getMessage());
}
$stmt->close();
mysqli_close($conexion);


?>