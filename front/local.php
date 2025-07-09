<?php include '../sesion.php'; 
include '../verificarLogin.php';

$login_error = "";
if (isset($_COOKIE['mantenerSesionIniciada']) && $_COOKIE['mantenerSesionIniciada'] == 'si' && !isset($_SESSION['usuario']) && empty($_SESSION['cerrarSesion'])) {
  var_dump($_COOKIE);
  $_SESSION['usuario'] = $_COOKIE['usuario'];
  $_SESSION['tipoUsuario'] = $_COOKIE['tipoUsuario'];
  $_SESSION['idUsuario'] = $_COOKIE['idUsuario'];
  if (isset($_COOKIE['categoriaCliente'])) {
    $_SESSION['categoria'] = $_COOKIE['categoriaCliente'];
  }
} elseif (isset($_POST['email']) && isset($_POST['password'])) {
  login();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Local</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"/>
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
      .promo-card {
      max-width: 340px;
      max-height: 260px;
      }
    .card-img-custom {
    max-height: 130px;      /* Cambia el valor según lo que necesites */
    max-width: 340px;
    object-fit: cover;      /* Recorta la imagen para llenar el área */
    object-position: center;/* Centra el recorte */
    width: 100%;}
  </style>
</head>
<body>
<header class="p-3 text-bg-dark">
  <?php include '../header.php'; ?>
</header>

<div class="container py-3">
  <div class="row">
    <div class="col-12">
      <div class="card shadow border-0">
        <div class="row g-0 flex-column flex-md-row">
          <!-- Imagen a la izquierda -->
          <div class="col-12 col-md-2 d-flex justify-content-center justify-content-md-start align-items-center p-2">
            <img src="imagenes/logo.png" class="img-fluid rounded" alt="Logo del local">
          </div>

          <!-- Texto a la derecha -->
          <div class="col-md-10 d-flex align-items-center">
            <div class="card-body">
              <h5 class="card-title mb-1">Nombre del Local</h5>
              <p class="card-text mb-0">Nro Local: 101</p>
              <p class="card-text mb-0">Ubicación: Primer Piso</p>
              <p class="card-text mb-3">Horario: 10:00 a 20:00</p>
              <!--<a href="#" class="btn btn-primary">Ver promociones</a>-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--Tarjetas-->
  <div class="my-3 container">
    <div class="row row-cols-1 row-cols-md-4 g-4 align-items-stretch">
      <!--Tarjeta 1-->
      <div class="col d-flex justify-content-center">
        <div class="card promo-card mb-3">
          <img src="imagenes/promocion.jpg" class="card-img-top card-img-custom" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a wider card with supporting text below.</p>
          </div>
        </div>
      </div>
      <!--Tarjeta 2-->
      <div class="col d-flex justify-content-center">
        <div class="card promo-card mb-3">
          <img src="imagenes/promocion.jpg" class="card-img-top card-img-custom" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a wider card with supporting text below .</p>
          </div>
        </div>
      </div>
      <!--Tarjeta 3-->
      <div class="col d-flex justify-content-center">
        <div class="card promo-card mb-3">
          <img src="imagenes/promocion.jpg" class="card-img-top card-img-custom" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a wider card with supporting text below.</p>
          </div>
        </div>
      </div>

      <div class="col d-flex justify-content-center">
        <div class="card promo-card mb-3">
          <img src="imagenes/promocion.jpg" class="card-img-top card-img-custom" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a wider card with supporting text below.</p>
          </div>
        </div>
      </div>

      <div class="col d-flex justify-content-center">
        <div class="card promo-card mb-3">
          <img src="imagenes/promocion.jpg" class="card-img-top card-img-custom" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a wider card with supporting text below.</p>
          </div>
        </div>
      </div>
      
      <div class="col d-flex justify-content-center">
        <div class="card promo-card mb-3">
          <img src="imagenes/promocion.jpg" class="card-img-top card-img-custom" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a wider card with supporting text below.</p>
          </div>
        </div>
      </div>
      
      <div class="col d-flex justify-content-center">
        <div class="card promo-card mb-3">
          <img src="imagenes/promocion.jpg" class="card-img-top card-img-custom" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a wider card with supporting text below.</p>
          </div>
        </div>
      </div>
      
      <div class="col d-flex justify-content-center">
        <div class="card promo-card mb-3">
          <img src="imagenes/promocion.jpg" class="card-img-top card-img-custom" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a wider card with supporting text below.</p>
          </div>
        </div>
      </div>
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



  <footer class="footer mt-auto py-3 bg-body-tertiary">
    <?php include '../footer.php'; ?>
  </footer>

  <!-- Modal de Login -->
  <?php include '../modals/modalLogin.php'; ?>

  <!-- scripts al final -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <?php if (!empty($login_error)){?>
  <script>
      document.addEventListener('DOMContentLoaded', function () {
          var modal = new bootstrap.Modal(document.getElementById('loginModal'));
          modal.show();
      });
  </script>
  <?php }; ?>
</body>
</html>