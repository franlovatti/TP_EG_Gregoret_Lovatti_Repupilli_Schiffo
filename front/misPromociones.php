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
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
      <li class="nav-item"><a href="home.html" class="nav-link px-2 text-body-secondary">Inicio</a></li>
      <li class="nav-item"><a href="acercaDe.html" class="nav-link px-2 text-body-secondary">Acerca del shopping</a></li>
      <li class="nav-item"><a href="locales.php" class="nav-link px-2 text-body-secondary">Locales</a></li>
      <li class="nav-item"><a href="promociones.html" class="nav-link px-2 text-body-secondary">Promociones</a></li>
    </ul> 
    <div class="container d-flex flex-wrap justify-content-between align-items-center">
      <div class="col-sm-3 d-flex align-items-center">
        <span class=" mb-md-0 text-body-secondary">© 2025 Company, Inc</span> 
      </div>
      <div class="col-sm-3 d-flex justify-content-center">
        <a href="" class="nav-link px-2 text-body-secondary align-items-center">Terminos y Condiciones</a> 
      </div>
      <ul class="nav col-sm-3 justify-content-end list-unstyled d-flex"> 
        <li class="ms-3">
          <a class="text-body-secondary" href="#" aria-label="Instagram">
            <img src="imagenes/logoIG.png" alt="logoIG" width="24" height="24">
          </a>
        </li> 
        <li class="ms-3">
          <a class="text-body-secondary" href="#" aria-label="Facebook">
            <img src="imagenes/logoFB.png" alt="logoFB" width="24" height="24">
          </a>
        </li> 
      </ul>
    </div>
  </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>