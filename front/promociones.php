<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Promociones</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    rel="stylesheet"
  />
  <style>
    .pagination .page-link {
    color: #000 !important;
    }
    .pagination .page-link:focus, .pagination .page-link:hover {
    color: #fff !important;
    background-color: #0d6efd !important; /* azul Bootstrap */
    border-color: #0d6efd !important;
    }
    .pagination .active .page-link {
    color: #fff !important;
    background-color: #0d6efd !important;
    border-color: #0d6efd !important;
    }
    .card:hover {
    background-color: #e3f2fd; /* Azul claro, podés cambiarlo por el color que prefieras */
    transition: background-color 0.3s;
    cursor: pointer;
    }
    .card{
      height: 260px; /* Ajusta la altura máxima de la tarjeta */
      width: 340px; /* Ajusta el ancho máximo de la tarjeta */
      /*min-width: 340px;*/
      max-width: 340px;
    }
    .card-img-custom {
    height: 130px;      /* Cambia el valor según lo que necesites */
    width: 100%;
    object-fit: cover;      /* Recorta la imagen para llenar el área */
    object-position: center;/* Centra el recorte */
    }
  </style>
  <title>Document</title>
</head>
<body>
  <header class="p-3 text-bg-dark">
    <?php include '../header.php'; ?>
  </header>
  <!--Contenido principal-->
  <div class="my-4 container-fluid d-flex justify-content-center align-items-center">
    <!-- Contenedor para barra busqueda y desplegable -->
    <div class="container w-75 my-4">
    <div class="row align-items-center gy-1">
      <!-- Barra de busqueda -->
      <div class="col-lg-9 col-12 ">
        <form class="d-flex" method="get" action="">
          <div class="input-group">
            <input
              name="Buscar"
              type="text"
              class="form-control"
              placeholder="Buscar"
            />
            <button class="btn btn-primary" type="submit">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </form>
      </div>
      <!-- Desplegable de categorias -->
      <div class="col-12 col-lg-3">
        <form method="get" action="">
          <select
            name="categoria"
            class="form-select"
            onchange="this.form.submit()"
          >
            <option selected>Categoria</option>
            <option value="inicial">Inicial</option>
            <option value="medium">Medium</option>
            <option value="premium">Premium</option>
            <option value="todas">Todas</option>
          </select>
        </form>
      </div> <!--cierra desplegable de categorias-->
    </div> <!--Cierra fila de busqueda y desplegable-->
  </div> <!--Cierra contenedor de busqueda y desplegable-->
  </div> <!--Cierra contenido principal-->
  <!--Tarjetas-->
  <div class="container w-75 my-4">
    <?php
    //Para la paginacion
    $cantPorPagina=9;
    $pagina=isset($_GET["pagina"])?$_GET["pagina"]:null;
    if(!$pagina){
      $inicio=0;
      $pagina=1;
    }
    else{
      $inicio=($pagina-1) * $cantPorPagina;
    }
    require_once '../conexion.php';
    global $conexion;
    error_reporting(E_ERROR | E_PARSE); // Muestra solo errores fatales y errores de análisis
    ini_set('display_errors', 0);       // No mostrar errores al usuario
    global $recuperar_error;
    
    // Verifica si se ha enviado una categoría
    $categoria = null;
    if (isset($_GET['categoria']) && $_GET['categoria'] != 'Categoria') {
        $categoria = $_GET['categoria'];
    }
    //Verifica si ha enviado una busqueda
    $busqueda = null;
    if (isset($_GET['Buscar']) && !empty($_GET['Buscar'])) {
        $busqueda = $_GET['Buscar'];
    }
    // Construye la consulta SQL
    $query = "SELECT p.descripcion, p.fecha_desde, p.fecha_hasta, 
                    p.lunes, p.martes, p.miercoles, p.jueves, p.viernes, p.sabado, p.domingo, p.imagen_prom,
                    loc.nombre_local
             FROM promocion p 
             INNER JOIN local loc ON p.id_local = loc.id_local
             WHERE fecha_hasta >= CURDATE() AND fecha_desde <= CURDATE() AND p.estado = 'activa'";
    if($categoria!='todas' && $categoria){
      // .= significa agregar al final de la variable query
      $query .= " AND p.categoria = '" . mysqli_real_escape_string($conexion, $categoria) . "'";
    }
    if($busqueda){
      $query .= " AND p.descripcion LIKE '%" . mysqli_real_escape_string($conexion, $busqueda) . "%'";
    }
    //$query .= " LIMIT $inicio, $cantPorPagina";
    $result = mysqli_query($conexion, $query) or die("Hubo un error con la transacción: " . mysqli_error($conexion));
    //para la paginacion
    $totalRegistros=mysqli_num_rows($result); 
    $totalPaginas=ceil($totalRegistros/$cantPorPagina);

    if(isset($_GET["Buscar"])){
   ?>
    <!-- Boton que permite volver atras si hay una busqueda -->
    <div class="container py-3">
      <a href="javascript:history.back()" class="btn btn-outline-primary mb-3">
      <i class="bi bi-arrow-left"></i> Volver
      </a>
    </div>
    <?php
    } //cierro if para boton
    ?>
   <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 align-items-stretch">
    <?php
      if(!$result){
        echo "<div class='alert alert-danger text-center'>
                No se encontró ninguna promoción.
              </div>";
      }
      else{
        if(isset($_GET["Buscar"])){
          while($row = $result->fetch_assoc()) {
            if($_GET["Buscar"]==$row["descripcion"]){      
            // Se fija que extension tiene la imagen
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->buffer($row['imagen_prom']);
            $bandera=1; ;  
    ?>
          <!-- Tarjeta de promoción -->
      <div class="col d-flex justify-content-center align-items-stretch">
        <div class="card mb-3"
          data-bs-toggle="modal"
          data-bs-target="#promoModal"
          data-nombre="<?php echo htmlspecialchars($row['nombre_local']); ?>"
          data-descripcion="<?php echo htmlspecialchars($row['descripcion']); ?>"
          data-fecha-desde="<?php echo htmlspecialchars($row['fecha_desde']); ?>"
          data-fecha-hasta="<?php echo htmlspecialchars($row['fecha_hasta']); ?>"
          data-imagen="data:<?php echo $mime; ?>;base64,<?php echo base64_encode($row['imagen_prom']); ?>"
          data-lunes="<?php echo $row['lunes'] ? 'Lunes' : ''; ?>"
          data-martes="<?php echo $row['martes'] ? 'Martes' : ''; ?>"
          data-miercoles="<?php echo $row['miercoles'] ? 'Miércoles' : ''; ?>"
          data-jueves="<?php echo $row['jueves'] ? 'Jueves' : ''; ?>"
          data-viernes="<?php echo $row['viernes'] ? 'Viernes' :  ''; ?>"
          data-sabado="<?php echo $row['sabado'] ? 'Sábado' : ''; ?>"
          data-domingo="<?php echo $row['domingo'] ? 'Domingo' : ''; ?>"
          style="cursor:pointer;">
          <img src="data:<?php echo $mime; ?>;base64,<?php echo base64_encode($row['imagen_prom']); ?>" class="card-img-top card-img-custom" alt="Promoción">
          <div class="card-body">
            <h5><?php echo htmlspecialchars($row['nombre_local']); ?></h5>
            <p class="card-text"><?php echo htmlspecialchars($row['descripcion']); ?></p>
          </div> <!-- Cierra card-body -->
        </div> <!-- Cierra card -->
      </div> <!-- Cierra col -->
      <?php
      } // llave del if buscar = descripcion    
    } // llave del while
    if (!isset($bandera)){
      echo "<div class='alert alert-warning text-center'>
              No hemos encontrado ninguna promoción que coincida con su búsqueda.
            </div>";
    }
  } //este es el if del buscar
  else {
    if ($result && $result->num_rows > 0) {
        // Verifica si se ha enviado una categoría
      $categoria = null;
      if (isset($_GET['categoria']) && $_GET['categoria'] != 'Categoria') {
          $categoria = $_GET['categoria'];
      }
      //Verifica si ha enviado una busqueda
      $busqueda = null;
      if (isset($_GET['Buscar']) && !empty($_GET['Buscar'])) {
          $busqueda = $_GET['Buscar'];
      }
      // Construye la consulta SQL
      $query = "SELECT p.descripcion, p.fecha_desde, p.fecha_hasta, 
                      p.lunes, p.martes, p.miercoles, p.jueves, p.viernes, p.sabado, p.domingo, p.imagen_prom,
                      loc.nombre_local
              FROM promocion p 
              INNER JOIN local loc ON p.id_local = loc.id_local
              WHERE fecha_hasta >= CURDATE() AND fecha_desde <= CURDATE() AND p.estado = 'activa'";
      if($categoria!='todas' && $categoria){
        // .= significa agregar al final de la variable query
        $query .= " AND p.categoria = '" . mysqli_real_escape_string($conexion, $categoria) . "'";
      }
      if($busqueda){
        $query .= " AND p.descripcion LIKE '%" . mysqli_real_escape_string($conexion, $busqueda) . "%'";
      }
      $query .= " LIMIT $inicio, $cantPorPagina";
      $result = mysqli_query($conexion, $query) or die("Hubo un error con la transacción: " . mysqli_error($conexion));
      while($row = $result->fetch_assoc()) {    
            // Se fija que extension tiene la imagen
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->buffer($row['imagen_prom']);
      ?>
      <!-- Tarjeta de promoción -->
      <div class="col d-flex justify-content-center align-items-stretch">
        <div class="card mb-3"
          data-bs-toggle="modal"
          data-bs-target="#promoModal"
          data-nombre="<?php echo htmlspecialchars($row['nombre_local']); ?>"
          data-descripcion="<?php echo htmlspecialchars($row['descripcion']); ?>"
          data-fecha-desde="<?php echo htmlspecialchars($row['fecha_desde']); ?>"
          data-fecha-hasta="<?php echo htmlspecialchars($row['fecha_hasta']); ?>"
          data-imagen="data:<?php echo $mime; ?>;base64,<?php echo base64_encode($row['imagen_prom']); ?>"
          data-lunes="<?php echo $row['lunes'] ? 'Lunes' : ''; ?>"
          data-martes="<?php echo $row['martes'] ? 'Martes' : ''; ?>"
          data-miercoles="<?php echo $row['miercoles'] ? 'Miércoles' : ''; ?>"
          data-jueves="<?php echo $row['jueves'] ? 'Jueves' : ''; ?>"
          data-viernes="<?php echo $row['viernes'] ? 'Viernes' :  ''; ?>"
          data-sabado="<?php echo $row['sabado'] ? 'Sábado' : ''; ?>"
          data-domingo="<?php echo $row['domingo'] ? 'Domingo' : ''; ?>"
          style="cursor:pointer;">
          <img src="data:<?php echo $mime; ?>;base64,<?php echo base64_encode($row['imagen_prom']); ?>" class="card-img-top card-img-custom" alt="Promoción">
          <div class="card-body">
            <h5><?php echo htmlspecialchars($row['nombre_local']); ?></h5>
            <p class="card-text"><strong>Promo: </strong><?php echo htmlspecialchars($row['descripcion']); ?></p>
          </div>
        </div>
      </div>
      <?php
      } //Cierra while
    } //Cierra if result
  } //Cierra else
}
  mysqli_free_result($result);
    mysqli_close($conexion);
  ?>
  </div> <!--Cierra fila de tarjetas-->
  </div> <!--Cierra contenedor de tarjetas-->

  <?php
  $paginaAnterior = $pagina > 1 ? $pagina - 1 : 1;
  $paginaSiguiente = $pagina < $totalPaginas ? $pagina + 1 : $totalPaginas;
  ?>
  <!--Paginacion-->
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
      <li class="page-item <?php echo $pagina == 1 ? 'disabled' : ''; ?>">
        <a class="page-link" href="promociones.php?pagina=<?php echo $paginaAnterior; ?>" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <?php for($j = 1; $j <= $totalPaginas; $j++) { ?>
            <li class="page-item <?php echo $j == $pagina ? 'active' : ''; ?>">  
              <a class="page-link" href="promociones.php?pagina=<?php echo $j; ?>"><?php echo $j; ?></a>
            </li>
        <?php } ?>
      <li class="page-item <?php echo $pagina == $totalPaginas ? 'disabled' : ''; ?>">
        <a class="page-link" href="promociones.php?pagina=<?php echo $paginaSiguiente; ?>" aria-label="Next">
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
  <!-- Modal de Registro -->
  <?php include '../modals/modalSignUpD.php'; ?>
  <!-- Modal de Recuperar Contraseña -->
  <?php include '../modals/modalRecuperar.php'; ?>
  <!--Modal de promociones-->
  <?php include '../modals/modalPromocion.php'; ?>
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
      document.getElementById('promoModalLabel').textContent = card.getAttribute('data-nombre');
      document.getElementById('promoModalImg').src = card.getAttribute('data-imagen');
      document.getElementById('promoModalDesc').textContent = card.getAttribute('data-descripcion');
      document.getElementById('promoModalDesde').textContent = card.getAttribute('data-fecha-desde');
      document.getElementById('promoModalHasta').textContent = card.getAttribute('data-fecha-hasta');
      const dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo']
      .map(dia => card.getAttribute('data-' + dia)) // obtenés el texto de cada día desde el atributo data
      .filter(Boolean)                             // eliminás los que son null, undefined o string vacío
      .join(', ');                                  // los unís con coma y espacio
      document.getElementById('promoModalDias').textContent = dias;
    });
  });
  </script>
</body>
</html>