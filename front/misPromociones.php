<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MIS PROMOCIONES (CLIENTES)</title>
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

<!-- Buscador -->
<div class="container my-4">
  <div class="row g-2">
    <div class="col-md-8">
      <input type="text" class="form-control" placeholder="BUSCADOR (id local)">
    </div>
    <div class="col-md-4">
      <select class="form-select">
        <option selected>ESTADO (desplegable)</option>
        <option value="1">Activo</option>
        <option value="2">Pendiente</option>
        <option value="3">Cerrado</option>
      </select>
    </div>
  </div>
</div>

<!-- Lista de solicitudes -->
<div class="container">
  <div class="scrollable-box">
    <!-- Repite este bloque para simular múltiples entradas -->
    <div class="border-bottom py-2">NOMBRE | FECHA SOLICITUD | ESTADO</div>
    <div class="border-bottom py-2">NOMBRE | FECHA SOLICITUD | ESTADO</div>
    <div class="border-bottom py-2">NOMBRE | FECHA SOLICITUD | ESTADO</div>
    <div class="border-bottom py-2">NOMBRE | FECHA SOLICITUD | ESTADO</div>
    <div class="border-bottom py-2">NOMBRE | FECHA SOLICITUD | ESTADO</div>
    <div class="border-bottom py-2">NOMBRE | FECHA SOLICITUD | ESTADO</div>
    <div class="border-bottom py-2">NOMBRE | FECHA SOLICITUD | ESTADO</div>
    <div class="border-bottom py-2">NOMBRE | FECHA SOLICITUD | ESTADO</div>
    <div class="border-bottom py-2">NOMBRE | FECHA SOLICITUD | ESTADO</div>
    <div class="border-bottom py-2">NOMBRE | FECHA SOLICITUD | ESTADO</div>
    <div class="border-bottom py-2">NOMBRE | FECHA SOLICITUD | ESTADO</div>
    <div class="border-bottom py-2">NOMBRE | FECHA SOLICITUD | ESTADO</div>
    <div class="border-bottom py-2">NOMBRE | FECHA SOLICITUD | ESTADO</div>
    <div class="border-bottom py-2">NOMBRE | FECHA SOLICITUD | ESTADO</div>
    <div class="border-bottom py-2">NOMBRE | FECHA SOLICITUD | ESTADO</div>
  </div>
</div>

<footer class="footer mt-auto py-3 bg-body-tertiary">
  <?php include '../footer.php'; ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>