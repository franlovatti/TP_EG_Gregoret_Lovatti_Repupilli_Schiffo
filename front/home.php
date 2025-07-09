<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  </head>

  <body style="height: 100%">
    <header class="p-3 text-bg-dark">
      <?php include '../header.php'; ?>
    </header>

    <!-- Contenido principal -->
    <div class="container-fluid py-5 text-center">
      <h1 class="text-center">Welcome to Our Website</h1>
      <p class="text-center">
        This is a simple example of a Bootstrap header with navigation links and
        buttons.
      </p>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 p-0">
          <img
            src="imagenes/alto2.jpg"
            alt="shopping Image"
            class="img-fluid"
          />
        </div>
      </div>
    </div>
    <div class="my-4 container-fluid">
      <h2 class="text-center my-2">Promociones</h2>
      <div class="row row-cols-1 row-cols-md-3 g-1 align-items-stretch">
        <div class="col d-flex justify-content-center">
          <div class="card h-100 w-75 bg-body-tertiary">
            <img src="imagenes/home.png" class="card-img-top" alt="..." />
            <div class="card-body d-flex flex-column h-100">
              <h5 class="card-title">Card title</h5>
              <p class="card-text">Texto de ejemplo.</p>
            </div>
          </div>
        </div>
        <div class="col d-flex justify-content-center">
          <div class="card h-100 w-75 bg-body-tertiary">
            <img src="imagenes/home.png" class="card-img-top" alt="..." />
            <div class="card-body d-flex flex-column h-100">
              <h5 class="card-title">Card title</h5>
              <p class="card-text">Otro texto más largo para probar el alto.</p>
            </div>
          </div>
        </div>
        <div class="col d-flex justify-content-center">
          <div class="card h-100 w-75 bg-body-tertiary">
            <img src="imagenes/home.png" class="card-img-top" alt="..." />
            <div class="card-body d-flex flex-column h-100">
              <h5 class="card-title">Card title</h5>
              <p class="card-text">Texto de prueba adicional.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="container-fluid text-center my-4">
        <button class="btn btn-primary">Mas promociones</button>
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
    <!-- sript login -->
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
