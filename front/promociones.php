<?php include '../sesion.php'; ?>
<?php require_once '../filtroCategoriaPromociones.php'; ?>
<?php
$catalogoCategorias = [
  'inicial' => 'Inicial',
  'medium' => 'Medium',
  'premium' => 'Premium'
];

$categoriasPermitidasSesion = obtenerCategoriasPermitidasPorSesion();
$categoriasFiltroPermitidas = empty($categoriasPermitidasSesion)
  ? array_keys($catalogoCategorias)
  : $categoriasPermitidasSesion;

$categoriaSeleccionada = null;
if (isset($_GET['categoria']) && $_GET['categoria'] !== 'Categoria') {
  $categoriaSeleccionada = $_GET['categoria'];
}

if (
  $categoriaSeleccionada &&
  $categoriaSeleccionada !== 'todas' &&
  !in_array($categoriaSeleccionada, $categoriasFiltroPermitidas, true)
) {
  $categoriaSeleccionada = null;
}
?>
<!DOCTYPE html>
<!-- CORRECCIÓN 1: lang="en" → lang="es" -->
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- CORRECCIÓN 2: <title> movido antes de los <link> de CSS -->
  <title>Promociones</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    rel="stylesheet">
  <link rel="stylesheet" href="estilos/promocion/promociones.css">
  <link rel="stylesheet" href="estilos/global.css">

