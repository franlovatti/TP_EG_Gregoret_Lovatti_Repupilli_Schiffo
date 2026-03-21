<?php
require_once '../conexion.php';

function redirigirConMensaje($tipo, $mensaje) {
        $mensajeCodificado = urlencode($mensaje);
        header("Location: ../front/nuevapromocion.php?$tipo=$mensajeCodificado");
        exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_promocion'])) {
  $descripcion = $_POST['descripcion'];  
  $id_local = $_POST['id_local'];
  $lunes = $_POST['lunes'];
  $martes = $_POST['martes'];
  $miercoles = $_POST['miercoles'];
  $jueves = $_POST['jueves'];
  $viernes = $_POST['viernes'];
  $sabado = $_POST['sabado'];
  $domingo = $_POST['domingo'];
  $categoria = $_POST['categoria'];
  $fecha_desde = $_POST['fecha_desde'];
  $fecha_hasta = $_POST['fecha_hasta'];
  $estado= 'pendiente';

  $maxBytesImagen = 65535;
  $queryMaxLen = "SELECT CHARACTER_MAXIMUM_LENGTH AS max_len
                  FROM information_schema.COLUMNS
                  WHERE TABLE_SCHEMA = DATABASE()
                    AND TABLE_NAME = 'promocion'
                    AND COLUMN_NAME = 'imagen_prom'";
  $resultadoMaxLen = mysqli_query($conexion, $queryMaxLen);
  if ($resultadoMaxLen && ($filaMaxLen = mysqli_fetch_assoc($resultadoMaxLen)) && !empty($filaMaxLen['max_len'])) {
      $maxBytesImagen = (int)$filaMaxLen['max_len'];
  }

  //procesar la imagen 
  $imagen_binaria = null;
    if (isset($_FILES['imagen_prom']) && $_FILES['imagen_prom']['error'] === UPLOAD_ERR_OK) {
        $tmpPath = $_FILES['imagen_prom']['tmp_name'];
        $check = getimagesize($tmpPath);
        if ($check !== false) {
            $imagen_binaria = file_get_contents($tmpPath);
            if ($imagen_binaria === false) {
                redirigirConMensaje('promo_error', 'No se pudo leer la imagen cargada.');
            }

            if (strlen($imagen_binaria) > $maxBytesImagen) {
                $maxKb = (int) ceil($maxBytesImagen / 1024);
                redirigirConMensaje('promo_error', "La imagen es demasiado grande para guardar en la base de datos. Maximo permitido: {$maxKb} KB.");
            }
        } else {
            redirigirConMensaje('promo_error', 'El archivo no es una imagen valida.');
        }
    } else {
        $codigoError = $_FILES['imagen_prom']['error'] ?? 'desconocido';
        redirigirConMensaje('promo_error', "No se pudo subir la imagen. Codigo de error: $codigoError");
    }
 // Preparar la consulta
    $sql = "INSERT INTO promocion (
        descripcion, fecha_desde, fecha_hasta, categoria, id_local, estado,
        lunes, martes, miercoles, jueves, viernes, sabado, domingo, imagen_prom
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);

    // Bind de los primeros 13 campos, dejando imagen_prom como NULL por ahora
    $null = NULL; // para el blob
    // s-> string, i-> integer, b-> blob
    $stmt->bind_param("ssssisiiiiiiib",
        $descripcion, $fecha_desde, $fecha_hasta, $categoria, $id_local, $estado,
        $lunes, $martes, $miercoles, $jueves, $viernes, $sabado, $domingo, $null
    );

    // Enviar los datos binarios correctamente
    $stmt->send_long_data(13, $imagen_binaria); // 13 porque es el índice del 14° parámetro (imagen_prom)

    try {
        if ($stmt->execute()) {
            header("Location: ../front/crearpromocion.php");
        } else {
            redirigirConMensaje('promo_error', 'No se pudo cargar la promocion.');
        }
    } catch (mysqli_sql_exception $e) {
        if (stripos($e->getMessage(), 'Data too long for column') !== false) {
            $maxKb = (int) ceil($maxBytesImagen / 1024);
            redirigirConMensaje('promo_error', "La imagen supera el tamano permitido por la columna imagen_prom. Maximo: {$maxKb} KB.");
        }
        redirigirConMensaje('promo_error', 'Error al guardar la promocion: ' . $e->getMessage());
    }

    $stmt->close();
    $conexion->close();
}
?>