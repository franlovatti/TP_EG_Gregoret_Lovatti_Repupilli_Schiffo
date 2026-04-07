<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crear un nueva promoción (dueño)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link rel="stylesheet" href="estilos/global.css" />
  <style>
    .form-check-input {
      transform: scale(1.5);
      margin-right: 10px;
    }
    .form-check-label {
      font-size: 1.1em;
    }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">

<header class="p-3 text-bg-dark">
  <?php include '../header.php'; ?>
</header>

<?php if (isset($_GET['promo_error'])) { ?>
    <div class="container mt-3">
        <div class="alert alert-danger mb-0"><?php echo htmlspecialchars($_GET['promo_error']); ?></div>
    </div>
<?php } ?>

<?php
require_once '../conexion.php';
if(isset($_SESSION['idUsuario'])){
  $id_usuario=$_SESSION['idUsuario'];
}
$query = "SELECT * from local WHERE id_usuario = $id_usuario";
$resultado = mysqli_query($conexion, $query);
if ($resultado && mysqli_num_rows($resultado) > 0) {
    $fila = mysqli_fetch_assoc($resultado);
    //$id_local=$fila["id_local"];
    ?>
    <div class="container my-5">
    <H4>Crear un nueva promoción:</H4>

        <form id="formNuevaPromocion" method="post" action="../consultas/gestionarnuevapromocion.php" class="p-3 border rounded shadow-sm" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="id_local" class="form-label">Local</label>
            <select class="form-select" name="id_local" id="id_local" required>
            <?php
            foreach($resultado as $fila) {
                echo "<option value='{$fila['id_local']}'>{$fila['nombre_local']}</option>";
            }
            ?>    
            </select>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <input type="text" name="descripcion" id="descripcion" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="fecha_desde" class="form-label">Fecha desde</label>
            <input type="date" name="fecha_desde" id="fecha_desde" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="fecha_hasta" class="form-label">Fecha_hasta</label>
            <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría de promoción:</label>
            <select class="form-select" name="categoria" id="categoria" required>
                <option value="inicial" >inicial</option>
                <option value="medium" >medium</option>
                <option value="premium" >premium</option>
            </select>
        </div>
        <div class="mb-3" id="grupo-dias-promocion">
             <label for="dias_disponibles" class="form-label">Días disponibles:</label><br>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="lunes" name="lunes" value="1">
                <label class="form-check-label" for="lunes">Lunes</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="martes" name="martes" value="1">
                <label class="form-check-label" for="martes">Martes</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="miercoles" name="miercoles" value="1">
                <label class="form-check-label" for="miercoles">Miércoles</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="jueves" name="jueves" value="1">
                <label class="form-check-label" for="jueves">Jueves</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="viernes" name="viernes" value="1">
                <label class="form-check-label" for="viernes">Viernes</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="sabado" name="sabado" value="1">
                <label class="form-check-label" for="sabado">Sábado</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="domingo" name="domingo" value="1">
                <label class="form-check-label" for="domingo">Domingo</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen de la promoción:</label>
            <input type="file" name="imagen_prom" id="imagen_prom" accept="image/*" class="form-control"  required>
        </div>
        <input type="hidden" name="estado" value="pendiente">
        <div class="d-grid">
            <button type="submit" name="crear_promocion" class="btn btn-primary">Crear promoción</button>
        </div>
        </form>
    </div>
    
<?php }else {
    echo "<div class='alert alert-info text-center my-5'>Hay un problema con el id del dueño</div>";
}
?>

<footer class="footer mt-auto py-3 bg-body-tertiary">
  <?php include '../footer.php'; ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function obtenerFechaLocalISO() {
    const ahora = new Date();
    const anio = ahora.getFullYear();
    const mes = String(ahora.getMonth() + 1).padStart(2, '0');
    const dia = String(ahora.getDate()).padStart(2, '0');
    return anio + '-' + mes + '-' + dia;
}

const hoy = obtenerFechaLocalISO();

const formNuevaPromocion = document.getElementById('formNuevaPromocion');
const fechaDesde = document.getElementById('fecha_desde');
const fechaHasta = document.getElementById('fecha_hasta');
const grupoDiasPromocion = document.getElementById('grupo-dias-promocion');
const checksDiasPromocion = grupoDiasPromocion.querySelectorAll('input[type="checkbox"]');

function hayAlMenosUnDiaSeleccionado() {
    return Array.from(checksDiasPromocion).some(function (checkbox) {
        return checkbox.checked;
    });
}

// Fecha mínima = hoy para ambos campos
fechaDesde.min = hoy;
fechaHasta.min = hoy;

// Cuando cambia fecha desde, fecha hasta debe ser mayor  o igual
fechaDesde.addEventListener('change', function() {
    fechaHasta.min = this.value;
    if (fechaHasta.value && fechaHasta.value <= this.value) {
        fechaHasta.value = '';
    }
});

// Validar al enviar el formulario
formNuevaPromocion.addEventListener('submit', function(e) {
    let valido = true;

    // Limpiar errores previos
    document.querySelectorAll('.error-fecha').forEach(el => el.remove());
    document.querySelectorAll('.error-dia').forEach(el => el.remove());

    if (fechaDesde.value < hoy) {
        const error = document.createElement('div');
        error.className = 'text-danger small mt-1 error-fecha';
        error.textContent = 'La fecha desde no puede ser anterior a hoy.';
        fechaDesde.parentNode.appendChild(error);
        valido = false;
    }

    if (fechaHasta.value < fechaDesde.value) {
        const error = document.createElement('div');
        error.className = 'text-danger small mt-1 error-fecha';
        error.textContent = 'La fecha hasta debe ser mayor a la fecha desde.';
        fechaHasta.parentNode.appendChild(error);
        valido = false;
    }

    if (!hayAlMenosUnDiaSeleccionado()) {
        const error = document.createElement('div');
        error.className = 'text-danger small mt-1 error-dia';
        error.textContent = 'Debes seleccionar al menos un dia disponible.';
        grupoDiasPromocion.appendChild(error);
        valido = false;
    }

    if (!valido) {
        e.preventDefault();
    }
});
</script>
</body>
</html> 