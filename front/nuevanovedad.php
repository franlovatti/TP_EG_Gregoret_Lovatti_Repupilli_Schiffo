<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crear nueva novedad (ADMINISTRADOR)</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link rel="stylesheet" href="estilos/global.css" />
  
</head>

<body class="d-flex flex-column min-vh-100">

<header class="p-3 text-bg-dark">
  <?php include '../header.php'; ?>
</header>

<div class="container my-5">

<!--errores--> 

<?php
$descripcionAnterior = $_GET['form_descripcion'] ?? '';
$fechaDesdeAnterior = $_GET['form_fecha_desde'] ?? '';
$fechaHastaAnterior = $_GET['form_fecha_hasta'] ?? '';
$tipoUsuarioAnterior = $_GET['form_tipo_usuario'] ?? '';
?>

<?php if (isset($_GET['novedad_error'])) { ?>
    <div class="alert alert-danger text-center">
      <?php echo htmlspecialchars($_GET['novedad_error']); ?>
    </div>
  <?php } ?>


  <form method="post" action="crearnovedad.php">
    <button type="submit" class="btn btn-outline-primary my-1">
      <i class="bi bi-arrow-left"></i> Volver
    </button>
  </form>

  <h4>Crear nueva novedad:</h4>

  <form method="post" action="../consultas/gestionarNuevaNovedad.php" class="p-3 border rounded shadow-sm">

    <div class="mb-3">
      <label class="form-label">Descripción</label>
      <textarea 
        name="descripcion_novedad" 
        class="form-control" 
        rows="3" 
        required><?php echo htmlspecialchars($descripcionAnterior); ?></textarea>
    </div>

    
    <div class="mb-3">
      <label class="form-label">Fecha desde</label>
      <input 
        type="date" 
        name="fecha_desde" 
        class="form-control" 
        value="<?php echo htmlspecialchars($fechaDesdeAnterior); ?>"
        required>
    </div>

    
    <div class="mb-3">
      <label class="form-label">Fecha hasta</label>
      <input 
        type="date" 
        name="fecha_hasta" 
        class="form-control" 
        value="<?php echo htmlspecialchars($fechaHastaAnterior); ?>"
        required>
    </div>

   
    <div class="mb-3">
      <label class="form-label">Tipo de usuario</label>
      <select name="tipo_usuario" class="form-select" required>
        <option value="">Seleccionar...</option>
        <option value="Inicial" <?php echo $tipoUsuarioAnterior === 'Inicial' ? 'selected' : ''; ?>>Inicial</option>
        <option value="Medium" <?php echo $tipoUsuarioAnterior === 'Medium' ? 'selected' : ''; ?>>Medium</option>
        <option value="Premium" <?php echo $tipoUsuarioAnterior === 'Premium' ? 'selected' : ''; ?>>Premium</option>
      </select>
    </div>

    <div class="d-grid">
      <button type="submit" name="crear-novedad" class="btn btn-primary">
        Crear Novedad
      </button>
    </div>

  </form>

</div>

<footer class="footer mt-auto py-3 bg-body-tertiary">
  <?php include '../footer.php'; ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>