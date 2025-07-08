<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Acerca del shopping</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
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
          <form>
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="nombre" required />
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Correo electrónico</label>
              <input type="email" class="form-control" id="email" required />
            </div>
            <div class="mb-3">
              <label for="mensaje" class="form-label">Mensaje</label>
              <textarea
                class="form-control"
                id="mensaje"
                rows="4"
                required
              ></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
          </form>
        </div>
        <div class="col-md-6">
          <h2 class="text-center mb-4">Ubicación</h2>
          <p class="text-center">
            Estamos ubicados en el corazón de la ciudad, con fácil acceso y
            estacionamiento disponible.
          </p>
          <div class="text-center">
            <img
              src="imagenes/mapa.png"
              alt="Mapa de ubicación"
              class="img-fluid"
            />
          </div>
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
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="loginModalLabel">Iniciar sesión</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <form method="post" action=""> <!-- aca hay que agregar la logica del login -->
              <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="email" name="email" required />
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required />
              </div>
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Ingresar</button>
              </div>
            </form>
            <div class="text-center mt-3">
              <small>¿No tenés cuenta? <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registroModal">Registrate</a></small>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal de Registro -->
    <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="registroModalLabel">Crear una cuenta</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <form method="post" action="registro.php"> <!-- Archivo futuro -->
              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required />
              </div>
              <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required />
              </div>
              <div class="mb-3">
                <label for="clave" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="clave" name="clave" required />
              </div>
              <div class="mb-3">
                <label for="clave2" class="form-label">Confirmar contraseña</label>
                <input type="password" class="form-control" id="clave2" name="clave2" required />
              </div>
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success">Registrarse</button>
              </div>
            </form>
            <div class="text-center mt-3">
              <small>¿Sos dueño de un local? <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registroDueñoModal">Regristrarse como dueño</a></small><br>     
              <small>¿Ya tenés cuenta? <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Ingresá</a></small>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal de Registro -->
    <div class="modal fade" id="registroDueñoModal" tabindex="-1" aria-labelledby="registrDoueñoModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="registroDueñoModalLabel">Crear una cuenta</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <form method="post" action="registro.php"> <!-- Archivo futuro -->
              <div class="mb-3">
                <label for="idLocal" class="form-label">Id del local</label>
                <input type="text" class="form-control" id="idLocal" name="idLocal" required />
              </div>
              <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required />
              </div>
              <div class="mb-3">
                <label for="clave" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="clave" name="clave" required />
              </div>
              <div class="mb-3">
                <label for="clave2" class="form-label">Confirmar contraseña</label>
                <input type="password" class="form-control" id="clave2" name="clave2" required />
              </div>
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success">Registrarse</button>
              </div>
            </form>
            <div class="text-center mt-3">
              <small>¿No tenés cuenta? <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registroModal">Registrate</a></small><br>
              <small>¿Ya tenés cuenta? <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Ingresá</a></small>
            </div>
          </div>
        </div>
      </div>
    </div>

  </body>
</html>
