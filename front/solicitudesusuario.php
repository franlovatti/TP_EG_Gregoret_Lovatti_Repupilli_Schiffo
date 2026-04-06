<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SOLICITUDES DE USUARIO (ADMINISTRADOR)</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
<link rel="stylesheet" href="estilos/global.css" />
</head>

<body class="d-flex flex-column min-vh-100">

<header class="p-3 text-bg-dark">
  <?php include '../header.php'; ?>
</header>


<div class="container mt-5 mb-5">

  <div class="card shadow">

    <div class="card-body">

      <h3 class="mb-4">
        Solicitudes de usuario pendientes
      </h3>

<?php
require_once '../conexion.php';

$query = "SELECT * FROM usuario WHERE tipo_usuario = 'dueño' and estado = 'pendiente'";
$resultado = mysqli_query($conexion, $query);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

if( mysqli_num_rows($resultado) == 0){
    echo "<div class='alert alert-info text-center'>
              No hay solicitudes de usuarios pendientes.
            </div>";} 
else {

echo "<div class='table-responsive'>";
echo "<table class='table table-hover table-bordered align-middle text-center'>";
echo "<thead class='table-dark'>
        <tr>
          <th>Email dueño</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>";

echo "<tbody>";

while ($fila = mysqli_fetch_assoc($resultado)) {

    $estado = $fila['estado'];

    if($estado == "pendiente"){
        $badge = "<span class='badge bg-warning text-dark'>Pendiente</span>";
    }

    echo "<tr>";

    echo "<td>" . $fila['mail_usuario'] . "</td>";

    echo "<td>$badge</td>";

    echo "<td>

            <button 
            class='btn btn-success btn-sm'
            onclick=\"abrirModal(".$fila['id_usuario'].",'".$fila['mail_usuario']."','activo')\">
            Aprobar
            </button>

            <button 
            class='btn btn-danger btn-sm'
            onclick=\"abrirModal(".$fila['id_usuario'].",'".$fila['mail_usuario']."','rechazar')\">
            Rechazar
            </button>

          </td>";

    echo "</tr>";
}

echo "</tbody>";
echo "</table>";
echo "</div>";
}
mysqli_close($conexion);
?>

    </div>
  </div>
</div>


<!-- MODAL CONFIRMACION -->

<div class="modal fade" id="modalConfirmacion" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Confirmar acción</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        <span class="visually-hidden">Cerrar</span>
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


<footer class="footer mt-auto py-3 bg-body-tertiary">
  <?php include '../footer.php'; ?>
</footer>


<script>

function abrirModal(idUsuario, mail, accion){

    let texto = "";
    
    if(accion === "activo"){
        texto = "¿Estás seguro de que querés APROBAR este usuario: " + mail + "?";
    }else{
        texto = "¿Estás seguro de que querés RECHAZAR este usuario: " + mail + "?";
    }

    document.getElementById("textoModal").innerText = texto;

    document.getElementById("btnConfirmar").href =
        "../consultas/gestionarCuenta.php?id_usuario=" + idUsuario + "&accion=" + accion;

    var modal = new bootstrap.Modal(document.getElementById('modalConfirmacion'));
    modal.show();
}

</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>