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
<main class="d-flex flex-column flex-grow-1">
<div class="container my-4">
  <div class="card shadow-sm border-0">
    <div class="card-body">
      <div class="row g-3 align-items-center">
        <!-- Buscador -->
        <div class="col-12 col-md-8">
          <form method="post" action="" class="d-flex">
            <div class="input-group">
              <input name="Buscar" type="text" class="form-control" placeholder="Buscar">
              <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>  

<?php
require_once '../conexion.php'; 
$query="SELECT * FROM local where estado='activo'";
$resultado =mysqli_query($conexion, $query);
if (!$resultado){
    echo "<div class='alert alert-info text-center my-5'>No se encontró ningún local</div>";
}
else{
  if(isset($_POST["Buscar"])){
    while ($fila = mysqli_fetch_assoc($resultado)) {
    if($_POST["Buscar"]==$fila["nombre_local"]){
        $bandera=1; ?>
          <div class="container my-3">
      <div class="card shadow-sm border-0">
        <div class="row g-0">
          <!-- Imagen -->
          <div class="col-12 col-md-3 d-flex justify-content-center align-items-center p-3">
            <img src="imagenes/logo.png" class="img-fluid rounded" style="max-height:100px;" alt="Logo del local">
          </div>

          <!-- Datos -->
          <div class="col-12 col-md-9">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($fila['nombre_local']) ?></h5>
              <p class="mb-1"><strong>Nro Local:</strong> <?= htmlspecialchars($fila['id_local']) ?></p>
              <p class="mb-1"><strong>Ubicación:</strong> <?= htmlspecialchars($fila['ubicacion']) ?></p>
              <p class="mb-2"><strong>Rubro:</strong> <?= htmlspecialchars($fila['rubro']) ?></p>
              <a href="#" class="btn btn-primary btn-sm">Ver promociones</a>
            </div>
          </div>
        </div>
      </div>
    </div><?php }
 } 
  if (!isset($bandera)){
    echo "<div class='alert alert-warning text-center'>
                  NO EXISTE LOCAL CON ESE NOMBRE
                </div>";}}
  else{
      while ($fila = mysqli_fetch_assoc($resultado)) { ?>  
      <div class="container my-3">
            <div class="card shadow-sm border-0">
              <div class="row g-0">
                <!-- Imagen -->
                <div class="col-12 col-md-3 d-flex justify-content-center align-items-center p-3">
                  <img src="imagenes/logo.png" class="img-fluid rounded" style="max-height:100px;" alt="Logo del local">
                </div>

                <!-- Datos -->
                <div class="col-12 col-md-9">
                  <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($fila['nombre_local']) ?></h5>
                    <p class="mb-1"><strong>Nro Local:</strong> <?= htmlspecialchars($fila['id_local']) ?></p>
                    <p class="mb-1"><strong>Ubicación:</strong> <?= htmlspecialchars($fila['ubicacion']) ?></p>
                    <p class="mb-2"><strong>Rubro:</strong> <?= htmlspecialchars($fila['rubro']) ?></p>
                    <a href="#" class="btn btn-primary btn-sm">Ver promociones</a>
                  </div>
                </div>
              </div>
            </div>
          </div> <?php } 
  } 
} ?>
<div class="container mt-auto my-4">
  <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
      <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
      <li class="page-item"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li>
      <li class="page-item"><a class="page-link" href="#">3</a></li>
      <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
    </ul>
  </nav>
</div>
</main>
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
    <!-- script signUp -->
    <?php if (!empty($signUp_error)){?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = new bootstrap.Modal(document.getElementById('registroModal'));
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
