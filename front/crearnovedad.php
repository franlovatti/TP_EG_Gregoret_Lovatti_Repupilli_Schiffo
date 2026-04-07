<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Novedades (ADMINISTRADOR)</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link rel="stylesheet" href="estilos/global.css" />
 
</head>

<body class="d-flex flex-column min-vh-100">

<header class="p-3 text-bg-dark">
  <?php include '../header.php'; ?>
</header>

<?php if (isset($_GET['novedad_error']) && !isset($_GET['edit_open'])) { ?>
  <div class="container mt-3">
    <div class="alert alert-danger mb-0"><?php echo htmlspecialchars($_GET['novedad_error']); ?></div>
  </div>
<?php } ?>

<?php if (isset($_GET['novedad_ok'])) { ?>
  <div class="container mt-3">
    <div class="alert alert-success mb-0"><?php echo htmlspecialchars($_GET['novedad_ok']); ?></div>
  </div>
<?php } ?>

<?php include '../modals/modalEditarNovedad.php'; ?>


<div class="modal fade" id="confirmDeleteModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Confirmar eliminación</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        ¿Seguro que querés eliminar esta novedad?
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a id="confirmDeleteBtn" class="btn btn-danger">Eliminar</a>
      </div>
    </div>
  </div>
</div>

<div class="container mt-4">

  <div class="card shadow">
    <div class="card-body">

      <div class="d-flex justify-content-between mb-4">
        <h3>Gestión de Novedades</h3>
      </div>

      <div class="row">
        <div class="col-lg-6 mb-4">
          <form method="post" role="search" aria-labelledby="searchNovedadLabel">
            <div class="input-group">
              <label id="searchNovedadLabel" for="buscarNovedad" class="visually-hidden">Buscar novedades por descripción</label>
              <input id="buscarNovedad" name="Buscar" class="form-control" placeholder="Buscar por descripción..." aria-describedby="searchNovedadHelp">
              <button class="btn btn-primary" aria-label="Buscar novedades">
                <i class="bi bi-search" aria-hidden="true"></i>
              </button>
            </div>
            <div id="searchNovedadHelp" class="visually-hidden">Ingrese un texto para buscar novedades.</div>
          </form>
        </div>

        <div class="col-lg-3 mb-4">
          <a href="nuevanovedad.php" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Nueva novedad
          </a>
        </div>
      </div>

<?php
require_once '../conexion.php';

$query = "SELECT * FROM novedad where estado='activo'";
$resultado = mysqli_query($conexion, $query);

$hayResultados = false;

echo "<div class='table-responsive'>";
echo "<table class='table table-hover table-bordered text-center'>";
echo "<thead class='table-dark'>
        <tr>
          <th>Descripción</th>
          <th>Desde</th>
          <th>Hasta</th>
          <th>Tipo Usuario</th>
          <th>Acciones</th>
        </tr>
      </thead>";
echo "<tbody>";

while ($fila = mysqli_fetch_assoc($resultado)) {

  if (isset($_POST["Buscar"])) {
    if (stripos($fila['descripcion_novedad'], $_POST["Buscar"]) === false) {
      continue;
    }
  }

  $hayResultados = true;

  echo "<tr>";
  echo "<td>{$fila['descripcion_novedad']}</td>";
  echo "<td>{$fila['fecha_desde']}</td>";
  echo "<td>{$fila['fecha_hasta']}</td>";
  echo "<td>{$fila['tipo_usuario']}</td>";

  echo "<td>";

  
  echo '<a href="#" class="btn btn-danger btn-sm me-2"
        data-bs-toggle="modal"
        data-bs-target="#confirmDeleteModal"
        data-id="'.$fila['id_novedad'].'"
        aria-label="Eliminar novedad '.$fila['id_novedad'].'">
        <i class="bi bi-trash" aria-hidden="true"></i>
        <span class="visually-hidden">Eliminar novedad</span>
      </a>';

  
  echo '<button class="btn btn-primary btn-sm"
        type="button"
        data-id="'.(int)$fila['id_novedad'].'"
        data-desc="'.htmlspecialchars($fila['descripcion_novedad'], ENT_QUOTES, 'UTF-8').'"
        data-desde="'.htmlspecialchars($fila['fecha_desde'], ENT_QUOTES, 'UTF-8').'"
        data-hasta="'.htmlspecialchars($fila['fecha_hasta'], ENT_QUOTES, 'UTF-8').'"
        data-tipo="'.htmlspecialchars(trim((string)$fila['tipo_usuario']), ENT_QUOTES, 'UTF-8').'"
        data-bs-toggle="modal"
        data-bs-target="#modalEditarNovedad"
        aria-label="Editar novedad '.$fila['id_novedad'].'">
        <i class="bi bi-pencil" aria-hidden="true"></i>
        <span class="visually-hidden">Editar novedad</span>
      </button>';

  echo "</td>";
  echo "</tr>";
}

echo "</tbody></table>";
echo "</div>";

if (!$hayResultados) {
  echo "<div class='alert alert-info text-center'>No hay novedades</div>";
}

mysqli_close($conexion);
?>

    </div>
  </div>
</div>

<footer class="mt-auto">
  <?php include '../footer.php'; ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

