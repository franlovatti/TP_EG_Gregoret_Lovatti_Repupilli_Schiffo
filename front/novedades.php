<?php include '../sesion.php'; ?>
<?php require_once '../conexion.php'; ?>

<?php
$categoria = $_SESSION['categoria'];

if ($categoria == 'premium') {
    $condicion = "tipo_usuario IN ('Inicial','Medium','Premium')";
} elseif ($categoria == 'medium') {
    $condicion = "tipo_usuario IN ('Inicial','Medium')";
} else {
    $condicion = "tipo_usuario = 'Inicial'";
}


$cantPorPagina = 6;
$pagina = isset($_GET["pagina"]) ? (int)$_GET["pagina"] : 1;
$inicio = ($pagina - 1) * $cantPorPagina;


$queryTotal = "SELECT COUNT(*) as total FROM novedad
               WHERE estado = 'activo'
               AND CURDATE() BETWEEN fecha_desde AND fecha_hasta
               AND $condicion";
$resultadoTotal = mysqli_query($conexion, $queryTotal);
$filaTotal = mysqli_fetch_assoc($resultadoTotal);
$totalRegistros = $filaTotal['total'];
$totalPaginas = ceil($totalRegistros / $cantPorPagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Novedades</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link rel="stylesheet" href="estilos/global.css" />
</head>

<body class="d-flex flex-column min-vh-100">

<header class="p-3 text-bg-dark">
  <?php include '../header.php'; ?>
</header>

<div class="container my-5">

  <h2 class="mb-4 text-center">Novedades</h2>

  <div class="row">

<?php
$query = "SELECT * FROM novedad
          WHERE estado = 'activo'
          AND CURDATE() BETWEEN fecha_desde AND fecha_hasta
          AND $condicion
          ORDER BY fecha_desde DESC
          LIMIT $inicio, $cantPorPagina";

$resultado = mysqli_query($conexion, $query);

if (!$resultado) {
    echo "<p class='text-danger text-center'>Error en la consulta</p>";
} else {
    if ($totalRegistros == 0) {
        echo "<p class='text-center text-muted'>No hay novedades disponibles.</p>";
    }

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $tipo = strtolower(trim($fila['tipo_usuario']));

        $color = match($tipo) {
            'premium' => 'danger',
            'medium'  => 'warning',
            'inicial' => 'primary',
            default   => 'secondary'
        };

        echo '<div class="col-md-6 col-lg-4 mb-4">';
        echo '<div class="card shadow h-100 border-0">';
        echo '<div class="card-body d-flex flex-column">';
        echo '<span class="badge bg-' . $color . ' mb-2 align-self-start">'
              . ucfirst($fila['tipo_usuario']) .
             '</span>';
        echo '<p class="card-text fs-5 fw-semibold mb-3">'
              . $fila['descripcion_novedad'] .
             '</p>';
        echo '<div class="mt-auto">';
        echo '<small class="text-muted"><i class="bi bi-calendar-event"></i> Desde: '
              . $fila['fecha_desde'] . '</small><br>';
        echo '<small class="text-muted"><i class="bi bi-calendar-x"></i> Hasta: '
              . $fila['fecha_hasta'] . '</small>';
        echo '</div>';
        echo '</div></div></div>';
    }
}

mysqli_close($conexion);
?>

  </div>

  <!-- para la paginaciónn -->
  <?php
  $paginaAnterior = $pagina > 1 ? $pagina - 1 : 1;
  $paginaSiguiente = $pagina < $totalPaginas ? $pagina + 1 : $totalPaginas;
  ?>
  <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">

      <li class="page-item <?php echo $pagina == 1 ? 'disabled' : ''; ?>">
        <a class="page-link" href="novedades.php?pagina=<?php echo $paginaAnterior; ?>" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>

      <?php for ($j = 1; $j <= $totalPaginas; $j++) { ?>
        <li class="page-item <?php echo $j == $pagina ? 'active' : ''; ?>">
          <a class="page-link" href="novedades.php?pagina=<?php echo $j; ?>"><?php echo $j; ?></a>
        </li>
      <?php } ?>

      <li class="page-item <?php echo $pagina == $totalPaginas ? 'disabled' : ''; ?>">
        <a class="page-link" href="novedades.php?pagina=<?php echo $paginaSiguiente; ?>" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>

    </ul>
  </nav>

</div>

<footer class="mt-auto py-3 bg-body-tertiary text-center">
  <?php include '../footer.php'; ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>