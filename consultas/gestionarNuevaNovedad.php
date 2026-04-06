<?php
require_once '../conexion.php';
function redirigirConParametros($ruta, $params) {
    $query = http_build_query($params);
    header("Location: {$ruta}?{$query}");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirigirConParametros('../front/crearnovedad.php', [
        'novedad_error' => 'Acceso no permitido.'
    ]);
}

$descripcion = trim($_POST['descripcion_novedad'] ?? '');
$fecha_desde = $_POST['fecha_desde'] ?? '';
$fecha_hasta = $_POST['fecha_hasta'] ?? '';
$tipo_usuario = $_POST['tipo_usuario'] ?? '';

$datosFormulario = [
    'form_descripcion' => $descripcion,
    'form_fecha_desde' => $fecha_desde,
    'form_fecha_hasta' => $fecha_hasta,
    'form_tipo_usuario' => $tipo_usuario
];

if (empty($descripcion) || empty($fecha_desde) || empty($fecha_hasta) || empty($tipo_usuario)) {
    redirigirConParametros('../front/nuevanovedad.php', array_merge($datosFormulario, [
        'novedad_error' => 'Todos los campos son obligatorios.'
    ]));
}

if ($fecha_hasta < $fecha_desde) {
    redirigirConParametros('../front/nuevanovedad.php', array_merge($datosFormulario, [
        'novedad_error' => 'La fecha hasta no puede ser menor que la fecha desde.'
    ]));
}

$stmt = $conexion->prepare("INSERT INTO novedad (descripcion_novedad, fecha_desde, fecha_hasta, tipo_usuario, estado) VALUES (?, ?, ?, ?, 'activo')");
if (!$stmt) {
    redirigirConParametros('../front/nuevanovedad.php', array_merge($datosFormulario, [
        'novedad_error' => 'Error al preparar el alta de novedad: ' . $conexion->error
    ]));
}

$stmt->bind_param("ssss", $descripcion, $fecha_desde, $fecha_hasta, $tipo_usuario);
$resultado = $stmt->execute();

if ($resultado) {
    $stmt->close();
    redirigirConParametros('../front/crearnovedad.php', [
        'novedad_ok' => 'Novedad creada exitosamente.'
    ]);
}

$errorEjecucion = $stmt->error;
$stmt->close();
redirigirConParametros('../front/nuevanovedad.php', array_merge($datosFormulario, [
    'novedad_error' => 'Error al crear la novedad: ' . $errorEjecucion
]));

mysqli_close($conexion);
?>