document.getElementById('confirmDeleteModal')
.addEventListener('show.bs.modal', function (event) {
  const button = event.relatedTarget;
  const id = button.getAttribute('data-id');

  document.getElementById('confirmDeleteBtn').href =
    '../consultas/eliminarNovedad.php?id=' + id;
});


function normalizarTipoUsuario(valor) {
  const tipo = (valor || '').toString().trim().toLowerCase();
  if (tipo === 'inicial') {
    return 'Inicial';
  }
  if (tipo === 'medium' || tipo === 'medio') {
    return 'Medium';
  }
  if (tipo === 'premium') {
    return 'Premium';
  }
  return '';
}

function setTipoUsuarioEnSelect(valor) {
  const selectTipo = document.getElementById("modal-tipo");
  const tipoNormalizado = normalizarTipoUsuario(valor);

  if (tipoNormalizado) {
    selectTipo.value = tipoNormalizado;
    return;
  }

  const valorOriginal = (valor || '').toString().trim().toLowerCase();
  const opcionCoincidente = Array.from(selectTipo.options).find(function (opt) {
    return opt.value.toLowerCase() === valorOriginal || opt.text.toLowerCase() === valorOriginal;
  });

  if (opcionCoincidente) {
    selectTipo.value = opcionCoincidente.value;
    return;
  }

  selectTipo.selectedIndex = 0;
}

document.getElementById('modalEditarNovedad')
.addEventListener('show.bs.modal', function (event) {
  const button = event.relatedTarget;

  document.getElementById("modal-id").value =
    button.getAttribute('data-id');

  document.getElementById("modal-desc").value =
    button.getAttribute('data-desc');

  document.getElementById("modal-desde").value =
    button.getAttribute('data-desde');

  document.getElementById("modal-hasta").value =
    button.getAttribute('data-hasta');

  setTipoUsuarioEnSelect(button.getAttribute('data-tipo'));
});

<?php
$editOpen = isset($_GET['edit_open']) ? (int)$_GET['edit_open'] : 0;
$editId = $_GET['edit_id'] ?? '';
$editDesc = $_GET['edit_desc'] ?? '';
$editDesde = $_GET['edit_desde'] ?? '';
$editHasta = $_GET['edit_hasta'] ?? '';
$editTipo = $_GET['edit_tipo'] ?? '';
?>

if (<?php echo json_encode($editOpen === 1); ?>) {
  const modalElement = document.getElementById('modalEditarNovedad');
  const modal = new bootstrap.Modal(modalElement);

  document.getElementById("modal-id").value = <?php echo json_encode($editId); ?>;
  document.getElementById("modal-desc").value = <?php echo json_encode($editDesc); ?>;
  document.getElementById("modal-desde").value = <?php echo json_encode($editDesde); ?>;
  document.getElementById("modal-hasta").value = <?php echo json_encode($editHasta); ?>;
  setTipoUsuarioEnSelect(<?php echo json_encode($editTipo); ?>);

  modal.show();
}

function obtenerFechaLocalISO() {
  const ahora = new Date();
  const anio = ahora.getFullYear();
  const mes = String(ahora.getMonth() + 1).padStart(2, '0');
  const dia = String(ahora.getDate()).padStart(2, '0');
  return anio + '-' + mes + '-' + dia;
}

const hoyEdicionNovedad = obtenerFechaLocalISO();
const formEditarNovedad = document.getElementById('formEditarNovedad');
const fechaDesdeEditarNovedad = document.getElementById('modal-desde');
const fechaHastaEditarNovedad = document.getElementById('modal-hasta');

function limpiarErroresFechaEdicion() {
  formEditarNovedad.querySelectorAll('.error-fecha').forEach(function (el) {
    el.remove();
  });
}

function mostrarErrorFechaEdicion(campo, mensaje) {
  const error = document.createElement('div');
  error.className = 'text-danger small mt-1 error-fecha';
  error.textContent = mensaje;
  campo.parentNode.appendChild(error);
}

fechaDesdeEditarNovedad.min = hoyEdicionNovedad;
fechaHastaEditarNovedad.min = hoyEdicionNovedad;

fechaDesdeEditarNovedad.addEventListener('change', function () {
  fechaHastaEditarNovedad.min = this.value || hoyEdicionNovedad;
  if (fechaHastaEditarNovedad.value && fechaHastaEditarNovedad.value < this.value) {
    fechaHastaEditarNovedad.value = '';
  }
});

formEditarNovedad.addEventListener('submit', function (e) {
  let valido = true;

  limpiarErroresFechaEdicion();

  if (fechaDesdeEditarNovedad.value < hoyEdicionNovedad) {
    mostrarErrorFechaEdicion(fechaDesdeEditarNovedad, 'La fecha desde no puede ser anterior a hoy.');
    valido = false;
  }

  if (fechaHastaEditarNovedad.value < fechaDesdeEditarNovedad.value) {
    mostrarErrorFechaEdicion(fechaHastaEditarNovedad, 'La fecha hasta debe ser mayor o igual a la fecha desde.');
    valido = false;
  }

  if (!valido) {
    e.preventDefault();
  }
});
</script>

</body>
</html>