<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Local</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"/>
  <link rel="stylesheet" href="estilos/local/local.css"/>
  <link rel="stylesheet" href="estilos/global.css"/>
  
</head>

<body>

<header class="p-3 text-bg-dark">
  <?php include '../header.php'; ?>
</header>

<?php
//CONSULTA PARA MOSTRAR LOS LOCALES Y SUS PROMOCIONES ACTIVAS
include '../consultas/local.php';

//armo array de locales con sus promociones
$locales = [];

if ($resultado && mysqli_num_rows($resultado) > 0) {

  while ($fila = mysqli_fetch_assoc($resultado)) {

    $id_local = $fila['id_local'];

    if(!isset($locales[$id_local])){
      $locales[$id_local] = [
        'id_local' => $id_local,
        'nombre_local' => $fila['nombre_local'],
        'ubicacion' => $fila['ubicacion'],
        'rubro' => $fila['rubro'],
        'imagen_local' => $fila['imagen_local'],
        'promociones' => []
      ];
    }

    $locales[$id_local]['promociones'][] = [
      'descripcion' => $fila['descripcion'],
      'fecha_desde' => $fila['fecha_desde'],
      'fecha_hasta' => $fila['fecha_hasta'],
      'categoria' => $fila['categoria'],
      'imagen' => $fila['imagen_prom'] ?? null,
      'lunes' => $fila['lunes'],
      'martes' => $fila['martes'],
      'miercoles' => $fila['miercoles'],
      'jueves' => $fila['jueves'],
      'viernes' => $fila['viernes'],
      'sabado' => $fila['sabado'],
      'domingo' => $fila['domingo']
    ];
  }
}
?>

<div class="container py-4">

<h3 class="mb-4">Mis locales</h3>

<?php
if (!empty($locales)) {

  $local_keys = array_keys($locales);

  $selected_local_id = isset($_GET['local']) && isset($locales[$_GET['local']])
    ? $_GET['local']
    : $local_keys[0];

  $local_mostrar = $locales[$selected_local_id];

  // PAGINACION
  $cantPorPagina=4;
  $pagina=isset($_GET["pagina"]) ? $_GET["pagina"] : 1;
  $inicio=($pagina-1) * $cantPorPagina;

  $totalPromos = count($local_mostrar['promociones']);
  $promos_paginadas = array_slice($local_mostrar['promociones'], $inicio, $cantPorPagina);
  $totalPaginas = ceil($totalPromos / $cantPorPagina);
?>

<!-- selector local -->
<div class="row mb-3">
  <div class="col-md-4">
    <form method="get">
      <select name="local" class="form-select" onchange="this.form.submit()">
        <?php foreach ($locales as $id => $l): ?>
          <option value="<?=$id?>" <?=($id == $selected_local_id)?'selected':''?>>
            <?=htmlspecialchars($l['nombre_local'])?>
          </option>
        <?php endforeach; ?>
      </select>
    </form>
  </div>
</div>

<!-- card local -->
<div class="card mb-4">
  <div class="row g-0">

    <div class="col-md-3 p-2">
      <?php if (!empty($local_mostrar['imagen_local'])){
        $img = $local_mostrar['imagen_local'];
        $info = getimagesizefromstring($img);
        $mime = $info['mime'] ?? 'image/jpeg';
      ?>
        <img src="data:<?=$mime?>;base64,<?=base64_encode($img)?>" class="img-fluid rounded">
      <?php } else { ?>
        <img src="imagenes/placeholder.jpg" class="img-fluid rounded" alt="Local">
      <?php } ?>
    </div>

    <div class="col-md-9 d-flex align-items-center">
      <div class="card-body">
        <h5 class="card-title"><?=htmlspecialchars($local_mostrar['nombre_local'])?></h5>
        <p class="mb-1"><strong>Ubicación:</strong> <?=htmlspecialchars($local_mostrar['ubicacion'])?></p>
        <p class="mb-0"><strong>Rubro:</strong> <?=htmlspecialchars($local_mostrar['rubro'])?></p>
      </div>
    </div>

  </div>
</div>

<!-- PROMOS -->
<h4 class="mb-3">Promociones activas</h4>

<?php if (!empty($local_mostrar['promociones'])): ?>

<div class="row row-cols-1 row-cols-md-2 g-4">

<?php foreach ($promos_paginadas as $promo): ?>

<div class="col">
  <div class="card h-100">

    <!-- imagen promo -->
    <?php if (!empty($promo['imagen'])){ 
      $img = $promo['imagen'];
      $info = getimagesizefromstring($img);
      $mime = $info['mime'] ?? 'image/jpeg';
    ?>
      <img src="data:<?=$mime?>;base64,<?=base64_encode($img)?>" class="promo-img">
    <?php } else { ?>
      <img src="imagenes/placeholder.jpg" class="promo-img" alt="Promocion">
    <?php } ?>

    <div class="card-body">
      <h5 class="card-title"><?=htmlspecialchars($promo['descripcion'])?></h5>

      <p class="mb-1">
        <span class="badge badge-categoria">
          <?=htmlspecialchars($promo['categoria'])?>
        </span>
      </p>

      <p class="mb-0"><strong>Desde:</strong> <?=$promo['fecha_desde']?></p>
      <p class="mb-0"><strong>Hasta:</strong> <?=$promo['fecha_hasta']?></p>
      <p class="mb-0"><strong>Días:</strong> 
        <?php
          $dias = [];
          if($promo['lunes']) $dias[] = 'Lun';
          if($promo['martes']) $dias[] = 'Mar';
          if($promo['miercoles']) $dias[] = 'Mié';
          if($promo['jueves']) $dias[] = 'Jue';
          if($promo['viernes']) $dias[] = 'Vie';
          if($promo['sabado']) $dias[] = 'Sáb';
          if($promo['domingo']) $dias[] = 'Dom';
          echo implode(', ', $dias);
        ?>
    </div>

  </div>
</div>

<?php endforeach; ?>

</div>

<?php else: ?>

<div class="alert alert-info text-center my-5">
  No hay promociones activas para este local.
</div>

<?php endif; ?>

<!-- PAGINACION -->
<nav class="mt-4">
<ul class="pagination justify-content-center">

<li class="page-item <?=($pagina<=1)?'disabled':''?>">
  <a class="page-link" href="?pagina=<?=$pagina-1?>&local=<?=$selected_local_id?>">&laquo;</a>
</li>

<?php for ($i=1;$i<=$totalPaginas;$i++): ?>
<li class="page-item <?=($i==$pagina)?'active':''?>">
  <a class="page-link" href="?pagina=<?=$i?>&local=<?=$selected_local_id?>">
    <?=$i?>
  </a>
</li>
<?php endfor; ?>

<li class="page-item <?=($pagina>=$totalPaginas)?'disabled':''?>">
  <a class="page-link" href="?pagina=<?=$pagina+1?>&local=<?=$selected_local_id?>">&raquo;</a>
</li>

</ul>
</nav>

<?php
} else {
  echo "<div class='alert alert-info text-center my-5'>
          No se encontró ningún local asociado a tu cuenta.
        </div>";
}
?>

</div>

<footer class="footer mt-auto py-3 bg-body-tertiary">
  <?php include '../footer.php'; ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>