<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Locales (ADMINISTRADOR)</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
<link rel="stylesheet" href="estilos/global.css" />
  
  </style>
</head>

<body class="d-flex flex-column min-vh-100">

<header class="p-3 text-bg-dark">
  <?php include '../header.php'; ?>
</header>

<?php if (isset($_GET['local_error'])) { ?>
  <div class="container mt-3">
    <div class="alert alert-danger mb-0"><?php echo htmlspecialchars($_GET['local_error']); ?></div>
  </div>
<?php } ?>

<?php if (isset($_GET['local_ok'])) { ?>
  <div class="container mt-3">
    <div class="alert alert-success mb-0"><?php echo htmlspecialchars($_GET['local_ok']); ?></div>
  </div>
<?php } ?>

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

<div class="container mt-4">

  <div class="card shadow mb-4">
    <div class="card-body">

      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Gestión de Locales</h3>
      </div>

      <!-- Barra de busqueda -->
      <div class="row">
        <div class="col-lg-6 col-12 mb-4">
          <form class="d-flex" method="post" action="">
            <label for="buscar" class="visually-hidden">Buscar local</label>
            <div class="input-group">
              <input name="Buscar" type="text" class="form-control" placeholder="Buscar por nombre..." />
              <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </form>
          <?php if (isset($_POST["Buscar"]) && !empty(trim($_POST["Buscar"]))) { ?>
            <div class="mt-2">
              <form method="post" action="">
                <button type="submit" class="btn btn-outline-primary my-1">
                  <i class="bi bi-arrow-left"></i> Mostrar todos
                </button>
              </form>
            </div>
          <?php } ?>
        </div>
        <div class="col-lg-3 col-12 mb-4">
          <a href="nuevolocal.php" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Nuevo local
          </a>
      </div>

<?php
require_once '../conexion.php';

$query = "SELECT l.*, u.mail_usuario 
          FROM local l 
          INNER JOIN usuario u on l.id_usuario = u.id_usuario
          where l.estado='activo'";
$resultado = mysqli_query($conexion, $query);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

$hayResultados = false;

echo "<div class='table-responsive'>";
echo "<table class='table table-hover table-bordered align-middle text-center'>";
echo "<thead class='table-dark'>
        <tr>
          <th>Nombre</th>
          <th>Ubicación</th>
          <th>Rubro</th>
          <th>Dueño</th>
          <th>Descripción</th>
          <th>Acciones</th>
        </tr>
      </thead>";
echo "<tbody>";

while ($fila = mysqli_fetch_assoc($resultado)) {

    if (isset($_POST["Buscar"])) {
        if (stripos($fila['nombre_local'], $_POST["Buscar"]) === false) {
            continue;
        }
    }

    $hayResultados = true;

    echo "<tr>";
    echo "<td>" . $fila['nombre_local'] . "</td>";
    echo "<td>" . $fila['ubicacion'] . "</td>";
    echo "<td>" . $fila['rubro'] . "</td>";
    echo "<td>" . $fila['mail_usuario'] . "</td>";
    echo "<td>" . $fila['descripcion'] . "</td>";

    echo "<td>";

    echo '<a href="#" class="btn btn-danger btn-sm me-2"
        data-bs-toggle="modal"
        data-bs-target="#confirmDeleteModal"
        data-id="' . $fila['id_local'] . '">
        <i class="bi bi-trash"></i>
    </a>';

    echo '<button type="button" class="btn btn-primary btn-sm"
        data-id="' .$fila['id_local'].'"
        data-nombre="' . $fila['nombre_local'] . '"
        data-ubicacion="' . $fila['ubicacion'] . '"
        data-rubro="' . $fila['rubro'] . '"
        data-usuario="' . $fila['id_usuario'] . '"
        data-desc="' . $fila['descripcion'] . '"
        data-bs-toggle="modal"
        data-bs-target="#modalEditarLocal">
        <i class="bi bi-pencil"></i>
    </button>';

    echo "</td>";
    echo "</tr>";
}

echo "</tbody></table>";
echo "</div>";

if (!$hayResultados) {
    echo "<p class='text-center text-danger mt-3'>NO HAY RESULTADOS</p>";
}

mysqli_close($conexion);
?>

    </div>
  </div>
</div>
</div>

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
    confirmBtn.href = '../consultas/eliminarlocal.php?id=' + idLocal;
  });


  const modalEditarLocal = document.getElementById('modalEditarLocal');

  modalEditarLocal.addEventListener('show.bs.modal',function (event){

    const button = event.relatedTarget;

    const idLocal = button.getAttribute('data-id');
    const nombre = button.getAttribute('data-nombre');
    const ubicacion = button.getAttribute('data-ubicacion');
    const rubro = button.getAttribute('data-rubro');
    const idUsuario = button.getAttribute('data-usuario');
    const descripcion = button.getAttribute('data-desc');

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