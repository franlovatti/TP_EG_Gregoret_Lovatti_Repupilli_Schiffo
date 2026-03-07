<?php
require_once '../conexion.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $idCliente = $_POST['idCliente'];
  $idPromo = $_POST['idPromo'];
  $query = "INSERT INTO uso_promocion (id_cliente, id_promocion, estado) VALUES (?, ?, 'pendiente')";
  $stmt = mysqli_prepare($conexion, $query);
  if (!$stmt) {
      die("Error al preparar la consulta: " . mysqli_error($conexion));
  } 
  // Enlazás los parámetros a la consulta preparada
  mysqli_stmt_bind_param($stmt, "ii", $idCliente, $idPromo);

  // Ejecutás la consulta
  if (mysqli_stmt_execute($stmt)) {
    // Redirigir a una página de éxito o mostrar un mensaje de confirmación
    header("Location: promociones.php?promo=ok");
    exit;

      // Podés redirigir o mostrar una confirmación
  } else {
      echo "Error al ejecutar la consulta: " . mysqli_stmt_error($stmt);
  }

  mysqli_stmt_close($stmt);
  mysqli_close($conexion);
} else {
    // Acceso indebido
    header("Location: promociones.php");
    exit;
}
?>
