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
    <div class="container-fluid">
      <div class="container w-75 py-5">
        <div class="row gy-1">
          <div class="col-lg-4 col-12">
            <form class="d-flex" method="post" action="">
              <div class="input-group">
                <input
                  type="text"
                  placeholder="Buscar por local"
                  class="form-control"
                  name="buscarPorLocal"
                />
                <button class="btn btn-primary" type="submit">
                  <i class="bi bi-search"></i>
                </button>
              </div>
            </form>
          </div>
          <div class="col-lg-8 col-12">
            <form class="d-flex " method="post" action="">
              <div class="input-group">
                <div class="col-12 col-lg-4 col-md-6">
                  <input type="date" class="form-control" name="fechaDesde" />
                </div>
                <div class="col-12 col-lg-4 col-md-6">
                  <input type="date" class="form-control" name="fechaHasta" />
                </div>
                <div class="col-12 col-lg-4">
                  <button class="btn btn-primary w-100" type="submit">
                    Filtrar
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>



       <div class="container w-75 ">
        <div class="scrollable-box ">
      
    <?php for($i = 1; $i <= 11; $i++) { ?>
      <div class="card mb-3 ">
        <div class="card-body">
          <div class="row  mb-2">
            <div class="col-md-2"><strong>ID LOCAL:</strong><?php echo "$i" ?></div>
            <div class="col-md-3"><strong>NOMBRE:</strong> <?php echo "Nombre $i"?></div>
            <div class="col-md-2"><strong>UBICACIÓN:</strong> <?php echo "Ubicacion $i"?></div>
            <div class="col-md-3"><strong>RUBRO:</strong> <?php echo "Rubro $i"?></div>
            <div class="col-md-2"><strong>CODUSUARIO:</strong> <?php echo "CodUsuario $i"?></div>
          </div>
   
          <div class="mb-2 border-top pt-2">
            

            <?php for($j = 1; $j < 4; $j++) { ?>
              <div class="row mb-1">
                <div class="col-sm-4"><strong>Texto:</strong> <?php echo "$j"?></div>
                <div class="col-sm-1"><strong>Usos:</strong> <?php echo "$j"?></div>
                <div class="col-sm-2"><strong>Desde:</strong> <?php echo "Fecha Desde $j"?></div>
                <div class="col-sm-2"><strong>Hasta:</strong> <?php echo "Fecha Hasta $j"?></div>
                <div class="col-sm-3"><strong>Nivel:</strong> <?php echo "Nivel $j"?></div>
              </div>
              </br>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php } ?>
  

          </div>

        </div>


        
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
