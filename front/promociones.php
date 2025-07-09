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
      max-height: 260px; /* Ajusta la altura máxima de la tarjeta */
      max-width: 340px; /* Ajusta el ancho máximo de la tarjeta */
    }
    .card-img-custom {
    max-height: 130px;      /* Cambia el valor según lo que necesites */
    max-width: 340px;
    object-fit: cover;      /* Recorta la imagen para llenar el área */
    object-position: center;/* Centra el recorte */
    width: 100%;
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
  <div class="my-4 container-fluid d-flex justify-content-center align-items-center">
    <div class="row row-cols-1 row-cols-md-4 g-0 align-items-stretch">
      <!--Tarjeta 1-->
      <div class="col d-flex justify-content-center">
        <div class="card mb-3">
          <img src="imagenes/promocion.jpg" class="card-img-top card-img-custom" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a wider card with supporting text below.</p>
          </div>
        </div>
      </div>
      <!--Tarjeta 2-->
      <div class="col d-flex justify-content-center">
        <div class="card mb-3">
          <img src="imagenes/promocion.jpg" class="card-img-top card-img-custom" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.
              This content is a little bit longer.</p>
          </div>
        </div>
      </div>
      <!--Tarjeta 3-->
      <div class="col d-flex justify-content-center">
        <div class="card mb-3">
          <img src="imagenes/promocion.jpg" class="card-img-top card-img-custom" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.
              This content is a little bit longer.</p>
          </div>
        </div>
      </div>

      <div class="col d-flex justify-content-center">
        <div class="card mb-3">
          <img src="imagenes/promocion.jpg" class="card-img-top card-img-custom" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.
              This content is a little bit longer.</p>
          </div>
        </div>
      </div>

      <div class="col d-flex justify-content-center">
        <div class="card mb-3">
          <img src="imagenes/promocion.jpg" class="card-img-top card-img-custom" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.
              This content is a little bit longer.</p>
          </div>
        </div>
      </div>
      
      <div class="col d-flex justify-content-center">
        <div class="card mb-3">
          <img src="imagenes/promocion.jpg" class="card-img-top card-img-custom" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.
              This content is a little bit longer.</p>
          </div>
        </div>
      </div>
      
      <div class="col d-flex justify-content-center">
        <div class="card mb-3">
          <img src="imagenes/promocion.jpg" class="card-img-top card-img-custom" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.
              This content is a little bit longer.</p>
          </div>
        </div>
      </div>
      
      <div class="col d-flex justify-content-center">
        <div class="card mb-3">
          <img src="imagenes/promocion.jpg" class="card-img-top card-img-custom" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.
              This content is a little bit longer.</p>
          </div>
        </div>
      </div>

      <!-- <div class="col d-flex justify-content-center">
        <div class="card h-100 w-75 bg-body-tertiary">
          <img src="imagenes/home.png" class="card-img-top" alt="...">
          <div class="card-body d-flex flex-column h-100">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">Texto de prueba adicional.</p>
          </div>
        </div>
      </div>-->
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
</body>
</html>