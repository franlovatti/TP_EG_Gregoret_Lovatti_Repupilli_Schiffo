<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SOLICITUDES DE USUARIO (ADMINISTRADOR)</title>
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
$query = "SELECT * FROM usuario WHERE tipo_usuario = 'dueño'";
$resultado = mysqli_query($conexion, $query);
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

echo "<table class='table table-bordered'>";
echo "<thead><tr><th>id_dueño</th><th>Email</th><th>Estado</th><th>Acciones</th></tr></thead>";
echo "<tbody>";

while ($fila = mysqli_fetch_assoc($resultado)) {
    echo "<tr>";
    echo "<td>" . $fila['id_usuario'] . "</td>";
    echo "<td>" . $fila['mail_usuario'] . "</td>";
    echo "<td>" . $fila['estado'] . "</td>";
    echo '<td><a href="aprobarD.php?id=' . $fila['id_usuario'] . '" class="btn btn-success btn-sm">editar estado</a></td>';
    echo "</tr>";
}

echo "</tbody></table>";

mysqli_close($conexion);
?>
<footer class="footer mt-auto py-3 bg-body-tertiary">
  <?php include '../footer.php'; ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>