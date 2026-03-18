<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MIS PROMOCIONES (CLIENTES)</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>

  <style>
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

    .card{
      border-radius:12px;
    }

    .table thead{
      background-color:#212529;
      color:white;
    }
    .scroll-table {
  max-height: 450px;
  overflow-y: auto;
}
  </style>
</head>

<body class="d-flex flex-column min-vh-100">

<header class="p-3 text-bg-dark">
  <?php include '../header.php'; ?>
</header>

<?php
//CONSULTAS PARA ARMAR LA TABLA DE MIS PROMOCIONES
require_once '../conexion.php';
$id_usuario = $_SESSION['idUsuario'];

//ARMAS LA CONDICION DEL WHERE DEPENDIENDO SI HAY BUSQUEDA O FILTRO DE ESTADO
$where_clauses = array("up.id_cliente = $id_usuario");

if (isset($_POST["Buscar"]) && !empty(trim($_POST["Buscar"]))) {
    $search = mysqli_real_escape_string($conexion, trim($_POST["Buscar"]));
    $where_clauses[] = "p.descripcion LIKE '%$search%'";
}

if (isset($_POST["estado"]) && $_POST["estado"] != "todas" && !empty($_POST["estado"])) {
    $estado = mysqli_real_escape_string($conexion, $_POST["estado"]);
    $where_clauses[] = "up.estado = '$estado'";
}

$where = implode(" AND ", $where_clauses);

$query ="SELECT up.*, p.descripcion
        FROM uso_promocion up
        INNER JOIN promocion p on up.id_promocion = p.id_promocion
        WHERE $where";

$resultado = mysqli_query($conexion, $query);
?>

<div class="container mt-4">

  <div class="card shadow mb-4">
    <div class="card-body">

      <h3 class="mb-4">Mis promociones</h3>

      <!-- Buscador -->
      <div class="row g-2 mb-4">

        <div class="col-md-6">
          <form class="d-flex" method="post" action="">
            <div class="input-group">
              <input name="Buscar" type="text" class="form-control" placeholder="Buscar por promoción..." value="<?php echo isset($_POST['Buscar']) ? htmlspecialchars($_POST['Buscar']) : ''; ?>" />
              <button class="btn btn-primary">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </form>

          <?php if (isset($_POST["Buscar"]) && !empty(trim($_POST["Buscar"]))) { ?>
            <form method="post" action="">
              <button type="submit" class="btn btn-outline-primary mt-2">
                <i class="bi bi-arrow-left"></i> Mostrar todas
              </button>
            </form>
          <?php } ?>
        </div>

        <div class="col-md-3">
          <form method="post" action="">
            <select name="estado" class="form-select" onchange="this.form.submit()">
              <option value="todas" <?php echo (!isset($_POST['estado']) || $_POST['estado'] == 'todas') ? 'selected' : ''; ?>>Todas</option>
              <option value="aceptada" <?php echo (isset($_POST['estado']) && $_POST['estado'] == 'aceptada') ? 'selected' : ''; ?>>Aceptada</option>
              <option value="pendiente" <?php echo (isset($_POST['estado']) && $_POST['estado'] == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
              <option value="rechazada" <?php echo (isset($_POST['estado']) && $_POST['estado'] == 'rechazada') ? 'selected' : ''; ?>>Rechazada</option>
            </select>
          </form>
        </div>

      </div>

<?php
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

if(mysqli_num_rows($resultado) == 0){

    echo "<div class='alert alert-info text-center'>
              No hay promociones solicitadas.
          </div>";

} else {
    echo "<div class='scroll-table'>";
    echo "<table class='table table-hover table-bordered align-middle text-center'>";
    echo "<thead class='table-dark'>
            <tr>
              <th>Promoción</th>
              <th>Fecha aprobación</th>
              <th>Estado</th>
            </tr>
          </thead>";

    echo "<tbody>";

    while ($fila = mysqli_fetch_assoc($resultado)) {

        $estado = $fila['estado'];

        // Badge de estado (mejora visual)
        if($estado == "pendiente"){
            $badge = "<span class='badge bg-warning text-dark'>Pendiente</span>";
        } elseif($estado == "aceptada"){
            $badge = "<span class='badge bg-success'>Aceptada</span>";
        } elseif($estado == "rechazada"){
            $badge = "<span class='badge bg-danger'>Rechazada</span>";
        } else {
            $badge = "<span class='badge bg-secondary'>$estado</span>";
        }

        echo "<tr>";

        echo "<td>" . $fila['descripcion'] . "</td>";
        echo "<td>" . $fila['fecha_uso'] . "</td>";
        echo "<td>$badge</td>";

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

<footer class="footer mt-auto py-3 bg-body-tertiary">
  <?php include '../footer.php'; ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>