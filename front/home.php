<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <style>
    .card:hover { 
    background-color: #e3f2fd; /* Azul claro, podés cambiarlo por el color que prefieras */
    transition: background-color 0.3s;
    cursor: pointer;
    }
    .card{
      height: 260px; /* Ajusta la altura máxima de la tarjeta */
      width: 340px; /* Ajusta el ancho máximo de la tarjeta */
      /*min-width: 340px;*/
      max-width: 340px;
    }
    .card-img-custom {
    height: 130px;      /* Cambia el valor según lo que necesites */
    width: 100%;
    object-fit: cover;      /* Recorta la imagen para llenar el área */
    object-position: center;/* Centra el recorte */
    }
  </style>
  </head>

  <body class="d-flex flex-column min-vh-100">
    <header class="p-3 text-bg-dark">
      <?php include '../header.php'; ?>
    </header>
    <!--Contenido principal-->
    <main class="flex-grow-1">
    <!-- Intro de la pagina -->
    <div class="container-fluid py-5 text-center">
      <h1 class="text-center">Welcome to Our Website</h1>
      <p class="text-center">
        This is a simple example of a Bootstrap header with navigation links and
        buttons.
      </p>
    </div>
    <!-- Imagen de fondo -->
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 p-0">
          <img
            src="imagenes/alto2.jpg"
            alt="shopping Image"
            class="img-fluid"
          />
        </div>
      </div>
    </div>
    <!--Contenedor de promociones-->
    <div class="my-4 container-fluid">
      <h2 class="text-center my-2">Promociones</h2>
      <!--Determina cuantas tarjetas por filas-->
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-1 align-items-stretch">
    <?php
    //conexion con la bd
    require_once '../conexion.php';
    global $conexion;
    error_reporting(E_ERROR | E_PARSE); // Muestra solo errores fatales y errores de análisis
    ini_set('display_errors', 0);       // No mostrar errores al usuario
    global $recuperar_error;
    $query ="SELECT p.descripcion, p.fecha_desde, p.fecha_hasta, 
                    p.lunes, p.martes, p.miercoles, p.jueves, p.viernes, p.sabado, p.domingo, p.imagen_prom,
                    loc.nombre_local
            FROM promocion p
            INNER JOIN local loc ON p.id_local = loc.id_local
            WHERE p.fecha_hasta >= CURDATE() AND p.fecha_desde <= CURDATE() AND p.estado='activa'
            LIMIT 4";
    $resultado = mysqli_query($conexion, $query);
    if(!$resultado) {
        $recuperar_error = "Error al recuperar las promociones: " . mysqli_error($conexion);
    } else {
        while($row = $resultado->fetch_assoc()) {
          $finfo = new finfo(FILEINFO_MIME_TYPE);
          $mime = $finfo->buffer($row['imagen_prom']);
        ?>
          <!--Necesario para que la tarjeta sea clickeable y abra el modal-->
          <div class="col d-flex justify-content-center">
            <!--Tarjetas de promociones-->
            <div class="card mb-3"
            data-bs-toggle="modal"
            data-bs-target="#promoModal"
            data-nombre="<?php echo htmlspecialchars($row['nombre_local']); ?>"
            data-descripcion="<?php echo htmlspecialchars($row['descripcion']); ?>"
            data-fecha-desde="<?php echo htmlspecialchars($row['fecha_desde']); ?>"
            data-fecha-hasta="<?php echo htmlspecialchars($row['fecha_hasta']); ?>"
            data-imagen="data:<?php echo $mime; ?>;base64,<?php echo base64_encode($row['imagen_prom']); ?>"
            data-lunes="<?php echo $row['lunes'] ? 'Lunes' : ''; ?>"
            data-martes="<?php echo $row['martes'] ? 'Martes' : ''; ?>"
            data-miercoles="<?php echo $row['miercoles'] ? 'Miércoles' : ''; ?>"
            data-jueves="<?php echo $row['jueves'] ? 'Jueves' : ''; ?>"
            data-viernes="<?php echo $row['viernes'] ? 'Viernes' :  ''; ?>"
            data-sabado="<?php echo $row['sabado'] ? 'Sábado' : ''; ?>"
            data-domingo="<?php echo $row['domingo'] ? 'Domingo' : ''; ?>"
            style="cursor:pointer;">
            <img src="data:<?php echo $mime; ?>;base64,<?php echo base64_encode($row['imagen_prom']); ?>" class="card-img-top card-img-custom" alt="Promoción">
            <div class="card-body">
              <h5><?php echo htmlspecialchars($row['nombre_local']); ?></h5>
              <p class="card-text"><?php echo htmlspecialchars($row['descripcion']); ?></p>
            </div> <!-- Cierra card-body -->
          </div> <!-- Cierra card -->
        </div> <!-- Cierra col -->
        <?php
        }
      }
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    ?>
    </div> <!-- Cierra row de tarjetas -->
    <div class=row>
      <div class="col-12 d-flex justify-content-center">
        <div class="container-fluid text-center my-4">
        <a href="promociones.php" class="btn btn-primary">Mas promociones</a>
        </div> <!-- Cierra container-fluid para el boton-->
      </div> <!-- Cierra col-12 -->
    </div> <!-- Cierra row -->
  </div> <!--Cierra contenedor de promociones-->
    </main> <!--Cierra contenido principal-->
    <!--Footer-->
    <footer class="footer mt-auto py-3 bg-body-tertiary">
      <?php include '../footer.php'; ?>
    </footer>
    <!-- Scripts al final -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
      crossorigin="anonymous"
    ></script>

    <!-- Script para cerrar menú al hacer clic en un link -->
    <script>
      document.querySelectorAll('.navbar-nav .nav-link').forEach((link) => {
        link.addEventListener('click', () => {
          const navbarCollapse = document.querySelector('.navbar-collapse');
          if (navbarCollapse.classList.contains('show')) {
            new bootstrap.Collapse(navbarCollapse).toggle();
          }
        });
      });
    </script>
    <!-- Modal de Login -->
    <?php include '../modals/modalLogin.php'; ?>
    <!-- Modal de Registro -->
    <?php include '../modals/modalSignUp.php'; ?>
    <!-- Modal de Registro -->
    <?php include '../modals/modalSignUpD.php'; ?>
    <!-- Modal de Promociones -->
    <?php include "../modals/modalPromocion.php"; ?>
    <!-- Modal de Recuperar Contraseña -->
    <?php include '../modals/modalRecuperar.php'; ?>
    <!-- Modal de Cambiar Contraseña -->
    <?php include '../modals/modalCambiarClave.php'; ?>
    <!-- Modal de Token -->
    <?php include '../modals/modalToken.php'; ?>
    <!-- sript login -->
    <?php if (!empty($login_error)){?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = new bootstrap.Modal(document.getElementById('loginModal'));
            modal.show();
        });
    </script>
    <?php }; ?>
    <!-- script signUp -->
    <?php if (!empty($signUp_error)){?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = new bootstrap.Modal(document.getElementById('registroModal'));
            modal.show();
        });
    </script>
    <?php }; ?>
    <!-- script recuperar_contrasena -->
    <?php if (isset($_GET['recuperar']) || !empty($recuperar)){?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = new bootstrap.Modal(document.getElementById('recuperarModal'));
            modal.show();
        });
    </script>
    <?php }; ?>
    <!-- script cambiar clave -->
    <?php if (!empty($cambiar_error) || $token_resultado == '1'){?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = new bootstrap.Modal(document.getElementById('cambiarClaveModal'));
            modal.show();
        });
    </script>
    <?php }; ?>
    <!-- script token -->
    <?php if ($token_resultado == '0'){?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = new bootstrap.Modal(document.getElementById('tokenModal'));
            modal.show();
        });
    </script>
    <?php } ?>

    <!-- script Modal promociones -->
  <script>
  document.addEventListener('DOMContentLoaded', function () {
    var promoModal = document.getElementById('promoModal');
    promoModal.addEventListener('show.bs.modal', function (event) {
      var card = event.relatedTarget;
      document.getElementById('promoModalLabel').textContent = card.getAttribute('data-nombre');
      document.getElementById('promoModalImg').src = card.getAttribute('data-imagen');
      document.getElementById('promoModalDesc').textContent = card.getAttribute('data-descripcion');
      document.getElementById('promoModalDesde').textContent = card.getAttribute('data-fecha-desde');
      document.getElementById('promoModalHasta').textContent = card.getAttribute('data-fecha-hasta');
      const dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo']
      .map(dia => card.getAttribute('data-' + dia)) // obtenés el texto de cada día desde el atributo data
      .filter(Boolean)                             // eliminás los que son null, undefined o string vacío
      .join(', ');                                  // los unís con coma y espacio
      document.getElementById('promoModalDias').textContent = dias;
    });
  });
  </script>
  </body>
</html>
