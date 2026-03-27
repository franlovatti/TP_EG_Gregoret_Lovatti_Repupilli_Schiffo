<?php include '../sesion.php'; ?>
<?php require_once '../filtroCategoriaPromociones.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Local</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"/>
  <link rel="stylesheet" href="estilos/local/localEspecifico.css">
  <link rel="stylesheet" href="estilos/global.css">
</head>
<body>
<header class="p-3 text-bg-dark">
  <?php include '../header.php'; ?>
</header>

<?php
//Para la paginacion
$cantPorPagina=8;
$pagina=isset($_GET["pagina"])?$_GET["pagina"]:null; //el get este se toma de la url que arma la paginacion al final del archivo
if(!$pagina){
  $inicio=0;
  $pagina=1;
}
else{
  $inicio=($pagina-1) * $cantPorPagina;
}
require_once '../conexion.php';
if(isset($_GET['id_local'])){
  $id_local = $_GET['id_local'];
}
$query = "SELECT loc.id_local, loc.nombre_local, loc.ubicacion, loc.rubro, loc.imagen_local,
		    p.id_promocion, p.descripcion, p.fecha_desde, p.fecha_hasta, p.categoria, 
        p.lunes, p.martes, p.miercoles, p.jueves, p.viernes, p.sabado, p.domingo,
        p.imagen_prom
        from local loc 
  LEFT JOIN promocion p on loc.id_local = p.id_local and p.fecha_hasta >= CURDATE() AND p.fecha_desde <= CURDATE() AND p.estado = 'activa'";
$query .= obtenerFiltroSqlCategoriaPromocion('p');
$query .= " WHERE loc.id_local = '$id_local'";
$resultado = mysqli_query($conexion, $query) or die("Error en la consulta: " . mysqli_error($conexion));
//para la paginacion
$totalRegistros=mysqli_num_rows($resultado); 
$totalPaginas=ceil($totalRegistros/$cantPorPagina);

// Traigo la única fila (o la primera de varias)
$fila = mysqli_fetch_assoc($resultado);
$localExiste = false;
if ($resultado && mysqli_num_rows($resultado) > 0) {
  $localExiste = true;
  $imagenLocalSrc = 'imagenes/placeholder.jpg';
  if (!empty($fila['imagen_local'])) {
    $mimeLocal = 'image/jpeg';
    if (class_exists('finfo')) {
      $finfo = new finfo(FILEINFO_MIME_TYPE);
      $mimeDetectado = $finfo->buffer($fila['imagen_local']);
      if (!empty($mimeDetectado)) {
        $mimeLocal = $mimeDetectado;
      }
    }
    $imagenLocalSrc = "data:" . $mimeLocal . ";base64," . base64_encode($fila['imagen_local']);
  }
  $imagenPromSrc = 'imagenes/placeholder.jpg';
  if (!empty($fila['imagen_prom'])) {
    $mimePromo = 'image/jpeg';
    if (class_exists('finfo')) {
      $finfo = new finfo(FILEINFO_MIME_TYPE);
      $mimeDetectado = $finfo->buffer($fila['imagen_prom']);
      if (!empty($mimeDetectado)) {
        $mimePromo = $mimeDetectado;
      }
    }
    $imagenPromSrc = "data:" . $mimePromo . ";base64," . base64_encode($fila['imagen_prom']);
  }
    ?>
    <div class="container py-3">
      <a href="javascript:history.back()" class="btn btn-outline-primary mb-3">
      <i class="bi bi-arrow-left"></i> Volver
      </a>
      <div class="row">
        <div class="col-12">
          <div class="card shadow border-0 my-3">
            <div class="row g-0 flex-column flex-md-row">
              <!-- Imagen a la izquierda -->
              <div class="col-12 col-md-2 d-flex justify-content-center justify-content-md-start align-items-center p-2">
                <img src="<?php echo $imagenLocalSrc; ?>" class="img-fluid rounded" alt="Logo del local">
              </div>

              <!-- Texto a la derecha -->
              <div class="col-md-10 d-flex align-items-center">
                <div class="card-body">
                  <h5 class="card-title mb-1"><?= htmlspecialchars($fila['nombre_local']) ?></h5>
                  <p class="card-text mb-0">Nro Local: <?= htmlspecialchars($fila['id_local']) ?></p>
                  <p class="card-text mb-0">Ubicación: <?= htmlspecialchars($fila['ubicacion']) ?></p>
                  <p class="card-text mb-3">Rubro: <?= htmlspecialchars($fila['rubro']) ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php
} else{
  echo '<div class="container">
        <div class="alert alert-danger" role="alert">No se encontraron resultados para el local especificado.Intente mas tarde</div>
        </div>';
}

