<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Promociones (dueño)</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="estilos/promocion/crearPromocion.css" />
</head>

<body class="d-flex flex-column min-vh-100">

<header class="p-3 text-bg-dark">
    <?php include '../header.php'; ?>
</header>

<!-- MODAL CONFIRMAR ELIMINACION -->

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Confirmar eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                ¿Seguro que deseas eliminar esta promoción? Esta acción no se puede deshacer.
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Eliminar</a>
            </div>

        </div>

    </div>

</div>

<div class="container w-75 my-4">

    <div class="filtros-box">

        <div class="row align-items-end gy-2">

            <div class="col-lg-9 col-12">

                <label for="estado" class="form-label fw-semibold">
                    Promociones
                </label>

                <form class="d-flex" method="post" action="">

                    <div class="input-group">

                        <select class="form-select" name="estado" id="estado" required>
                            <option value="pendiente">Pendientes</option>
                            <option value="activa">Activas</option>
                            <option value="rechazada">Rechazadas</option>
                            <option value="todas">Todas</option>
                        </select>

                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>

                    </div>

                </form>

            </div>

            <div class="col-lg-3 col-12 text-lg-end">

                <a href="nuevapromocion.php" class="btn btn-success crear-promo">
                    <i class="bi bi-plus-circle"></i> Nueva promoción
                </a>

            </div>

        </div>

    </div>

</div>

<div class="container w-75">

<div class="scrollable-box">

<?php

require_once '../conexion.php';

if(isset($_SESSION['idUsuario'])){

$id_usuario=$_SESSION['idUsuario'];

$query1 = "SELECT l.id_local, l.nombre_local, p.*
           from local l
           JOIN promocion p ON l.id_local = p.id_local
           WHERE l.id_usuario = $id_usuario";

$resultado = mysqli_query($conexion, $query1);

if ($resultado && mysqli_num_rows($resultado) > 0) {

if (!$resultado) {
die("Error en la consulta: " . mysqli_error($conexion));
}

if (isset($_POST["estado"])){

while ($fila = mysqli_fetch_assoc($resultado)) {

if($fila['estado']==$_POST["estado"] || $_POST["estado"] == "todas"){

if(!isset($bandera)){

echo "<table class='table table-hover table-bordered'>";
echo "<thead class='table-dark'>";
echo "<tr>
<th>Local</th>
<th>Descripción</th>
<th>Desde</th>
<th>Hasta</th>
<th>Categoría</th>
<th>Estado</th>
<th>Acciones</th>
</tr>";
echo "</thead><tbody>";

}

$estadoClase = "";

if($fila['estado']=="activa") $estadoClase="estado-activa";
if($fila['estado']=="pendiente") $estadoClase="estado-pendiente";
if($fila['estado']=="rechazada") $estadoClase="estado-rechazada";

echo "<tr>";

echo "<td>".$fila['nombre_local']."</td>";
echo "<td>".$fila['descripcion']."</td>";
echo "<td>".$fila['fecha_desde']."</td>";
echo "<td>".$fila['fecha_hasta']."</td>";
echo "<td>".$fila['categoria']."</td>";

echo "<td><span class='badge $estadoClase'>".$fila['estado']."</span></td>";

echo '<td>
<a href="#" class="btn btn-danger btn-sm"
data-bs-toggle="modal"
data-bs-target="#confirmDeleteModal"
data-id="'.$fila['id_promocion'].'">
<i class="bi bi-trash"></i>
</a>
</td>';

echo "</tr>";

$bandera=1;

}

}

echo "</tbody></table>";

if(!isset($bandera)){

echo "<div class='alert alert-info text-center'>
NO HAY PROMOCIONES CON ESTADO: ".$_POST["estado"]."
</div>";

}

}

else {

echo "<table class='table table-hover table-bordered'>";
echo "<thead class='table-dark'>";
echo "<tr>
<th>Local</th>
<th>Descripción</th>
<th>Desde</th>
<th>Hasta</th>
<th>Categoría</th>
<th>Estado</th>
<th>Acciones</th>
</tr>";
echo "</thead><tbody>";

while ($fila = mysqli_fetch_assoc($resultado)) {

$estadoClase = "";

if($fila['estado']=="activa") $estadoClase="estado-activa";
if($fila['estado']=="pendiente") $estadoClase="estado-pendiente";
if($fila['estado']=="rechazada") $estadoClase="estado-rechazada";

echo "<tr>";

echo "<td>".$fila['nombre_local']."</td>";
echo "<td>".$fila['descripcion']."</td>";
echo "<td>".$fila['fecha_desde']."</td>";
echo "<td>".$fila['fecha_hasta']."</td>";
echo "<td>".$fila['categoria']."</td>";

echo "<td><span class='badge $estadoClase'>".$fila['estado']."</span></td>";

echo '<td>
<a href="#" class="btn btn-danger btn-sm"
data-bs-toggle="modal"
data-bs-target="#confirmDeleteModal"
data-id="'.$fila['id_promocion'].'">
<i class="bi bi-trash"></i>
</a>
</td>';

echo "</tr>";

}

echo "</tbody></table>";

}

}else{

echo "<div class='alert alert-info text-center my-5'>
No se encontró ningún local asociado a tu cuenta.
</div>";

}

}

else{

echo "<div class='alert alert-info text-center my-5'>
No se encontró ningún dueño asociado a tu cuenta.
</div>";

}

mysqli_close($conexion);

?>

</div>
</div>

<footer class="footer mt-auto py-3 bg-body-tertiary">
<?php include '../footer.php'; ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

const confirmDeleteModal = document.getElementById('confirmDeleteModal');

confirmDeleteModal.addEventListener('show.bs.modal', function (event) {

const button = event.relatedTarget;

const id_promocion = button.getAttribute('data-id');

const confirmBtn = document.getElementById('confirmDeleteBtn');

confirmBtn.href = 'eliminarpromocion.php?id=' + id_promocion;

});

</script>

</body>
</html>