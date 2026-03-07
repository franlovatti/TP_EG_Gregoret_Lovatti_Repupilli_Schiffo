<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SOLICITUDES DE PROMOS (DUEÑO)</title>
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


<?php
require_once '../conexion.php';
$query = "SELECT uso.id_uso, uso.id_cliente, uso.estado, uso.id_promocion, 
                  u.mail_usuario, p.descripcion
          FROM uso_promocion uso
          inner join usuario u on uso.id_cliente = u.id_usuario
          inner join promocion p on uso.id_promocion = p.id_promocion
           WHERE uso.estado = 'pendiente'";
$resultado = mysqli_query($conexion, $query);
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

echo "<table class='table table-bordered'>";
echo "<thead><tr><th>id_cliente</th><th>Email</th><th>id_promocion</th><th>Descripcion promo</th><th>Estado</th><th>Acciones</th></tr></thead>";
echo "<tbody>";

while ($fila = mysqli_fetch_assoc($resultado)) {
    echo "<tr>";
    echo "<td>" . $fila['id_cliente'] . "</td>";
    echo "<td>" . $fila['mail_usuario'] . "</td>";
    echo "<td>" . $fila['id_promocion'] . "</td>";
    echo "<td>" . $fila['descripcion'] . "</td>";
    echo "<td>" . $fila['estado'] . "</td>";
    echo "<td>
        <a href='../consultas/gestionarSolicitudPromoUsu.php?id_uso=".$fila['id_uso']."&accion=aceptar' 
        class='btn btn-success btn-sm'>
        Aceptar
        </a>

        <a href='../consultas/gestionarSolicitudPromoUsu.php?id_uso=".$fila['id_uso']."&accion=rechazar' 
        class='btn btn-danger btn-sm'>
        Rechazar
        </a>
      </td>";
    echo "</tr>";
}

echo "</tbody></table>";

mysqli_close($conexion);
?>
<footer class="footer mt-auto py-3 bg-body-tertiary">
  <?php include '../footer.php'; ?>
</footer>

<?php
if(isset($_GET['estado'])){
    include '../modals/modalEstadoSoliPromo.php';
}
?>
 <script>
  // Si viene el param estado muestra la modal
document.addEventListener('DOMContentLoaded', function () {
    var modal = new bootstrap.Modal(document.getElementById('estadoSoliPromo'));
    modal.show();
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>