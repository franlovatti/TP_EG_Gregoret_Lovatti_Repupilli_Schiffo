<?php
require_once '../conexion.php';
function redirigirConParametros($ruta, $params) {
    $query = http_build_query($params);
    header("Location: {$ruta}?{$query}");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirigirConParametros('../front/crearnovedad.php', [
        'edit_error' => 'Acceso no permitido para editar novedad.'
    ]);
}

$id = intval($_POST['id_novedad'] ?? 0);
$descripcion = trim($_POST['descripcion_novedad'] ?? '');
$fecha_desde = $_POST['fecha_desde'] ?? '';
$fecha_hasta = $_POST['fecha_hasta'] ?? '';
$tipo_usuario = $_POST['tipo_usuario'] ?? '';

$datosEdicion = [
    'edit_open' => 1,
    'edit_id' => $id,
    'edit_desc' => $descripcion,
    'edit_desde' => $fecha_desde,
    'edit_hasta' => $fecha_hasta,
    'edit_tipo' => $tipo_usuario
];

if ($id <= 0) {
    redirigirConParametros('../front/crearnovedad.php', array_merge($datosEdicion, [
        'edit_error' => 'ID de novedad invalido.'
    ]));
}

if (empty($descripcion) || empty($fecha_desde) || empty($fecha_hasta) || empty($tipo_usuario)) {
    redirigirConParametros('../front/crearnovedad.php', array_merge($datosEdicion, [
        'edit_error' => 'Todos los campos son obligatorios para editar la novedad.'
    ]));
}

if ($fecha_hasta < $fecha_desde) {
    redirigirConParametros('../front/crearnovedad.php', array_merge($datosEdicion, [
        'edit_error' => 'La fecha hasta no puede ser menor que la fecha desde.'
    ]));
}

$stmt = $conexion->prepare("UPDATE novedad SET descripcion_novedad = ?, fecha_desde = ?, fecha_hasta = ?, tipo_usuario = ? WHERE id_novedad = ?");
if (!$stmt) {
    redirigirConParametros('../front/crearnovedad.php', array_merge($datosEdicion, [
        'edit_error' => 'Error al preparar la edicion: ' . $conexion->error
    ]));
}

$stmt->bind_param("ssssi", $descripcion, $fecha_desde, $fecha_hasta, $tipo_usuario, $id);
$resultado = $stmt->execute();

if ($resultado) {
    $filasAfectadas = $stmt->affected_rows;
    $stmt->close();
    if ($filasAfectadas > 0) {
        redirigirConParametros('../front/crearnovedad.php', [
            'novedad_ok' => 'Novedad actualizada exitosamente.'
        ]);
    }
    redirigirConParametros('../front/crearnovedad.php', [
        'edit_error' => 'No se detectaron cambios para guardar en la novedad.'
    ]);
}

$errorEjecucion = $stmt->error;
$stmt->close();
redirigirConParametros('../front/crearnovedad.php', array_merge($datosEdicion, [
    'edit_error' => 'Error al actualizar la novedad: ' . $errorEjecucion
]));

mysqli_close($conexion);
?>