

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Locales</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
      crossorigin="anonymous"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
      rel="stylesheet"
    />
  </head>
  <body>
    <header class="p-3 text-bg-dark">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a
            href="header.html"
            class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none"
          >
            <img
              src="imagenes/logoHome.png"
              alt="Logo"
              width="30"
              height="24"
              class="me-2"
            />
          </a>
          <ul
            class="text-white ms-3 me-3"
            style="
              list-style: none;
              padding-left: 0;
              margin: 0;
              font-size: x-small;
            "
          >
            <li>Lunes a Viernes 10:00-20:00</li>
            <li>Sábados 10:00-18:00</li>
          </ul>
          <!-- Botón hamburguesa -->
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarOpciones"
            aria-controls="navbarOpciones"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>

          <!-- Opciones de menú -->
          <div class="collapse navbar-collapse" id="navbarOpciones">
            <ul class="navbar-nav mb-2 mb-lg-0">
              <li class="nav-item">
                <a href="acercaDe.html" class="nav-link px-2 text-white"
                  >Acerca del shopping</a
                >
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link px-2 text-white">Locales</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link px-2 text-white">Promociones</a>
              </li>
            </ul>
            <div class="navbar-nav ms-auto">
              <button type="button" class="btn btn-outline-light mx-1 my-1">
                Ingresar
              </button>
              <button type="button" class="btn btn-primary mx-1 my-1">
                Registrarse
              </button>
            </div>
          </div>
        </div>
      </nav>
    </header>

    <!-- Contenido principal -->
    <div class="container-fluid py-5">
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

      <div class="container w-75 py-5">
      <?php for($i=0;$i<=2;$i++){

?>  
      <div class="row mb-3 g-3">
          
        
        <div class="col-12 col-lg-6">
            <div class="card h-100">
              <div class="row h-100">
                <div class="col-4">
                  <img
                    src="imagenes\logo.png"
                    class="img-fluid h-100 w-100 object-fit-cover rounded-start"
                    alt="Imagen"
                  />
                </div>
                <div class="col-8">
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
                <div class="col-4">
                  <img
                    src="imagenes\images (1).png"
                    class="img-fluid h-100 w-100 object-fit-cover rounded-start"
                    alt="Imagen"
                  />
                </div>
                <div class="col-8">
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

    <!--Footer-->
    <footer class="footer mt-auto py-3 bg-body-tertiary">
      <ul class="nav justify-content-center border-bottom pb-3 mb-3">
        <li class="nav-item">
          <a href="home.html" class="nav-link px-2 text-body-secondary">Home</a>
        </li>
        <li class="nav-item">
          <a href="acercaDe.html" class="nav-link px-2 text-body-secondary"
            >Acerca del shopping</a
          >
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link px-2 text-body-secondary">Locales</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link px-2 text-body-secondary">Promociones</a>
        </li>
      </ul>
      <div
        class="container d-flex flex-wrap justify-content-between align-items-center"
      >
        <div class="col-sm-3 d-flex align-items-center">
          <span class="mb-md-0 text-body-secondary">© 2025 Company, Inc</span>
        </div>
        <div class="col-sm-3 d-flex justify-content-center">
          <a
            href=""
            class="nav-link px-2 text-body-secondary align-items-center"
            >Terminos y Condiciones</a
          >
        </div>
        <ul class="nav col-sm-3 justify-content-end list-unstyled d-flex">
          <li class="ms-3">
            <a class="text-body-secondary" href="#" aria-label="Instagram">
              <img
                src="imagenes/logoIG.png"
                alt="logoIG"
                width="24"
                height="24"
              />
            </a>
          </li>
          <li class="ms-3">
            <a class="text-body-secondary" href="#" aria-label="Facebook">
              <img
                src="imagenes/logoFB.png"
                alt="logoFB"
                width="24"
                height="24"
              />
            </a>
          </li>
        </ul>
      </div>
    </footer>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
