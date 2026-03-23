<?php include '../sesion.php'; ?>
<?php require_once '../conexion.php'; ?>

<?php

$categoria = $_SESSION['categoria'] ;

// aca es donde defino que novedades voy a traer de la bd segun la categoria del cliente
if ($categoria == 'premium') {
    $condicion = "tipo_usuario IN ('Inicial','Medium','Premium')";
} elseif ($categoria == 'medium') {
    $condicion = "tipo_usuario IN ('Inicial','Medium')";
} else {
    $condicion = "tipo_usuario = 'Inicial'";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Novedades</title>

 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>

  <style>
    body {
      background-color: #f8f9fa;
    }

    .card:hover {
      transform: translateY(-5px);
      transition: 0.3s;
    }
  </style>
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
          ORDER BY fecha_desde DESC";

$resultado = mysqli_query($conexion, $query);

if (!$resultado) {
    echo "<p class='text-danger text-center'>Error en la consulta</p>";
} else {

    if (mysqli_num_rows($resultado) == 0) {
        echo "<p class='text-center text-muted'>No hay novedades disponibles.</p>";
    }

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $tipo = strtolower(trim($fila['tipo_usuario']));
        
        $color = match($tipo) {
            'premium' => 'danger',
            'medium' => 'warning',
            'inicial'=>'primary',
            default => 'secondary'
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
        echo '<small class="text-muted">
                <i class="bi bi-calendar-event"></i> Desde: '
              . $fila['fecha_desde'] . 
              '</small><br>';

        echo '<small class="text-muted">
                <i class="bi bi-calendar-x"></i> Hasta: '
              . $fila['fecha_hasta'] . 
              '</small>';
        echo '</div>';

        echo '</div></div></div>';
    }
}

mysqli_close($conexion);
?>

  </div>
</div>
<footer class="mt-auto py-3 bg-body-tertiary text-center">
  <?php include '../footer.php'; ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>