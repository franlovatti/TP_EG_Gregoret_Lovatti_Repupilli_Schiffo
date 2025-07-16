<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Solicitudes de Promociones (ADMINISTRADOR)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <style>
    .scrollable-box {
      max-height: 400px;
      overflow-y: auto;
      border: 1px solid #ccc;
      padding: 10px;
    }
    footer {
      background-color: #f8f9fa;
      padding: 20px 0;
      text-align: center;
      font-size: 0.9rem;
    }
    .texto-destacado {
    color: #e91e63; 
    font-weight: bold;
    }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">

<header class="p-3 text-bg-dark">
  <?php include '../header.php'; ?>
</header>

<!-- Modal para ACEPTAR -->
<div class="modal fade" id="confirmAcceptModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content border-success">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Confirmar Aceptación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        ✅ ¿Seguro que deseas <span class="texto-destacado">ACEPTAR</span> esta promoción?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a id="confirmAcceptBtn" href="#" class="btn btn-success">Aceptar promoción</a>
      </div>
    </div>
  </div>
</div>



<!-- Modal para RECHAZAR -->
<div class="modal fade" id="confirmRejectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content border-danger">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Confirmar Rechazo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        ❌ ¿Seguro que deseas <span class="texto-destacado">RECHAZAR</span> esta promoción? Esta acción no se puede deshacer.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a id="confirmRejectBtn" href="#" class="btn btn-danger">Rechazar promoción</a>
      </div>
    </div>
  </div>
</div>
<!-- Barra de busqueda -->
  <div class="container w-75 my-4">
    <div class="row align-items-center gy-1">
      <div class="col-lg-9 col-12 ">
        <label> Promociones pendientes:</label>
        <form class="d-flex" method="post" action="">
          <div class="input-group">
            <input
              name="Buscar"
              type="number"
              class="form-control"
              placeholder="id del local..."
            />
            <button class="btn btn-primary" type="submit">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>


<?php
require_once '../conexion.php';
 

$query = "SELECT * FROM promocion where estado = 'pendiente'";
$resultado = mysqli_query($conexion, $query);
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}


if (isset($_POST["Buscar"])){
    while ($fila = mysqli_fetch_assoc($resultado)) {
        if($fila['id_local']==$_POST["Buscar"]){
            $id_local=$fila['id_local'];
            $query1 = "SELECT * from local WHERE id_local = $id_local";
            $resultado1 = mysqli_query($conexion, $query1);
            

            if ($resultado1 && mysqli_num_rows($resultado1) > 0) {
                $fila1 = mysqli_fetch_assoc($resultado1);
                $nombre_local=$fila1['nombre_local'];
            } else {
            echo "<div class='alert alert-info text-center my-5'>No se encontró ningún local asociado a tu cuenta.</div>";
            }

            if(!isset($bandera)){
                echo "<table class='table table-bordered'>";
                echo "<thead><tr><th>id_local</th><th>Nombre_local</th><th>Descripción</th><th>Fecha desde</th><th>Fecha hasta</th><th>Categoría</th></tr></thead>";
                echo "<tbody>";
            }
            echo "<tr>";
            echo "<td>" . $fila['id_local'] . "</td>";
            echo "<td> $nombre_local  </td>";
            echo "<td>" . $fila['descripcion'] . "</td>";
            echo "<td>" . $fila['fecha_desde'] . "</td>";
            echo "<td>" . $fila['fecha_hasta'] . "</td>";
            echo "<td>" . $fila['categoria'] . "</td>";
            echo '<td><a href="#" class="btn btn-success btn-sm" 
            data-bs-toggle="modal" 
            data-bs-target="#confirmAcceptModal" 
            data-id="' . $fila['id_promocion'] . '">Aceptar promoción</a></td>';
            echo '<td><a href="#" class="btn btn-danger btn-sm" 
            data-bs-toggle="modal" 
            data-bs-target="#confirmRejectModal" 
            data-id="' . $fila['id_promocion'] . '">Rechazar promoción</a></td>';;
            echo "</tr>";
            $bandera=1;
        }
    }
    echo "</tbody></table>";
    if(!isset($bandera)){
        echo "<p class='text-center text-danger mt-3'>NO HAY PROMOCION PARA ESE LOCAL</p>";
    }
}
else {
        echo "<table class='table table-bordered'>";
        echo "<thead><tr><th>id_local</th><th>Nombre_local</th><th>Descripción</th><th>Fecha desde</th><th>Fecha hasta</th><th>Categoría</th></tr></thead>";
        echo "<tbody>";
       while ($fila = mysqli_fetch_assoc($resultado)) {

        $id_local=$fila['id_local'];
            $query1 = "SELECT * from local WHERE id_local = $id_local";
            $resultado1 = mysqli_query($conexion, $query1);
            

            if ($resultado1 && mysqli_num_rows($resultado1) > 0) {
                $fila1 = mysqli_fetch_assoc($resultado1);
                $nombre_local=$fila1['nombre_local'];
            } else {
            echo "<div class='alert alert-info text-center my-5'>No se encontró ningún local asociado a tu cuenta.</div>";
            }


        echo "<tr>";
        echo "<td>" . $fila['id_local'] . "</td>";
        echo "<td> $nombre_local  </td>";
        echo "<td>" . $fila['descripcion'] . "</td>";
        echo "<td>" . $fila['fecha_desde'] . "</td>";
        echo "<td>" . $fila['fecha_hasta'] . "</td>";
        echo "<td>" . $fila['categoria'] . "</td>";
        echo '<td><a href="#" class="btn btn-success btn-sm" 
        data-bs-toggle="modal" 
        data-bs-target="#confirmAcceptModal" 
        data-id="' . $fila['id_promocion'] . '">Aceptar promoción</a></td>';
        echo '<td><a href="#" class="btn btn-danger btn-sm" 
        data-bs-toggle="modal" 
        data-bs-target="#confirmRejectModal" 
        data-id="' . $fila['id_promocion'] . '">Rechazar promoción</a></td>';;
        echo "</tr>";
    }
    echo "</tbody></table>";
} 
mysqli_close($conexion);
?>
<footer class="footer mt-auto py-3 bg-body-tertiary">
  <?php include '../footer.php'; ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Modal para aceptar (verde)
  const confirmAcceptModal = document.getElementById('confirmAcceptModal');
  confirmAcceptModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const idPromo = button.getAttribute('data-id');
    const confirmBtn = document.getElementById('confirmAcceptBtn');
    confirmBtn.href = 'aceptarpromocion.php?id=' + idPromo;
  });

  // Modal para rechazar (rojo)
  const confirmRejectModal = document.getElementById('confirmRejectModal');
  confirmRejectModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const idPromo = button.getAttribute('data-id');
    const confirmBtn = document.getElementById('confirmRejectBtn');
    confirmBtn.href = 'rechazarpromocion.php?id=' + idPromo;
  });
</script>
</body>
</html>