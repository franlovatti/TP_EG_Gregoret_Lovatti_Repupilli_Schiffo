<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crear un nueva promoción (dueño)</title>
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
    color: #e91e63; /* rosa intenso como ejemplo */
    font-weight: bold;
    }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">

<header class="p-3 text-bg-dark">
  <?php include '../header.php'; ?>
</header>

<?php
require_once '../conexion.php';
if(isset($_SESSION['idUsuario'])){
  $id_usuario=$_SESSION['idUsuario'];
}
$query = "SELECT * from local WHERE id_usuario = $id_usuario";
$resultado = mysqli_query($conexion, $query);
if ($resultado && mysqli_num_rows($resultado) > 0) {
    $fila = mysqli_fetch_assoc($resultado);
    $id_local=$fila["id_local"];
    ?>
    <div class="container my-5">
    <H4>Crear un nueva promoción:</H4>

        <form method="post" action="gestionarnuevapromocion.php" class="p-3 border rounded shadow-sm" enctype="multipart/form-data">
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
        <div class="mb-3">
            <label for="lunes" class="form-label">Disponible día lunes:</label>
            <select class="form-select" name="lunes" id="lunes" required>
                <option value="0" selected>No</option>
                <option value="1">Sí</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="martes" class="form-label">Disponible día martes:</label>
            <select class="form-select" name="martes" id="martes" required>
                <option value="0" selected>No</option>
                <option value="1">Sí</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="miercoles" class="form-label">Disponible día miercoles:</label>
            <select class="form-select" name="miercoles" id="miercoles" required>
                <option value="0" selected>No</option>
                <option value="1">Sí</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="jueves" class="form-label">Disponible día jueves:</label>
            <select class="form-select" name="jueves" id="jueves" required>
                <option value="0" selected>No</option>
                <option value="1">Sí</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="viernes" class="form-label">Disponible día viernes:</label>
            <select class="form-select" name="viernes" id="viernes" required>
                <option value="0" selected>No</option>
                <option value="1">Sí</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="sabado" class="form-label">Disponible día sabado:</label>
            <select class="form-select" name="sabado" id="sabado" required>
                <option value="0" selected>No</option>
                <option value="1">Sí</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="domingo" class="form-label">Disponible día domingo:</label>
            <select class="form-select" name="domingo" id="domingo" required>
                <option value="0" selected>No</option>
                <option value="1">Sí</option>
            </select>
        </div>
        <input type="hidden" name="id_local" value="<?= $id_local ?>">
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
</body>
</html> 