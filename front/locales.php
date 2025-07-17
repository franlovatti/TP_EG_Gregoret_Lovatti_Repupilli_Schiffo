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
          <div class=" col-12 ">
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
          
        </div>
      </div>

      <div class="container w-75 my-4">
      <?php 
      $cantPorPagina=6;
      $pagina=isset($_GET["pagina"])?$_GET["pagina"]:null;
      if(!$pagina){
        $inicio=0;
        $pagina=1;
      }
      else{
        $inicio=($pagina-1) * $cantPorPagina;

      }
      include '../conexion.php';
      $vSQL="SELECT * from local where estado='activo'";
      $vResult=mysqli_query($conexion,$vSQL);
      $totalRegistros=mysqli_num_rows($vResult); 
      $totalPaginas=ceil($totalRegistros/$cantPorPagina);
      


      if(!$vResult){
         echo "<div class='alert alert-info text-center my-5'>No se encontró ningún local</div>";
      }
      else{
        if(isset($_POST["Buscar"])){
          while($fila=mysqli_fetch_assoc($vResult)){
            if($_POST["Buscar"]==$fila["nombre_local"]){
              $finfo=new finfo(FILEINFO_MIME_TYPE);
              $mime=$finfo->buffer($fila['imagen_local']);
        $bandera=1; ?>
          <div class="container my-3">
      <div class="card shadow-sm border-0">
        <div class="row g-0">
          <!-- Imagen -->
          <div class="col-12 col-md-3 d-flex justify-content-center align-items-center p-3">
            <img src="data:<?php echo $mime; ?>;base64,<?php echo base64_encode($fila['imagen_local']); ?>" class="img-fluid rounded" style="max-height:100px;" alt="Logo del local">
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
  } if (!isset($bandera)){
    echo "<div class='alert alert-warning text-center'>
                  NO EXISTE LOCAL CON ESE NOMBRE
                </div>";}
}else{ 
         
      
      $vSQL="SELECT * FROM local where estado='activo' limit $inicio,$cantPorPagina";
      $vResult=mysqli_query($conexion,$vSQL);
      $totalRegistros=mysqli_num_rows($vResult);
      if ($totalRegistros<=2){
        $cantidadFilas=1;
      }
      elseif($totalRegistros>2 && $totalRegistros<=4){
      $cantidadFilas=2;}
      elseif($totalRegistros>4){
        $cantidadFilas=3;
      }
      for($i=1;$i<=$cantidadFilas;$i++){

?>  
      <div class="row mb-3 g-3">
          
        
        <div class="col-12 col-lg-6">
          <?php $fila=mysqli_fetch_array($vResult);
          $b=true;
          while ($b){
          if($fila['estado']=='activo'){
            $b=false;
          }
          else{
            $fila=mysqli_fetch_array($vResult);
            
          }}
          $finfo=new finfo(FILEINFO_MIME_TYPE);
              $mime=$finfo->buffer($fila['imagen_local']);
          ?>
            <div class="card h-100">
              <div class="row h-100">
                <div class="col-12 col-sm-4 d-flex flex-column flex-sm-row ">
                  <img
                    src="data:<?php echo $mime; ?>;base64,<?php echo base64_encode($fila['imagen_local']); ?>"
                    class="img-fluid h-100 w-100 object-fit-cover rounded-start"
                    alt="Imagen"
                  />
                </div>
                <div class="col-12 col-sm-8 d-flex flex-column flex-sm-row">
                  <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= htmlspecialchars($fila['nombre_local']) ?></h5>
                    <p class="card-text">Numero local: <?= htmlspecialchars($fila['id_local']) ?> </p>
                    <p class="card-text">Ubicacion: <?= htmlspecialchars($fila['ubicacion']) ?></p>
                    <p class="card-text">Rubro: <?=htmlspecialchars($fila['ubicacion'])?></p>
                    <a href="" class="btn btn-primary mt-1"
                      >Ver promociones</a
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-6">
          <?php if($fila=mysqli_fetch_array($vResult)){;
          $b=true;
          while ($b){
          if($fila['estado']=='activo'){
            $b=false;
          }
          else{
            $fila=mysqli_fetch_array($vResult);
          }}
          $finfo=new finfo(FILEINFO_MIME_TYPE);
              $mime=$finfo->buffer($fila['imagen_local']);?>
            <div class="card h-100">
              <div class="row h-100">
                <div class="col-12 col-sm-4 d-flex flex-column flex-sm-row ">
                  <img
                    src="data:<?php echo $mime; ?>;base64,<?php echo base64_encode($fila['imagen_local']); ?>"
                    class="img-fluid h-100 w-100 object-fit-cover rounded-start"
                    alt="Imagen"
                  />
                </div>
                <div class="col-12 col-sm-8 d-flex flex-column flex-sm-row">
                  <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= htmlspecialchars($fila['nombre_local']) ?></h5>
                    <p class="card-text">Numero local: <?= htmlspecialchars($fila['id_local']) ?> </p>
                    <p class="card-text">Ubicacion: <?= htmlspecialchars($fila['ubicacion']) ?></p>
                    <p class="card-text">Rubro: <?=htmlspecialchars($fila['ubicacion'])?></p>
                    <a href="" class="btn btn-primary mt-1"
                      >Ver promociones</a
                    >
                  </div>
                </div>
              </div>
            </div>
            <?php }?>
          </div>
         
      </div>
      <?php }
      mysqli_free_result($vResult);
      mysqli_close($conexion);?>
      </div>
      <?php
      $paginaAnterior = $pagina > 1 ? $pagina - 1 : 1;
      $paginaSiguiente = $pagina < $totalPaginas ? $pagina + 1 : $totalPaginas; ?>
      
     <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        
        <li class="page-item <?php echo $pagina == 1 ? 'disabled' : ''; ?>">
            <a class="page-link" href="locales.php?pagina=<?php echo $paginaAnterior; ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>

        
        <?php for($j = 1; $j <= $totalPaginas; $j++) { ?>
            <li class="page-item <?php echo $j == $pagina ? 'active' : ''; ?>">
                
                <a class="page-link" href="locales.php?pagina=<?php echo $j; ?>"><?php echo $j; ?></a>
            </li>
        <?php } ?>

      
        <li class="page-item <?php echo $pagina == $totalPaginas ? 'disabled' : ''; ?>">
            <a class="page-link" href="locales.php?pagina=<?php echo $paginaSiguiente; ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>
<?php }}?>
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
    <!--scrips al final-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
