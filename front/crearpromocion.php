<?php include '../sesion.php'; ?>
<?php include '../consultas/vencerPromociones.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Promociones (dueño)</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="estilos/global.css" />
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
                Dejará de ver los reportes de las promociones eliminadas.
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Eliminar</a>
            </div>

        </div>

    </div>

</div>
<!-- Modal para reactivar la prromocion-->
<div class="modal fade" id="reactivarModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Activar nuevamente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p>¿Querés reactivar esta promoción? Ingresá las nuevas fechas para enviarla a revisión del administrador.</p>

                <div class="mb-3">
                    <label for="nuevaFechaDesde" class="form-label">Fecha desde</label>
                    <input type="date" id="nuevaFechaDesde" class="form-control">
                    <div id="errorFechaDesde" class="text-danger small mt-1" style="display:none;"></div>
                </div>

                <div class="mb-3">
                    <label for="nuevaFechaHasta" class="form-label">Fecha hasta</label>
                    <input type="date" id="nuevaFechaHasta" class="form-control">
                    <div id="errorFechaHasta" class="text-danger small mt-1" style="display:none;"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" id="btnConfirmarReactivar">
                    <i class="bi bi-arrow-clockwise" aria-hidden="true"></i> Reactivar
                </button>
            </div>

        </div>
    </div>
</div>
<?php
if (isset($_GET['error'])) {
    if ($_GET['error'] == 'id_invalido') {
        echo "<div class='alert alert-danger text-center'>ID inválido.</div>";
    }
    if ($_GET['error'] == 'no_existe') {
        echo "<div class='alert alert-danger text-center'>La promoción no existe.</div>";
    }
    if ($_GET['error'] == 'no_eliminar') {
        echo "<div class='alert alert-warning text-center'>
                No se puede eliminar una promoción activa.
              </div>";
    }
    if ($_GET['error'] == 'db') {
        echo "<div class='alert alert-danger text-center'>Error en la base de datos.</div>";
    }
}

if (isset($_GET['ok']) && $_GET['ok'] == 'eliminada') {
    echo "<div class='alert alert-success text-center'>
            Promoción eliminada correctamente.
          </div>";
}
?>
<div class="container w-75 my-4">

    <div class="filtros-box">

        <div class="row align-items-end gy-2">

            <div class="col-lg-9 col-12">

                <label for="estado" class="form-label fw-semibold">
                    Promociones
                </label>

                <form class="d-flex" method="post" action="">
                    <?php
                    $estadoSeleccionado = $_POST['estado'] ?? 'todas';
                    ?>
                    <div class="input-group">

                       <select class="form-select" name="estado" id="estado" required>
                            <option value="todas" <?php if($estadoSeleccionado == 'todas') echo 'selected'; ?>>Todas</option>
                            <option value="pendiente" <?php if($estadoSeleccionado == 'pendiente') echo 'selected'; ?>>Pendientes</option>
                            <option value="activa" <?php if($estadoSeleccionado == 'activa') echo 'selected'; ?>>Activas</option>
                            <option value="rechazada" <?php if($estadoSeleccionado == 'rechazada') echo 'selected'; ?>>Rechazadas</option>
                            <option value="vencida" <?php if($estadoSeleccionado == 'vencida') echo 'selected'; ?>>Vencidas</option>
                        </select>

                        <button class="btn btn-primary" type="submit" aria-label="Filtrar promociones">
                            <i class="bi bi-search" aria-hidden="true"></i>
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
           WHERE l.id_usuario = $id_usuario
           AND p.estado != 'eliminada'";

$resultado = mysqli_query($conexion, $query1);

