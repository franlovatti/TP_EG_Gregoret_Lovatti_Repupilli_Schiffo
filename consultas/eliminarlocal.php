<?php
require_once '../conexion.php';

function redirigirConMensajeLocal($tipo, $mensaje) {
  $mensajeCodificado = urlencode($mensaje);
  header("Location: ../front/crearlocal.php?$tipo=$mensajeCodificado");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id'])) {
  redirigirConMensajeLocal('local_error', 'Solicitud invalida para eliminar el local.');
}

$id_local = intval($_GET['id']);
if ($id_local <= 0) {
  redirigirConMensajeLocal('local_error', 'ID de local invalido.');
}

$stmtCheck = $conexion->prepare("SELECT COUNT(*) as total FROM promocion WHERE id_local = ?");
if (!$stmtCheck) {
  redirigirConMensajeLocal('local_error', 'Error al verificar promociones asociadas: ' . $conexion->error);
}
$stmtCheck->bind_param("i", $id_local);
$stmtCheck->execute();
$result = $stmtCheck->get_result();
$row = $result->fetch_assoc();
$stmtCheck->close();

if ($row['total'] > 0) {
  redirigirConMensajeLocal('local_error', 'No se puede eliminar el local porque tiene promociones asociadas. Debes eliminarlas primero.');
} else {
  $stmtDelete = $conexion->prepare("UPDATE local SET estado = 'eliminado' WHERE id_local = ?");
  if (!$stmtDelete) {
    redirigirConMensajeLocal('local_error', 'Error al preparar la eliminacion: ' . $conexion->error);
  }
  $stmtDelete->bind_param("i", $id_local);
  $resultado = $stmtDelete->execute();

  if ($resultado) {
    $filasAfectadas = $stmtDelete->affected_rows;
    $stmtDelete->close();
    if ($filasAfectadas > 0) {
      redirigirConMensajeLocal('local_ok', 'Local eliminado exitosamente.');
    }
    redirigirConMensajeLocal('local_error', 'No se pudo eliminar el local o ya estaba eliminado.');
  } else {
    $errorEjecucion = $stmtDelete->error;
    $stmtDelete->close();
    redirigirConMensajeLocal('local_error', 'Error al eliminar el local: ' . $errorEjecucion);
  }
}

mysqli_close($conexion);
?>