<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Locales (ADMINISTRADOR)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <style>
    .scrollable-box {
      max-height: 400px;
      overflow-y: auto;
      border: 1px solid #ccc;
      padding: 10px;
    }
    footer {
      background-color: #f8f9fa;
      padding: 20px 0;
      text-align: center;
      font-size: 0.9rem;
    }
    .texto-destacado {
    color: #e91e63; 
    font-weight: bold;
    }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">


<header class="p-3 text-bg-dark">
  <?php include '../header.php'; ?>
</header>
<?php include '../modals/modalEditarLocal.php'; ?>
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        ¿Seguro que deseas eliminar este local? Esta acción no se puede deshacer.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Eliminar</a>
      </div>
    </div>
  </div>
</div>
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
              placeholder="nombre del local..."
            />
            <button class="btn btn-primary" type="submit">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </form>
      </div>
      <div class="col-12 col-lg-3">
        <a href="nuevolocal.php">Crear nuevo local...</a>
      </div>
    </div>
  </div>


<?php
require_once '../conexion.php';
$query = "SELECT * FROM local";
$resultado = mysqli_query($conexion, $query);
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}


if (isset($_POST["Buscar"])){
    while ($fila = mysqli_fetch_assoc($resultado)) {
        if($fila['nombre_local']==$_POST["Buscar"]){
            $bandera=1;
            echo "<table class='table table-bordered'>";
            echo "<thead><tr><th>id_local</th><th>Nombre_local</th><th>Ubicación</th><th>Rubro</th><th>id_usuario</th><th>Desc</th></tr></thead>";
            echo "<tbody>";
            echo "<tr>";
            echo "<td>" . $fila['id_local'] . "</td>";
            echo "<td>" . $fila['nombre_local'] . "</td>";
            echo "<td>" . $fila['ubicacion'] . "</td>";
            echo "<td>" . $fila['rubro'] . "</td>";
            echo "<td>" . $fila['id_usuario'] . "</td>";
            echo "<td>" . $fila['descripcion'] . "</td>";
            echo '<td><a href="#" class="btn btn-danger btn-sm" 
            data-bs-toggle="modal" 
            data-bs-target="#confirmDeleteModal" 
            data-id="' . $fila['id_local'] . '">Eliminar local</a>';
            echo '<button type="button" class=" ms-2 btn btn-primary btn-sm" data-id="' .$fila['id_local'].'"
        data-nombre="' . $fila['nombre_local'] . '"
            data-ubicacion="' . $fila['ubicacion'] . '"
            data-rubro="' . $fila['rubro'] . '"
            data-usuario="' . $fila['id_usuario'] . '"
            data-desc="' . $fila['descripcion'] . '" data-bs-toggle="modal" data-bs-target="#modalEditarLocal">Editar local</button></td>';
            echo "</tr>";
            
        }
    }
    echo "</tbody></table>";
    if(!isset($bandera)){
        echo "<p class='text-center text-danger mt-3'>NO HAY LOCAL CON ESE NOMBRE</p>";
    }
}
else {
        echo "<table class='table table-bordered'>";
        echo "<thead><tr><th>id_local</th><th>Nombre_local</th><th>Ubicación</th><th>Rubro</th><th>id_usuario</th><th>Desc</th></tr></thead>";
        echo "<tbody>";
       while ($fila = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        echo "<td>" . $fila['id_local'] . "</td>";
        echo "<td>" . $fila['nombre_local'] . "</td>";
        echo "<td>" . $fila['ubicacion'] . "</td>";
        echo "<td>" . $fila['rubro'] . "</td>";
        echo "<td>" . $fila['id_usuario'] . "</td>";
        echo "<td>" . $fila['descripcion'] . "</td>";
        echo '<td><a href="#" class="btn btn-danger btn-sm " 
            data-bs-toggle="modal" 
            data-bs-target="#confirmDeleteModal" 
            data-id="' . $fila['id_local'] . '">Eliminar local</a>';
        echo '<button type="button" class=" ms-2 btn btn-primary btn-sm" data-id="' .$fila['id_local'].'"
        data-nombre="' . $fila['nombre_local'] . '"
            data-ubicacion="' . $fila['ubicacion'] . '"
            data-rubro="' . $fila['rubro'] . '"
            data-usuario="' . $fila['id_usuario'] . '"
            data-desc="' . $fila['descripcion'] . '" data-bs-toggle="modal" data-bs-target="#modalEditarLocal">Editar local</button></td>';
            echo "</tr>";
    }
    echo "</tbody></table>";
} 
mysqli_close($conexion);
?>
<footer class="footer mt-auto py-3 bg-body-tertiary">
  <?php include '../footer.php'; ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const confirmDeleteModal = document.getElementById('confirmDeleteModal');
  confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const idLocal = button.getAttribute('data-id');
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    confirmBtn.href = 'eliminarlocal.php?id=' + idLocal;
  });

  const modalEditarModal=document.getElementById('modalEditarLocal');
  modalEditarLocal.addEventListener('show.bs.modal',function (event){
    const button=event.relatedTarget;
    const idLocal=button.getAttribute('data-id');
    const nombre=button.getAttribute('data-nombre');
    const ubicacion=button.getAttribute('data-ubicacion');
    const rubro=button.getAttribute('data-rubro');
    const idUsuario=button.getAttribute('data-usuario');
    const descripcion=button.getAttribute('data-desc');
    
    

    document.getElementById("modal-id").value = idLocal;
    document.getElementById("modal-nombre").value = nombre;
    document.getElementById("modal-ubicacion").value = ubicacion;
    document.getElementById("modal-rubro").value = rubro;
    document.getElementById("modal-usuario").value = idUsuario;
    document.getElementById("modal-desc").value = descripcion;
    
  });
  

</script>
</body>
</html>