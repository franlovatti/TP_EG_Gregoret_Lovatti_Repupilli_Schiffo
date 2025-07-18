<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Acerca del shopping</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <style>
      .carousel-inner {
        height: 450px;
        /* Ajusta la altura que desees */
      }
      .carousel-inner img {
        object-fit: cover;
        height: 100%;
        width: 100%;
        margin: 0 auto;
        display: block;
      }
      @media (max-width: 576px) {
        .carousel-inner {
          height: 200px;
        }
        .carousel-inner img {
          height: 200px; /* Igual que el contenedor */
        }
      }
    #map { height: 500px; }
    </style>
  </head>

  <body class="d-flex flex-column min-vh-100">
    <header class="p-3 text-bg-dark">
      <?php include '../header.php'; ?>
    </header>

    <!--Carrucel de fotos del shopping-->
    <!--Nota hay que buscar poner fotos que tengan el mismo tamaño, ahora esta seteado para h-350px y w-auto -->
    <div id="carouselExampleCaptions" class="carousel slide">
      <div class="carousel-indicators">
        <button
          type="button"
          data-bs-target="#carouselExampleCaptions"
          data-bs-slide-to="0"
          class="active"
          aria-current="true"
          aria-label="Slide 1"
        ></button>
        <button
          type="button"
          data-bs-target="#carouselExampleCaptions"
          data-bs-slide-to="1"
          aria-label="Slide 2"
        ></button>
        <button
          type="button"
          data-bs-target="#carouselExampleCaptions"
          data-bs-slide-to="2"
          aria-label="Slide 3"
        ></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img
            src="imagenes/shopping.jpg"
            class="d-block w-100"
            alt="shopping"
          />
        </div>
        <div class="carousel-item">
          <img
            src="imagenes/alto2.jpg"
            class="d-block w-100"
            alt="patioComidas"
          />
        </div>
        <div class="carousel-item">
          <img src="imagenes/mapa.png" class="d-block w-100" alt="..." />
        </div>
      </div>
      <button
        class="carousel-control-prev"
        type="button"
        data-bs-target="#carouselExampleCaptions"
        data-bs-slide="prev"
      >
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button
        class="carousel-control-next"
        type="button"
        data-bs-target="#carouselExampleCaptions"
        data-bs-slide="next"
      >
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    <!--Quienes somos-->
    <div class="container my-4">
      <h2 class="text-center my-2">Acerca del shopping</h2>
      <p class="text-center">
        El shopping es un lugar donde puedes encontrar una gran variedad de
        tiendas, restaurantes y entretenimiento. Ofrecemos una experiencia única
        de compras y ocio para toda la familia.
      </p>
      <p class="text-center">
        Nuestro objetivo es brindar un espacio cómodo y agradable para que
        nuestros visitantes disfruten de su tiempo aquí. Desde tiendas de moda
        hasta opciones gastronómicas, tenemos algo para todos.
      </p>
    </div>

    <!--Form de contacto-->
    <div class="container-fluid">
      <div class="row justify-content-center my-4">
        <div class="col-md-6">
          <h2 class="text-center mb-4">Contáctanos</h2>
          <?php include 'formConsultasAcercaDe.php'; ?>
        </div>
        <div class="col-md-6">
          <h2 class="text-center mb-4">Ubicación</h2>
          <p class="text-center">
            Estamos ubicados en el corazón de la ciudad, con fácil acceso y
            estacionamiento disponible.
          </p>
          <!-- Mapa -->
          <div id="map"></div>
        </div>
      </div>
    </div>

    <!--Footer-->
    <footer class="footer mt-auto py-3 bg-body-tertiary">
      <?php include '../footer.php'; ?>
    </footer>

    <!-- Scripts al final -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
      crossorigin="anonymous"
    ></script>

    <!-- Script para cerrar menú al hacer clic en un link -->
    <script>
      document.querySelectorAll('.navbar-nav .nav-link').forEach((link) => {
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

  <!-- Mapa -->
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script>
    var lat = -32.9275; 
    var lng = -60.6683;
    var map = L.map('map').setView([lat, lng], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    L.marker([lat, lng]).addTo(map)
       .bindPopup('Alto Rosario Shopping')
       .openPopup();
  </script>
  </body>
</html>
