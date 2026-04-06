<?php
require_once '../conexion.php';

function redirigirConMensajeNovedad($tipo, $mensaje) {
  $mensajeCodificado = urlencode($mensaje);
  header("Location: ../front/crearnovedad.php?$tipo=$mensajeCodificado");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id'])) {
  redirigirConMensajeNovedad('novedad_error', 'Solicitud invalida para eliminar la novedad.');
}

$id_novedad = intval($_GET['id']);
if ($id_novedad <= 0) {
  redirigirConMensajeNovedad('novedad_error', 'ID de novedad invalido.');
}

$stmt = $conexion->prepare("UPDATE novedad SET estado = 'inactivo' WHERE id_novedad = ?");
if (!$stmt) {
  redirigirConMensajeNovedad('novedad_error', 'Error al preparar la eliminacion: ' . $conexion->error);
}

$stmt->bind_param("i", $id_novedad);
$resultado = $stmt->execute();

if ($resultado) {
  $filasAfectadas = $stmt->affected_rows;
  $stmt->close();
  if ($filasAfectadas > 0) {
    redirigirConMensajeNovedad('novedad_ok', 'Novedad eliminada exitosamente.');
  }
  redirigirConMensajeNovedad('novedad_error', 'No se pudo eliminar la novedad o ya estaba inactiva.');
}

$errorEjecucion = $stmt->error;
$stmt->close();
redirigirConMensajeNovedad('novedad_error', 'Error al eliminar la novedad: ' . $errorEjecucion);

mysqli_close($conexion);
?>