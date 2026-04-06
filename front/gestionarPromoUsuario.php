<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOLICITUDES DE PROMOS (DUEÑO)</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
    <link rel="stylesheet" href="estilos/global.css" />
    <link rel="stylesheet" href="estilos/promocion/crearPromocion.css" />

</head>

<body class="d-flex flex-column min-vh-100">

<header class="p-3 text-bg-dark">
    <?php include '../header.php'; ?>
</header>


<div class="container w-75 my-4">

<div class="tabla-box">

<h5 class="mb-3">
  Solicitudes de promociones pendientes
</h5>

<div class="scrollable-box">

<?php

require_once '../conexion.php';
$id_usuario = $_SESSION['idUsuario'];

$query = "SELECT uso.id_uso, uso.id_cliente, uso.estado, uso.id_promocion, 
                 u.mail_usuario, p.descripcion,
                 l.nombre_local
          FROM uso_promocion uso
          INNER JOIN usuario u ON uso.id_cliente = u.id_usuario
          INNER JOIN promocion p ON uso.id_promocion = p.id_promocion
          INNER JOIN local l ON p.id_local = l.id_local
          WHERE uso.estado = 'pendiente'
          AND l.id_usuario = $id_usuario";

$resultado = mysqli_query($conexion, $query);

if (!$resultado) {
    echo "<div class='alert alert-danger text-center'>
            Error en la base de datos: " . mysqli_error($conexion) . "
          </div>";
    mysqli_close($conexion);
    exit();
}

if(mysqli_num_rows($resultado) > 0){

echo "<div class='table-responsive'>";
echo "<table class='table table-hover table-bordered'>";

echo "<thead class='table-dark'>
<tr>
<th>Email cliente</th>
<th>Promoción</th>
<th>Local</th>
<th>Estado</th>
<th>Acciones</th>
</tr>
</thead>";

echo "<tbody>";

while ($fila = mysqli_fetch_assoc($resultado)) {

echo "<tr>";

echo "<td>".$fila['mail_usuario']."</td>";

echo "<td>".$fila['descripcion']."</td>";

echo "<td>".$fila['nombre_local']."</td>";

echo "<td>
<span class='badge estado-pendiente'>
".$fila['estado']."
</span>
</td>";

echo "<td>

<a href='../consultas/gestionarSolicitudPromoUsu.php?id_uso=".$fila['id_uso']."&accion=aceptar'
class='btn btn-success btn-sm'
aria-label='Aceptar solicitud de promoci&oacute;n'>
<i class='bi bi-check-lg' aria-hidden='true'></i>
<span class='visually-hidden'>Aceptar solicitud</span>
</a>

<a href='../consultas/gestionarSolicitudPromoUsu.php?id_uso=".$fila['id_uso']."&accion=rechazar'
class='btn btn-danger btn-sm'
aria-label='Rechazar solicitud de promoci&oacute;n'>
<i class='bi bi-x-lg' aria-hidden='true'></i>
<span class='visually-hidden'>Rechazar solicitud</span>
</a>

</td>";

echo "</tr>";

}

echo "</tbody></table>";
echo "</div>";

}else{

echo "<div class='alert alert-info text-center'>
No hay solicitudes pendientes de promociones.
</div>";

}

mysqli_close($conexion);

?>

</div>
</div>
</div>

<footer class="footer mt-auto py-3 bg-body-tertiary">
<?php include '../footer.php'; ?>
</footer>

<?php
if(isset($_GET['estado'])){
include '../modals/modalEstadoSoliPromo.php';
}
?>

<script>

document.addEventListener('DOMContentLoaded', function () {

var modal = new bootstrap.Modal(document.getElementById('estadoSoliPromo'));
modal.show();

});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>