<?php
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $tipoUsuario = $_SESSION['tipoUsuario'];
    $login = True;
} else {
    $usuario = null;
    $tipoUsuario = 'invitado';
    $login = False;    
}
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a
      href="home.php"
      class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none"
    >
      <img
        src="imagenes/logoHome.png"
        alt="Logo"
        width="30"
        height="24"
        class="me-2"
      />
    </a>
    <ul
      class="text-white ms-3 me-3"
      style="
        list-style: none;
        padding-left: 0;
        margin: 0;
        font-size: x-small;
      "
    >
      <li>Lunes a Viernes 10:00-20:00</li>
      <li>Sábados 10:00-18:00</li>
    </ul>
    <!-- Botón hamburguesa -->
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarOpciones"
      aria-controls="navbarOpciones"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Opciones de menú -->
    <div class="collapse navbar-collapse" id="navbarOpciones">
<?php
if ($tipoUsuario == 'cliente') {
?>
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item">
          <a href="acercaDe.php" class="nav-link px-2 text-white">Acerca del shopping</a>
        </li>
        <li class="nav-item">
          <a href="locales.php" class="nav-link px-2 text-white">Locales</a>
        </li>
        <li class="nav-item">
          <a href="promociones.php" class="nav-link px-2 text-white">Promociones</a>
        </li>
        <li class="nav-item">
          <a href="mispromociones.php" class="nav-link px-2 text-white">Mis promociones</a>
        </li>
      </ul>
<?php
} elseif ($tipoUsuario == 'dueño') {
?>
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item">
          <a href="" class="nav-link px-2 text-white">Local</a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link px-2 text-white">Promociones</a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link px-2 text-white">Solicitudes</a>
        </li>
      </ul>
<?php
} elseif ($tipoUsuario == 'administrador') {
?>
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item">
          <a href="" class="nav-link px-2 text-white">Solicitudes usuario</a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link px-2 text-white">Solicitudes promociones</a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link px-2 text-white">Locales</a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link px-2 text-white">Novedades</a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link px-2 text-white">Reportes</a>
        </li>
      </ul>
<?php
} else {
?>
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item">
          <a href="acercaDe.php" class="nav-link px-2 text-white">Acerca del shopping</a>
        </li>
        <li class="nav-item">
          <a href="locales.php" class="nav-link px-2 text-white">Locales</a>
        </li>
        <li class="nav-item">
          <a href="promociones.php" class="nav-link px-2 text-white">Promociones</a>
        </li>
      </ul>
<?php
}
if ($login) {
?>
      <div class="navbar-nav ms-auto dropdown">
        <button class="btn p-0 border-0 bg-transparent focus-ring" type="button" id="perfilDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-person-circle text-light fs-2"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="perfilDropdown" style="min-width: 250px;">
          <li class="px-3 py-2">
            <div class="fw-semibold"><?php echo $_SESSION['usuario'] ?></div>
            <small>Nivel: basico</small>
          </li>
          <li><hr class="dropdown-divider" /></li>
          <li><a class="dropdown-item" href="#">Cambiar contraseña</a></li>
          <li><a class="dropdown-item" href="../cerrarSesion.php">Cerrar sesión</a></li>
        </ul>
      </div>
<?php
} else {
?>
      <div class="navbar-nav ms-auto">
        <!--boton ingresar-->
        <button type="button" class="btn btn-outline-light mx-1 my-1" data-bs-toggle="modal" data-bs-target="#loginModal">
          Ingresar
        </button>
        <!--boton registrarse-->
        <button type="button" class="btn btn-primary mx-1 my-1" data-bs-toggle="modal" data-bs-target="#registroModal">
          Registrarse
        </button>
      </div>
<?php
}
?>
    </div>
  </div>
</nav>