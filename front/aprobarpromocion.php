<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Solicitudes de Promociones (ADMINISTRADOR)</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link rel="stylesheet" href="estilos/global.css" />
</head>

<body class="d-flex flex-column min-vh-100">

<header class="p-3 text-bg-dark">
  <?php include '../header.php'; ?>
</header>

<!-- MODAL CONFIRMACION -->
<div class="modal fade" id="confirmModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar acción</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p id="textoModal"></p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a id="btnConfirmar" class="btn btn-primary">Confirmar</a>
      </div>
    </div>
  </div>
</div>

<!-- Barra de busqueda -->
<div class="container mt-4">
  <div class="card shadow mb-4">
    <div class="card-body">
      <h3 class="mb-4">Promociones pendientes</h3>
      
      <div class="col-lg-9 col-12 mb-4">
        <form class="d-flex" method="post" action="" role="search" aria-labelledby="searchFormLabel">
          <div class="input-group">
            <label id="searchFormLabel" for="buscarLocal" class="visually-hidden">Buscador de promociones por local</label>
            <input id="buscarLocal" name="Buscar" type="text" class="form-control" placeholder="Buscar por local" aria-describedby="searchHelp" />
            <button class="btn btn-primary" type="submit" aria-label="Buscar promociones">
              <i class="bi bi-search" aria-hidden="true"></i>
            </button>
          </div>
          <div id="searchHelp" class="visually-hidden">Ingrese el nombre del local y presione buscar.</div>
        </form>
        <?php if (isset($_POST["Buscar"]) && !empty(trim($_POST["Buscar"]))) { ?>
          <div class="mt-2">
            <form method="post" action="">
              <button type="submit" class="btn btn-outline-primary my-1">
                <i class="bi bi-arrow-left"></i> Mostrar todas
              </button>
            </form>
          </div>
        <?php } ?>
      </div>

<?php
require_once '../conexion.php';

// Construir la consulta base con JOIN
$query = "SELECT p.*, l.nombre_local 
          FROM promocion p
          INNER JOIN local l ON p.id_local = l.id_local
          WHERE p.estado = 'pendiente'";

// Si hay búsqueda, agregar filtro
if (isset($_POST["Buscar"]) && !empty(trim($_POST["Buscar"]))) {
    $busqueda = mysqli_real_escape_string($conexion, trim($_POST["Buscar"]));
    $query .= " AND l.nombre_local LIKE '%$busqueda%'";
}

$resultado = mysqli_query($conexion, $query);
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// Verificar si hay resultados
$hayResultados = mysqli_num_rows($resultado) > 0;

if ($hayResultados) {
  echo "<div class='table-responsive'>";
    echo "<table class='table table-hover table-bordered align-middle text-center'>";
    echo "<thead class='table-dark'>
            <tr>
              <th>Local</th>
              <th>Descripción</th>
              <th>Fecha desde</th>
              <th>Fecha hasta</th>
              <th>Categoría</th>
              <th>Acciones</th>
            </tr>
          </thead>";
    echo "<tbody>";

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $nombre_local = $fila['nombre_local'];

        echo "<tr>";
        echo "<td>$nombre_local</td>";
        echo "<td>" . htmlspecialchars($fila['descripcion']) . "</td>";
        echo "<td>" . htmlspecialchars($fila['fecha_desde']) . "</td>";
        echo "<td>" . htmlspecialchars($fila['fecha_hasta']) . "</td>";
        echo "<td>" . htmlspecialchars($fila['categoria']) . "</td>";
        echo "<td>
                <button class='btn btn-success btn-sm'
                        onclick=\"abrirModal(" . $fila['id_promocion'] . ",'" . addslashes($fila['descripcion']) . "', '" . addslashes($nombre_local) . "','activa')\">
                  Aceptar
                </button>
                <button class='btn btn-danger btn-sm'
                        onclick=\"abrirModal(" . $fila['id_promocion'] . ",'" . addslashes($fila['descripcion']) . "','" . addslashes($nombre_local) . "','rechazada')\">
                  Rechazar
                </button>
              </td>";
        echo "</tr>";
    }

    echo "</tbody></table>";
    echo "</div>";

} else {
    $mensaje = isset($_POST["Buscar"]) ? "No se encontraron promociones para el local buscado." : "No hay promociones pendientes.";
    echo "<div class='alert alert-info text-center'>
                $mensaje
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
//script para el modal de confirmacion
function abrirModal(idPromo, descrip, local, accion){
    let texto = "";
    if(accion === "activa"){
        texto = "¿Estás seguro de que querés APROBAR esta promocion: '" + descrip + "' del local: " + local + "?";
    } else {
        texto = "¿Estás seguro de que querés RECHAZAR esta promocion: '" + descrip + "' del local: " + local + "?";
    }

    document.getElementById("textoModal").innerText = texto;
    if(accion === "activa"){
        document.getElementById("btnConfirmar").href = "../consultas/aceptarpromocion.php?id=" + idPromo;
    } else {
        document.getElementById("btnConfirmar").href = "../consultas/rechazarpromocion.php?id=" + idPromo;
    }

    var modal = new bootstrap.Modal(document.getElementById('confirmModal'));
    modal.show();
}
</script>

</body>
</html>