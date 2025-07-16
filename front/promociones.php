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
      min-width: 340px;
      max-width: 340px;
    }
    .card-img-custom {
    height: 130px;      /* Cambia el valor según lo que necesites */
    width: 100%;
    object-fit: cover;      /* Recorta la imagen para llenar el área */
    object-position: center;/* Centra el recorte */
    }
  </style>
</head>
<body>
  <header class="p-3 text-bg-dark">
    <?php include '../header.php'; ?>
  </header>

  <!-- Barra de busqueda -->
  <div class="container w-75 my-4">
    <div class="row align-items-center gy-1">
      <div class="col-lg-9 col-12 ">
        <form class="d-flex" method="post" action="">
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
      <div class="col-12 col-lg-3">
        <form method="post" action="">
          <select
            name="categoria"
            class="form-select"
            onchange="this.form.submit()"
          >
            <option selected>Categoria</option>
            <option value="1">Categoria 1</option>
            <option value="2">Categoria 2</option>
            <option value="3">Categoria 3</option>
          </select>
        </form>
      </div>
    </div>
  </div>

  <!--Tarjetas-->
  <?php
    require_once '../conexion.php';
    global $conexion;
    error_reporting(E_ERROR | E_PARSE); // Muestra solo errores fatales y errores de análisis
    ini_set('display_errors', 0);       // No mostrar errores al usuario
    global $recuperar_error;
    
    $query = "SELECT p.descripcion, p.fecha_desde, p.fecha_hasta, 
                    p.lunes, p.martes, p.miercoles, p.jueves, p.viernes, p.sabado, p.domingo, p.imagen_prom,
                    loc.nombre_local
             FROM promocion p 
             INNER JOIN local loc ON p.id_local = loc.id_local
             WHERE fecha_hasta >= CURDATE() AND fecha_desde <= CURDATE() AND estado = 'activa'";
    $result = mysqli_query($conexion, $query) or die("Hubo un error con la transacción: " . mysqli_error($conexion));
    //mysqli_close($conexion);
  ?>
  <div class="my-4 container-fluid d-flex justify-content-center align-items-center">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-0 align-items-stretch">
      <?php
      if ($result && $result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
          $finfo = new finfo(FILEINFO_MIME_TYPE);
          $mime = $finfo->buffer($row['imagen_prom']);
      ?>
      <div class="col d-flex justify-content-center align-items-stretch">
        <div class="card mb-3">
          <img src="data:<?php echo $mime; ?>;base64,<?php echo base64_encode($row['imagen_prom']); ?>" class="card-img-top card-img-custom" alt="Promoción">
          <div class="card-body">
            <h5><?php echo htmlspecialchars($row['nombre_local']); ?></h5>
            <p class="card-text"><?php echo htmlspecialchars($row['descripcion']); ?></p>
          </div>
        </div>
      </div>
      <?php
          }
      } else {
          echo "<p>No hay promociones disponibles.</p>";
      }
      ?>
    </div>
  </div>

  <!--Paginacion-->
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
      <li class="page-item">
        <a class="page-link" href="#" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <li class="page-item"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li>
      <li class="page-item"><a class="page-link" href="#">3</a></li>
      <li class="page-item">
        <a class="page-link" href="#" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>
  
  <!-- Modal para promociones -->
  <div class="modal fade" id="promoModal" tabindex="-1" aria-labelledby="promoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="promoModalLabel">Detalles de la Promoción</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <img src="imagenes/home.png" class="img-fluid mb-3" alt="Promoción">
          <h5>Nombre de la Promoción</h5>
          <p>Descripción detallada de la promoción. Aquí puedes incluir información relevante como fechas, condiciones, etc.</p>
          <p><strong>Fecha de inicio:</strong> 01/01/2025</p>
          <p><strong>Fecha de finalización:</strong> 31/01/2025</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary">Aprovechar Promoción</button>
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Modal body text goes here.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
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
</body>
</html>

 <p class="card-text"><small class="text-muted"><b>Desde:</b> <?php echo htmlspecialchars($row['fecha_desde']); ?></small></p>
          <p class="card-text"><small class="text-muted"><b>Hasta:</b> <?php echo htmlspecialchars($row['fecha_hasta']); ?></small></p>
          <p class="card-text">
            <small class="text-muted">Días disponibles: 
              <?php
                $dias = [];
                if ($row['lunes']) $dias[] = 'Lunes';
                if ($row['martes']) $dias[] = 'Martes';
                if ($row['miercoles']) $dias[] = 'Miércoles';
                if ($row['jueves']) $dias[] = 'Jueves';
                if ($row['viernes']) $dias[] = 'Viernes';
                if ($row['sabado']) $dias[] = 'Sábado';
                if ($row['domingo']) $dias[] = 'Domingo';
                echo implode(', ', $dias);
              ?>
            </small>