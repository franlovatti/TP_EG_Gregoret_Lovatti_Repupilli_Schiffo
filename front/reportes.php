<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reportes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
    <style>
      .scrollable-box {
    max-height: 450px; 
    overflow-y: auto;  
    border: 1px solid #ccc; 
    padding: 10px; }
    table {
    border-collapse: collapse;
    width: 80%;
    margin: auto;}
    td,th {
      text-align: center;}
    </style>
  </head>
  <body>
    <header class="p-3 text-bg-dark">
      <?php include '../header.php'; ?>
    </header>
    <?php
    $tipoUsuario = $_SESSION['tipoUsuario'] ?? null;
    ?>
    <div class="container-fluid">
      <div class="container w-75 py-5">
        <!-- Fila de buscador y filtros -->
        <div class="row gy-1"> 
          <?php
          // Definir variables para el buscador según el tipo de usuario
          if($tipoUsuario == 'administrador'){
            $buscarPor = 'buscarPorLocal';
            $placeholder = 'Buscar por local';
          } else{
            $buscarPor = 'buscarPorPromo';
            $placeholder = 'Buscar por promoción';
          }
          ?>  
          <!-- Buscador -->
          <div class="col-lg-4 col-12">
            <form class="d-flex" method="post" action="">
              <div class="input-group">
                <input type="hidden" name = "buscarPor" value="<?=$buscarPor?>"/>
                <input
                  type="text"
                  placeholder="<?=$placeholder?>"
                  class="form-control"
                  name="<?=$buscarPor?>"
                />
                <button class="btn btn-primary" type="submit" name="buscar">
                  <i class="bi bi-search"></i>
                </button>
              </div>
            </form>
          </div>
          
          <!--Filtros para busqueda por fechas-->
          <div class="col-lg-8 col-12">
            <form class="d-flex " method="post" action="">
              <div class="input-group">
                <div class="col-12 col-lg-4 col-md-6 mx-1">
                  <input type="date" class="form-control" name="fechaDesde" />
                </div>
                <div class="col-12 col-lg-4 col-md-6 mx-1">
                  <input type="date" class="form-control" name="fechaHasta" />
                </div>
                <div class="col-12 col-lg-3 mx-1">
                  <button class="btn btn-primary w-100" type="submit" name="filtrar">
                    Filtrar
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div> <!-- Fin fila de buscador y filtros -->
      </div> <!-- Fin container buscador y filtros -->

      <?php
      //CONSULTAS A LA BDD PARA OBTENER LOS DATOS DE LOS REPORTES
      include '../consultas/reportesPromo.php';

      // Agrupar resultados por local
      $locales = [];
      if (isset($resultados) && !empty($resultados)) {
        foreach ($resultados as $fila) {
          $id_local = $fila['id_local'];
          if (!isset($locales[$id_local])) {
            $locales[$id_local] = [
                'nombre_local' => $fila['nombre_local'],
                'ubicacion' => $fila['ubicacion'],
                'rubro' => $fila['rubro'],
                'promociones' => []
            ];
          }
          $locales[$id_local]['promociones'][] = [
            'descripcion' => $fila['descripcion'],
            'cant_usos' => $fila['cant_usos'],
            'fecha_desde' => $fila['fecha_desde'],
            'fecha_hasta' => $fila['fecha_hasta'],
            'categoria' => $fila['categoria']
          ];
        }
      }
      ?>

      <!--Contaniener tabla reportes-->
      <div class="container w-75 my-3">
        <?php if(empty($locales)) {
          echo "<p class='text-center'>Aun no hay resultados.</p>";
        } else {?>
        <div class="scrollable-box ">
      
    <?php foreach($locales as $local) { ?>
      <div class="card mb-3 ">
        <div class="card-body">
          <div class="row  mb-2">
            <div class="col-md-5"><strong>LOCAL:</strong> <?php echo $local['nombre_local']?></div>
            <div class="col-md-4"><strong>UBICACIÓN:</strong> <?php echo $local['ubicacion']?></div>
            <div class="col-md-3"><strong>RUBRO:</strong> <?php echo $local['rubro']?></div>
          </div>
   
          <div class="mb-2 border-top pt-2">
          <?php foreach($local['promociones'] as $promo){ ?>
            <div class="row mb-1">
              <div class="col-sm-4"><strong>Promo:</strong> <?php echo $promo['descripcion']?></div>
              <div class="col-sm-1"><strong>Usos:</strong> <?php echo $promo['cant_usos']?></div>
              <div class="col-sm-2"><strong>Desde:</strong> <?php echo $promo['fecha_desde']?></div>
              <div class="col-sm-2"><strong>Hasta:</strong> <?php echo $promo['fecha_hasta']?></div>
              <div class="col-sm-3"><strong>Categoria:</strong> <?php echo $promo['categoria']?></div>
            </div>
            </br>
          <?php } ?>
          </div>
        </div>
      </div> <!--//Fin card -->
          <?php } //cierra foreach ?>
  
    </div> <!--//fin scrollable-->
        <?php } ?>
  </div> <!--//Fin container tabla reportes-->
</div>
</div>

    <footer class="footer mt-auto py-3 bg-body-tertiary">
      <?php include '../footer.php'; ?>
    </footer>
    
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
