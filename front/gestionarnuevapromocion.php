<?php
require_once '../conexion.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_promocion'])) {
  $descripcion = $_POST['descripcion'];  
  $id_local = intval($_POST['id_local']);
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
  //procesar la imagen 
  $imagen_binaria = null;
    if (isset($_FILES['imagen_prom']) && $_FILES['imagen_prom']['error'] === UPLOAD_ERR_OK) {
        $tmpPath = $_FILES['imagen_prom']['tmp_name'];
        $check = getimagesize($tmpPath);
        if ($check !== false) {
            $imagen_binaria = file_get_contents($tmpPath);
        } else {
            die("⚠️ El archivo no es una imagen válida.");
        }
    } else {
        die("⚠️ No se pudo subir la imagen. Código de error: " . $_FILES['imagen_prom']['error']);
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

    if ($stmt->execute()) {
        echo "✅ Promoción cargada exitosamente.";
        header("Location: nuevapromocion.php");
        exit;
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>