if($localExiste && $fila['descripcion'] == null){
  echo '<div class="container">
  <div class="alert alert-danger" role="alert">No se encontraron promociones para este local</div>
  </div>';
}elseif($localExiste){
  ?>
  <!-- Abre fila de promociones -->
  <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4 align-items-stretch">
  <?php
  $query = "SELECT loc.id_local, loc.nombre_local, loc.ubicacion, loc.rubro, loc.imagen_local,
		    p.id_promocion, p.descripcion, p.fecha_desde, p.fecha_hasta, p.categoria, 
        p.lunes, p.martes, p.miercoles, p.jueves, p.viernes, p.sabado, p.domingo,
        p.imagen_prom
        from local loc 
        LEFT JOIN promocion p on loc.id_local = p.id_local
      WHERE loc.id_local = '$id_local' and p.fecha_hasta >= CURDATE() AND p.fecha_desde <= CURDATE() AND p.estado = 'activa'";
    $query .= obtenerFiltroSqlCategoriaPromocion('p');
    $query .= " LIMIT $inicio, $cantPorPagina";
  $resultado = mysqli_query($conexion, $query) or die("Error en la consulta: " . mysqli_error($conexion));
  while($fila = $resultado->fetch_assoc()){
    $imagenSrc = 'imagenes/placeholder.jpg';
    if (!empty($fila['imagen_prom'])) {
      $mime = 'image/jpeg';
      if (class_exists('finfo')) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeDetectado = $finfo->buffer($fila['imagen_prom']);
        if (!empty($mimeDetectado)) {
          $mime = $mimeDetectado;
        }
      }
      $imagenSrc = "data:" . $mime . ";base64," . base64_encode($fila['imagen_prom']);
    }
    ?>
        <!--Necesitamos la card dentro de una col para que ande el modal-->
        <div class="col d-flex justify-content-center align-items-stretch">
          <!-- Tarjeta de promoción -->
          <div class="card promo-card mb-3"
            data-bs-toggle="modal"
            data-bs-target="#promoModal"
            data-nombre="<?php echo htmlspecialchars($fila['nombre_local']); ?>"
            data-id-promocion="<?php echo $fila['id_promocion']; ?>"
            data-descripcion="<?php echo htmlspecialchars($fila['descripcion']); ?>"
            data-fecha-desde="<?php echo htmlspecialchars($fila['fecha_desde']); ?>"
            data-fecha-hasta="<?php echo htmlspecialchars($fila['fecha_hasta']); ?>"
            data-imagen="<?php echo htmlspecialchars($imagenSrc); ?>"
            data-lunes="<?php echo $fila['lunes'] ? 'Lunes' : ''; ?>"
            data-martes="<?php echo $fila['martes'] ? 'Martes' : ''; ?>"
            data-miercoles="<?php echo $fila['miercoles'] ? 'Miércoles' : ''; ?>"
            data-jueves="<?php echo $fila['jueves'] ? 'Jueves' : ''; ?>"
            data-viernes="<?php echo $fila['viernes'] ? 'Viernes' :  ''; ?>"
            data-sabado="<?php echo $fila['sabado'] ? 'Sábado' : ''; ?>"
            data-domingo="<?php echo $fila['domingo'] ? 'Domingo' : ''; ?>"
            style="cursor:pointer;">
            <img src="<?php echo htmlspecialchars($imagenSrc); ?>" class="card-img-top card-img-custom" alt="Promoción">
            <div class="card-body">
              <div class="d-flex align-items-start justify-content-between mb-2">
                <h5 class="mb-0"><?php echo htmlspecialchars($fila['descripcion']); ?></h5>
                <?php
                $estrellas = '';
                if ($fila['categoria'] == 'inicial') {
                    $estrellas = '★';
                } elseif ($fila['categoria'] == 'medium') {
                    $estrellas = '★★';
                } elseif ($fila['categoria'] == 'premium') {
                    $estrellas = '★★★';
                }
                ?>
                <span class="badge bg-warning text-dark ms-2"><?php echo $estrellas; ?></span>
              </div>
              <p>Fecha desde: <?php echo htmlspecialchars($fila['fecha_desde']); ?></p>
              <p>Fecha hasta: <?php echo htmlspecialchars($fila['fecha_hasta']); ?></p>
            </div> <!-- Cierra card-body -->
          </div> <!-- Cierra card -->
        </div> <!-- Cierra col --> 
     <?php 
        } //cierra while tarjetas
     } //cierra else del if fila['descripcion'] == null
     mysqli_free_result($resultado);
     mysqli_close($conexion);
     ?>
    </div> <!-- Cierra row -->
  </div> <!-- Cierra container -->
  
  <?php
  $paginaAnterior = $pagina > 1 ? $pagina - 1 : 1;
  $paginaSiguiente = $pagina < $totalPaginas ? $pagina + 1 : $totalPaginas;
  ?>
  <!--Paginacion-->
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
      <li class="page-item <?php echo $pagina == 1 ? 'disabled' : ''; ?>">
        <a class="page-link" href="localEspecifico.php?pagina=<?php echo $paginaAnterior; ?>&id_local=<?php echo urlencode($id_local);?>" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <?php for($j = 1; $j <= $totalPaginas; $j++) { ?>
            <li class="page-item <?php echo $j == $pagina ? 'active' : ''; ?>">  
              <a class="page-link" href="localEspecifico.php?pagina=<?php echo $j; ?>&id_local=<?php echo urlencode($id_local); ?>"><?php echo $j; ?></a>
            </li>
        <?php } ?>
      <li class="page-item <?php echo $pagina == $totalPaginas ? 'disabled' : ''; ?>">
        <a class="page-link" href="localEspecifico.php?pagina=<?php echo $paginaSiguiente; ?>&id_local=<?php echo urlencode($id_local); ?>" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>

  <footer class="footer mt-auto py-3 bg-body-tertiary">
    <?php include '../footer.php'; ?>
  </footer>

  <!-- Modal de Login -->
  <?php include '../modals/modalLogin.php'; ?>
  <!-- Modal de Registro -->
  <?php include '../modals/modalSignUp.php'; ?>
  <!-- Modal de Registro -->
  <?php include '../modals/modalSignUpD.php'; ?>
  <!-- Modal de Recuperar Contraseña -->
  <?php include '../modals/modalRecuperar.php'; ?>
  <?php include '../modals/modalPromocion.php';?>

  <!-- Scripts al final -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  
  <!-- sript login -->
  <?php if (!empty($login_error)){?>
  <script>
      document.addEventListener('DOMContentLoaded', function () {
          var modal = new bootstrap.Modal(document.getElementById('loginModal'));
          modal.show();
      });
  </script>
  <?php }; ?>
  <!-- script signUp -->
  <?php if (!empty($signUp_error)){?>
  <script>
      document.addEventListener('DOMContentLoaded', function () {
          var modal = new bootstrap.Modal(document.getElementById('registroModal'));
          modal.show();
      });
  </script>
  <?php }; ?>
  <!-- script recuperar_contrasena -->
  <?php if (isset($_GET['recuperar']) || !empty($recuperar)){?>
  <script>
      document.addEventListener('DOMContentLoaded', function () {
          var modal = new bootstrap.Modal(document.getElementById('recuperarModal'));
          modal.show();
      });
  </script>
  <?php }; ?>
   <!-- script Modal promociones -->
  <script>
  document.addEventListener('DOMContentLoaded', function () {
    var promoModal = document.getElementById('promoModal');
    promoModal.addEventListener('show.bs.modal', function (event) {
      var card = event.relatedTarget;
       if (!card) return;
      document.getElementById('promoModalLabel').textContent = card.getAttribute('data-nombre');
      document.getElementById('promoModalImg').src = card.getAttribute('data-imagen');
      document.getElementById('promoModalIdPromo').value = card.getAttribute('data-id-promocion');
      document.getElementById('promoModalDesc').textContent = card.getAttribute('data-descripcion');
      document.getElementById('promoModalDesde').textContent = card.getAttribute('data-fecha-desde');
      document.getElementById('promoModalHasta').textContent = card.getAttribute('data-fecha-hasta');
      const dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo']
      .map(dia => card.getAttribute('data-' + dia))
      .filter(Boolean)
      .join(', ');
      document.getElementById('promoModalDias').textContent = dias;
    });
  });
  </script>
</body>
</html>