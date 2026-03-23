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

<?php if (isset($_GET['local_error'])) { ?>
  <div class="container mt-3">
    <div class="alert alert-danger mb-0"><?php echo htmlspecialchars($_GET['local_error']); ?></div>
  </div>
<?php } ?>

<?php
require_once '../conexion.php';
$query = "SELECT * FROM usuario WHERE tipo_usuario = 'dueño' AND estado='activo'";
$resultado = mysqli_query($conexion, $query);
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>
<div class="container my-5">
    <form method="post" action="crearlocal.php">
    <button type="submit" class="btn btn-outline-primary my-1">
      <i class="bi bi-arrow-left"></i> Volver
    </button>
  </form>
  <H4>Crear un nuevo local:</H4>

    <form method="post" action="../consultas/gestionarnuevolocal.php" class="p-3 border rounded shadow-sm" enctype="multipart/form-data">
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
        <select class="form-select" name="rubro" id="rubro" required>
            <option value="">Seleccionar rubro</option>
            <option value="Indumentaria">Ropa</option>
            <option value="Gastronomía">Comida</option>
            <option value="Tecnología">Tecnología</option>
            <option value="Hogar">Hogar</option>
            <option value="Deportes">Deportes</option>
            <option value="Juguetería">Juguetería</option>
          </select>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea name="descripcion" id="descripcion" class="form-control" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label for="id_usuario" class="form-label">Dueño del local</label>
        <select class="form-select" name="id_usuario" id="id_usuario" required>
            <?php while ($fila = mysqli_fetch_assoc($resultado)){
            ?> <option value="<?php echo  $fila['id_usuario'] ;?>" ><?php echo  $fila['mail_usuario'] ;?></option><?php ;}?>
        </select>
    </div>
    <div class="mb-3">
            <label for="imagen" class="form-label">Imagen del local:</label>
            <input type="file" name="imagen_local" id="imagen_local" accept="image/*" class="form-control" required>
  </div>
  <input type="hidden" name="estado" value="activo">
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
