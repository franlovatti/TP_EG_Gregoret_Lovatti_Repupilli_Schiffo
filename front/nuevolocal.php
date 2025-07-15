<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crear un nuevo local (ADMINISTRADOR)</title>
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
$query = "SELECT * FROM usuario WHERE tipo_usuario = 'dueño' AND estado='activo'";
$resultado = mysqli_query($conexion, $query);
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>
<div class="container my-5">
  <H4>Crear un nuevo local:</H4>

    <form method="post" action="gestionarnuevolocal.php" class="p-3 border rounded shadow-sm">
    <div class="mb-3">
        <label for="nombre_local" class="form-label">Nombre del local</label>
        <input type="text" name="nombre_local" id="nombre_local" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="ubicacion" class="form-label">Ubicación</label>
        <input type="text" name="ubicacion" id="ubicacion" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="rubro" class="form-label">Rubro</label>
        <input type="text" name="rubro" id="rubro" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea name="descripcion" id="descripcion" class="form-control" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label for="id_usuario" class="form-label">Id del dueño del local</label>
        <select class="form-select" name="id_usuario" id="id_usuario" required>
            <?php while ($fila = mysqli_fetch_assoc($resultado)){
            ?> <option value="<?php echo  $fila['id_usuario'] ;?>" ><?php echo  $fila['id_usuario'] ;?></option><?php ;}?>
        </select>
    </div>
    <div class="d-grid">
        <button type="submit" name="crear-local" class="btn btn-primary">Crear Local</button>
    </div>

    </form>
</div>
<?php
mysqli_close($conexion);
?>

<footer class="footer mt-auto py-3 bg-body-tertiary">
  <?php include '../footer.php'; ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 