</head>
<body class="d-flex flex-column min-vh-100">
  <header class="p-3 text-bg-dark">
    <?php include '../header.php'; ?>
  </header>
  <!--Contenido principal-->
  <div class="container seccion-promos">
    <!-- Contenedor para barra busqueda y desplegable -->
    <div class="buscador-box mb-4">
    <div class="row align-items-center gy-1">
      <!-- Barra de busqueda -->
      <div class="col-lg-9 col-12 ">
        <!-- CORRECCIÓN 3: action="" eliminado de los 3 formularios -->
        <form class="d-flex" method="get">
          <label for="buscar" class="visually-hidden">Buscar promociones</label>
          <div class="input-group">
            <input
            name="Buscar"
            type="text"
              class="form-control"
              placeholder="Buscar"
              value="<?php echo isset($_GET['Buscar']) ? htmlspecialchars($_GET['Buscar']) : ''; ?>"
            >
            <button class="btn btn-primary" type="submit">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </form>
      </div>
      <!-- Desplegable de categorias -->
      <div class="col-12 col-lg-3">
        <form method="get">
          <?php if (isset($_GET['Buscar']) && trim($_GET['Buscar']) !== '') { ?>
            <input type="hidden" name="Buscar" value="<?php echo htmlspecialchars(trim($_GET['Buscar'])); ?>">
          <?php } ?>
          <select
            name="categoria"
            class="form-select"
            onchange="this.form.submit()"
          >
            <option value="todas" <?php echo $categoriaSeleccionada === null ? 'selected' : ''; ?>>Todas</option>
            <?php foreach ($categoriasFiltroPermitidas as $claveCategoria) { ?>
              <option value="<?php echo htmlspecialchars($claveCategoria); ?>" <?php echo $categoriaSeleccionada === $claveCategoria ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($catalogoCategorias[$claveCategoria]); ?>
              </option>
            <?php } ?>
            
          </select>
        </form>
      </div> <!--cierra desplegable de categorias-->
    </div> <!--Cierra fila de busqueda y desplegable-->
  </div> <!--Cierra contenedor de busqueda y desplegable-->
  </div> <!--Cierra contenido principal-->
  <!--Tarjetas-->
  <div class="container my-4">
    <?php
    // Para la paginacion
    $cantPorPagina = 9;
    $pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
    if ($pagina < 1) {
      $pagina = 1;
    }
    $inicio = ($pagina - 1) * $cantPorPagina;

    require_once '../conexion.php';
    global $conexion;
    global $recuperar_error;
    
    // Obtener el día de la semana actual (1=lunes, 7=domingo)
    $dia_semana_num = date('N');
    $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
    $dia_actual = $dias[$dia_semana_num - 1];
    
    // Verifica si ha enviado una busqueda
    $busqueda = '';
    if (isset($_GET['Buscar'])) {
        $busqueda = trim($_GET['Buscar']);
    }

    // Construye una unica consulta SQL (datos + total para paginacion)
    $query = "SELECT p.id_promocion, p.descripcion, p.fecha_desde, p.fecha_hasta, p.categoria,
                     p.lunes, p.martes, p.miercoles, p.jueves, p.viernes, p.sabado, p.domingo,
                     p.imagen_prom, loc.nombre_local, COUNT(*) OVER() AS total_registros
              FROM promocion p
              INNER JOIN local loc ON p.id_local = loc.id_local
              WHERE p.fecha_hasta >= CURDATE() AND p.fecha_desde <= CURDATE() AND p.estado = 'activa'
              AND p.$dia_actual = 1";

    $query .= obtenerFiltroSqlCategoriaPromocion('p');

    if ($categoriaSeleccionada && $categoriaSeleccionada != 'todas') {
      $query .= " AND p.categoria = '" . mysqli_real_escape_string($conexion, $categoriaSeleccionada) . "'";
    }

    if ($busqueda !== '') {
      $query .= " AND p.descripcion LIKE '%" . mysqli_real_escape_string($conexion, $busqueda) . "%'";
    }

    $query .= " ORDER BY p.fecha_desde DESC LIMIT $inicio, $cantPorPagina";

    $result = mysqli_query($conexion, $query) or die("Hubo un error con la transacción: " . mysqli_error($conexion));
    $totalRegistros = 0;
    if ($result && $result->num_rows > 0) {
      $primerRegistro = $result->fetch_assoc();
      $totalRegistros = (int) $primerRegistro['total_registros'];
      mysqli_data_seek($result, 0);
    }

    $totalPaginas = max(1, (int) ceil($totalRegistros / $cantPorPagina));

    if ($pagina > $totalPaginas) {
      $pagina = $totalPaginas;
    }

    if ($busqueda !== '') {
      ?>
      <!-- Boton que permite volver atras si hay una busqueda -->
      <div class="container py-3 d-flex justify-content-center">
        <a href="javascript:history.back()" class="btn btn-outline-primary">
        <i class="bi bi-arrow-left"></i> Regresar en la búsqueda
        </a>
      </div>
      <?php
    }

    $queryParams = [];
    if ($busqueda !== '') {
      $queryParams['Buscar'] = $busqueda;
    }
    if ($categoriaSeleccionada) {
      $queryParams['categoria'] = $categoriaSeleccionada;
    }
    ?>
   <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center">
    <?php
      if (!$result || $result->num_rows === 0) {
        echo "<div class='alert alert-warning text-center'>
                No hemos encontrado ninguna promoción que coincida con su búsqueda.
              </div>";
      } else {
        while ($row = $result->fetch_assoc()) {
          // Detecta tipo MIME para mostrar la imagen guardada en BLOB
          $imagenSrc = 'imagenes/placeholder.jpg';
          if (!empty($row['imagen_prom'])) {
            $mime = 'image/jpeg';
            if (class_exists('finfo')) {
              $finfo = new finfo(FILEINFO_MIME_TYPE);
              $mimeDetectado = $finfo->buffer($row['imagen_prom']);
              if (!empty($mimeDetectado)) {
                $mime = $mimeDetectado;
              }
            }
            $imagenSrc = "data:" . $mime . ";base64," . base64_encode($row['imagen_prom']);
          }
    ?>
          <!-- Tarjeta de promoción -->
      <div class="col d-flex justify-content-center align-items-stretch">
        <div class="card promo-card mb-3"
          data-bs-toggle="modal"
          data-bs-target="#promoModal"
          role="button"
          tabindex="0"
          aria-haspopup="dialog"
          aria-controls="promoModal"
          aria-label="Abrir detalle de promoción de <?php echo htmlspecialchars($row['nombre_local']); ?>"
          data-nombre="<?php echo htmlspecialchars($row['nombre_local']); ?>"
          data-id-promocion="<?php echo $row['id_promocion']; ?>"
          data-categoria="<?php echo htmlspecialchars($row['categoria']); ?>"
          data-descripcion="<?php echo htmlspecialchars($row['descripcion']); ?>"
          data-fecha-desde="<?php echo htmlspecialchars($row['fecha_desde']); ?>"
          data-fecha-hasta="<?php echo htmlspecialchars($row['fecha_hasta']); ?>"
          data-imagen="<?php echo htmlspecialchars($imagenSrc); ?>"
          data-lunes="<?php echo $row['lunes'] ? 'Lunes' : ''; ?>"
          data-martes="<?php echo $row['martes'] ? 'Martes' : ''; ?>"
          data-miercoles="<?php echo $row['miercoles'] ? 'Miércoles' : ''; ?>"
          data-jueves="<?php echo $row['jueves'] ? 'Jueves' : ''; ?>"
          data-viernes="<?php echo $row['viernes'] ? 'Viernes' :  ''; ?>"
          data-sabado="<?php echo $row['sabado'] ? 'Sábado' : ''; ?>"
          data-domingo="<?php echo $row['domingo'] ? 'Domingo' : ''; ?>"
         >
          <img src="<?php echo htmlspecialchars($imagenSrc); ?>" class="card-img-top card-img-custom" alt="Promoción">
            <span class="visually-hidden">Imagen de la promoción</span>
          </img>
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between mb-2">
              <h4 class="mb-0"><?php echo htmlspecialchars($row['nombre_local']); ?></h4>
              <?php
            $colorCategoria = match($row['categoria']) {
               'premium' => 'danger',
                'medium'  => 'warning',
                'inicial' => 'primary',
               default   => 'secondary'
                };
                ?>
<span class="badge bg-<?php echo $colorCategoria; ?> ms-2">
    <?php echo ucfirst($row['categoria']); ?>
</span>
            </div>
            <h5><?php echo htmlspecialchars($row['descripcion']); ?></h5>
            <p>Fecha desde: <?php echo htmlspecialchars($row['fecha_desde']); ?></p>
            <p>Fecha hasta: <?php echo htmlspecialchars($row['fecha_hasta']); ?></p>
          </div>
        </div>
      </div>
      <?php
        }
      }

      if ($result) {
        mysqli_free_result($result);
      }
      mysqli_close($conexion);
      ?>
  </div> <!--Cierra fila de tarjetas-->
  </div> <!--Cierra contenedor de tarjetas-->

  <?php
  $paginaAnterior = $pagina > 1 ? $pagina - 1 : 1;
  $paginaSiguiente = $pagina < $totalPaginas ? $pagina + 1 : $totalPaginas;

  $paramsPrev = array_merge($queryParams, ['pagina' => $paginaAnterior]);
  $paramsNext = array_merge($queryParams, ['pagina' => $paginaSiguiente]);
  ?>
  <!--Paginacion-->
  <nav aria-label="Navegación de páginas">
    <ul class="pagination justify-content-center">
      <li class="page-item <?php echo $pagina == 1 ? 'disabled' : ''; ?>">
        <a class="page-link" href="promociones.php?<?php echo http_build_query($paramsPrev); ?>" aria-label="Página anterior">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <?php for ($j = 1; $j <= $totalPaginas; $j++) {
        $paramsPagina = array_merge($queryParams, ['pagina' => $j]);
      ?>
            <li class="page-item <?php echo $j == $pagina ? 'active' : ''; ?>">
              <a class="page-link" href="promociones.php?<?php echo http_build_query($paramsPagina); ?>" aria-label="Ir a página <?php echo $j; ?>" <?php echo $j == $pagina ? 'aria-current="page"' : ''; ?>><?php echo $j; ?></a>
            </li>
        <?php } ?>
      <li class="page-item <?php echo $pagina == $totalPaginas ? 'disabled' : ''; ?>">
        <a class="page-link" href="promociones.php?<?php echo http_build_query($paramsNext); ?>" aria-label="Página siguiente">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>
  <!--Footer-->
  <footer class="footer mt-auto py-3 bg-body-tertiary">
    <?php include '../footer.php'; ?>
  </footer>

  <!-- Scripts al final -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  
  <!-- Script para cerrar menú al hacer clic en un link -->
  <script>
    document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
      link.addEventListener('click', () => {
        const navbarCollapse = document.querySelector('.navbar-collapse');
        if (navbarCollapse.classList.contains('show')) {
          new bootstrap.Collapse(navbarCollapse).toggle();
        }
      });
    });
  </script>
  <!-- Modal de Login -->
  <?php include '../modals/modalLogin.php'; ?>
  <!-- Modal de Registro -->
  <?php include '../modals/modalSignUp.php'; ?>
  <!-- Modal de Registro Dueño -->
  <?php include '../modals/modalSignUpD.php'; ?>
  <!-- Modal de Recuperar Contraseña -->
  <?php include '../modals/modalRecuperar.php'; ?>
  <!--Modal de promociones-->
  <?php include '../modals/modalPromocion.php'; ?>
  <!-- script login -->
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
          var modalId = <?php echo json_encode($signUp_modal ?? 'registroModal'); ?>;
          var modalElement = document.getElementById(modalId);
          if (!modalElement) {
            modalElement = document.getElementById('registroModal');
          }
          var modal = new bootstrap.Modal(modalElement);
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

    document.querySelectorAll('.promo-card[data-bs-target="#promoModal"]').forEach(function(card){
      card.addEventListener('keydown', function (event) {
        if (event.key === 'Enter' || event.key === ' ') {
          event.preventDefault();
          card.click();
        }
      });
    });
  });
  </script>
  <?php
  if(isset($_GET['promo']) && $_GET['promo'] == 'ok'){
    include "../modals/modalAprovecharPromo.php";
  }
  if(isset($_GET['promo']) && $_GET['promo'] == 'solicitada'){
    include "../modals/modalYaSolicitada.php";
  }

  $modalPromoId = '';
  if (isset($_GET['promo']) && $_GET['promo'] == 'ok') {
    $modalPromoId = 'confirmarModal';
  } elseif (isset($_GET['promo']) && $_GET['promo'] == 'solicitada') {
    $modalPromoId = 'promoYaSolicitadaModal';
  }
    ?>
 <script>
  document.addEventListener('DOMContentLoaded', function () {
    var modalId = <?php echo json_encode($modalPromoId); ?>;
    if (!modalId) {
      return;
    }

    var modalEl = document.getElementById(modalId);
    if (!modalEl) {
      return;
    }

    var modal = new bootstrap.Modal(modalEl);
    modal.show();
});
</script>
</body>
</html>