if ($resultado && mysqli_num_rows($resultado) > 0) {

if (!$resultado) {
    echo "<div class='alert alert-danger text-center'>
            Error en la consulta: " . mysqli_error($conexion) . "
          </div>";
    exit();
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
if($fila['estado']=="vencida") $estadoClase="estado-vencida";

echo "<tr>";

echo "<td>".$fila['nombre_local']."</td>";
echo "<td>".$fila['descripcion']."</td>";
echo "<td>".$fila['fecha_desde']."</td>";
echo "<td>".$fila['fecha_hasta']."</td>";
echo "<td>".$fila['categoria']."</td>";

$estiloInline = '';
if ($fila['estado'] == 'vencida') {
    $estiloInline = 'style="background-color:#fd7e14 !important; color:white !important;"';
}
echo "<td><span class='badge $estadoClase' $estiloInline>".$fila['estado']."</span></td>";

echo '<td class="d-flex gap-1">';

if ($fila['estado'] == 'vencida') {
    echo '<button class="btn btn-warning btn-sm"
         data-bs-toggle="modal"
         data-bs-target="#reactivarModal"
         data-id="' . $fila['id_promocion'] . '"
         title="Activar nuevamente"
         aria-label="Activar nuevamente promoción '.$fila['id_promocion'].'">
         <i class="bi bi-arrow-clockwise" aria-hidden="true"></i>
         <span class="visually-hidden">Activar nuevamente</span>
      </button>';
}

echo '<a href="#" class="btn btn-danger btn-sm"
    data-bs-toggle="modal"
    data-bs-target="#confirmDeleteModal"
    data-id="'.$fila['id_promocion'].'"
    aria-label="Eliminar promoción '.$fila['id_promocion'].'">
    <i class="bi bi-trash" aria-hidden="true"></i>
    <span class="visually-hidden">Eliminar promoción</span>
</a>';

echo '</td>';

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
if($fila['estado']=="vencida") $estadoClase="estado-vencida";

echo "<tr>";

echo "<td>".$fila['nombre_local']."</td>";
echo "<td>".$fila['descripcion']."</td>";
echo "<td>".$fila['fecha_desde']."</td>";
echo "<td>".$fila['fecha_hasta']."</td>";
echo "<td>".$fila['categoria']."</td>";

$estiloInline = '';
if ($fila['estado'] == 'vencida') {
    $estiloInline = 'style="background-color:#fd7e14 !important; color:white !important;"';
}
echo "<td><span class='badge $estadoClase' $estiloInline>".$fila['estado']."</span></td>";

echo '<td class="d-flex gap-1">';

if ($fila['estado'] == 'vencida') {
    echo '<button class="btn btn-warning btn-sm"
         data-bs-toggle="modal"
         data-bs-target="#reactivarModal"
         data-id="' . $fila['id_promocion'] . '"
         title="Activar nuevamente"
         aria-label="Activar nuevamente promoción '.$fila['id_promocion'].'">
         <i class="bi bi-arrow-clockwise" aria-hidden="true"></i>
         <span class="visually-hidden">Activar nuevamente</span>
      </button>';
}

echo '<a href="#" class="btn btn-danger btn-sm"
    data-bs-toggle="modal"
    data-bs-target="#confirmDeleteModal"
    data-id="'.$fila['id_promocion'].'"
    aria-label="Eliminar promoción '.$fila['id_promocion'].'">
    <i class="bi bi-trash" aria-hidden="true"></i>
    <span class="visually-hidden">Eliminar promoción</span>
</a>';

echo '</td>';

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
<script>
// Guarda el id de la promocion al abrir el modal
const reactivarModal = document.getElementById('reactivarModal');
let idPromoReactivar = null;

reactivarModal.addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;
    idPromoReactivar = button.getAttribute('data-id');

    // Limpia los campos y errores al abrir
    document.getElementById('nuevaFechaDesde').value = '';
    document.getElementById('nuevaFechaHasta').value = '';
    document.getElementById('errorFechaDesde').style.display = 'none';
    document.getElementById('errorFechaHasta').style.display = 'none';

    // Fecha mínima = hoy
    const hoy = new Date().toISOString().split('T')[0];
    document.getElementById('nuevaFechaDesde').min = hoy;
    document.getElementById('nuevaFechaHasta').min = hoy;
});

document.getElementById('btnConfirmarReactivar').addEventListener('click', function() {
    const fechaDesde = document.getElementById('nuevaFechaDesde').value;
    const fechaHasta = document.getElementById('nuevaFechaHasta').value;
    const hoy = new Date().toISOString().split('T')[0];

    let valido = true;

    // Validar fecha desde
    if (!fechaDesde) {
        document.getElementById('errorFechaDesde').textContent = 'Ingresá la fecha desde.';
        document.getElementById('errorFechaDesde').style.display = 'block';
        valido = false;
    } else if (fechaDesde < hoy) {
        document.getElementById('errorFechaDesde').textContent = 'La fecha desde no puede ser anterior a hoy.';
        document.getElementById('errorFechaDesde').style.display = 'block';
        valido = false;
    } else {
        document.getElementById('errorFechaDesde').style.display = 'none';
    }

    // Validar fecha hasta
    if (!fechaHasta) {
        document.getElementById('errorFechaHasta').textContent = 'Ingresá la fecha hasta.';
        document.getElementById('errorFechaHasta').style.display = 'block';
        valido = false;
    } else if (fechaHasta <= fechaDesde) {
        document.getElementById('errorFechaHasta').textContent = 'La fecha hasta debe ser mayor a la fecha desde.';
        document.getElementById('errorFechaHasta').style.display = 'block';
        valido = false;
    } else {
        document.getElementById('errorFechaHasta').style.display = 'none';
    }

    if (valido) {
        window.location.href = '../consultas/reactivarPromocion.php?id=' + idPromoReactivar
            + '&fecha_desde=' + fechaDesde
            + '&fecha_hasta=' + fechaHasta;
    }
});
</script>

</body>

</html>