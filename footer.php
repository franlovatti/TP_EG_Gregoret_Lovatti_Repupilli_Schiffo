<ul class="nav justify-content-center border-bottom pb-3 mb-3">
<?php
if ($tipoUsuario == 'cliente') {
?>
  <li class="nav-item">
    <a href="home.php" class="nav-link px-2 text-body-secondary">Inicio</a>
  </li>
  <li class="nav-item">
    <a href="acercaDe.php" class="nav-link px-2 text-body-secondary">Acerca del shopping</a>
  </li>
  <li class="nav-item">
    <a href="locales.php" class="nav-link px-2 text-body-secondary">Locales</a>
  </li>
  <li class="nav-item">
    <a href="promociones.php" class="nav-link px-2 text-body-secondary">Promociones</a>
  </li>
  <li class="nav-item">
    <a href="misPromociones.php" class="nav-link px-2 text-body-secondary">Mis promociones</a>
  </li>
<?php
} elseif ($tipoUsuario == 'dueño') {
  if (isset($_SESSION['estado']) && $_SESSION['estado'] === 'activo') {
?>
  <li class="nav-item">
    <a href="home.php" class="nav-link px-2 text-body-secondary">Inicio</a>
  </li>
  <li class="nav-item">
    <a href="local.php" class="nav-link px-2 text-body-secondary">Local</a>
  </li>
  <li class="nav-item">
    <a href="" class="nav-link px-2 text-body-secondary">Promociones</a>
  </li>
  <li class="nav-item">
    <a href="" class="nav-link px-2 text-body-secondary">Solicitudes</a>
  </li>
  <?php
  } else {
  ?>
  <ul class="navbar-nav mb-2 mb-lg-0">
    <li class="nav-item">
      <a class="nav-link px-2 text-warning">Cuenta pendiente de aprobación</a>
    </li>
  </ul>
<?php
  }
} elseif ($tipoUsuario == 'administrador') {
?>
  <li class="nav-item">
    <a href="" class="nav-link px-2 text-body-secondary">Solicitudes usuario</a>
  </li>
  <li class="nav-item">
    <a href="" class="nav-link px-2 text-body-secondary">Solicitudes promociones</a>
  </li>
  <li class="nav-item">
    <a href="" class="nav-link px-2 text-body-secondary">Locales</a>
  </li>
  <li class="nav-item">
    <a href="" class="nav-link px-2 text-body-secondary">Novedades</a>
  </li>
  <li class="nav-item">
    <a href="" class="nav-link px-2 text-body-secondary">Reportes</a>
  </li>
<?php
} else {
?>
  <li class="nav-item">
    <a href="home.php" class="nav-link px-2 text-body-secondary">Inicio</a>
  </li>
  <li class="nav-item">
    <a href="acercaDe.php" class="nav-link px-2 text-body-secondary">Acerca del shopping</a>
  </li>
  <li class="nav-item">
    <a href="locales.php" class="nav-link px-2 text-body-secondary">Locales</a>
  </li>
  <li class="nav-item">
    <a href="promociones.php" class="nav-link px-2 text-body-secondary">Promociones</a>
  </li>
<?php
}
?>
</ul>
<div
  class="container d-flex flex-wrap justify-content-between align-items-center"
>
  <div class="col-sm-3 d-flex align-items-center">
    <span class="mb-md-0 text-body-secondary">© 2025 Company, Inc</span>
  </div>
  <div class="col-sm-3 d-flex justify-content-center">
    <a
      href=""
      class="nav-link px-2 text-body-secondary align-items-center"
      >Terminos y Condiciones</a
    >
  </div>
  <ul class="nav col-sm-3 justify-content-end list-unstyled d-flex">
    <li class="ms-3">
      <a class="text-body-secondary" href="#" aria-label="Instagram">
        <img
          src="imagenes/logoIG.png"
          alt="logoIG"
          width="24"
          height="24"
        />
      </a>
    </li>
    <li class="ms-3">
      <a class="text-body-secondary" href="#" aria-label="Facebook">
        <img
          src="imagenes/logoFB.png"
          alt="logoFB"
          width="24"
          height="24"
        />
      </a>
    </li>
  </ul>
</div>