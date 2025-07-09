<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Locales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  </head>

  <body class="d-flex flex-column min-vh-100">
    <header class="p-3 text-bg-dark">
      <?php include '../header.php'; ?>
    </header>
    <!-- Contenido principal -->
    <div class="container-fluid my-4">
      <div class="container w-75">
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

      <div class="container w-75 my-4">
      <?php for($i=0;$i<=2;$i++){

?>  
      <div class="row mb-3 g-3">
          
        
        <div class="col-12 col-lg-6">
            <div class="card h-100">
              <div class="row h-100">
                <div class="col-12 col-sm-4 d-flex flex-column flex-sm-row ">
                  <img
                    src="imagenes\logo.png"
                    class="img-fluid h-100 w-100 object-fit-cover rounded-start"
                    alt="Imagen"
                  />
                </div>
                <div class="col-12 col-sm-8 d-flex flex-column flex-sm-row">
                  <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Nombre local</h5>
                    <p class="card-text">Numero local </p>
                    <p class="card-text">Ubicacion</p>
                    <a href="" class="btn btn-primary mt-1"
                      >Ver promociones</a
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="card h-100">
              <div class="row h-100">
                <div class="col-12 col-sm-4 d-flex flex-column flex-sm-row">
                  <img
                    src="imagenes\images (1).png"
                    class="img-fluid   object-fit-cover rounded-start"
                    alt="Imagen"
                    
                  />
                </div>
                <div class="col-12 col-sm-8 d-flex flex-column flex-sm-row">
                  <div class="card-body d-flex flex-column">
                  <h5 class="card-title">Nombre local</h5>
                    <p class="card-text">Numero local </p>
                    <p class="card-text">Ubicacion</p>
                    <a href="" class="btn btn-primary mt-1"
                      >Ver promociones</a
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
          
      </div>
      <?php }?>
      </div>

      
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
    </div>

    <footer class="footer mt-auto py-3 bg-body-tertiary">
      <?php include '../footer.php'; ?>
    </footer>

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
    <!--scrips al final-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
