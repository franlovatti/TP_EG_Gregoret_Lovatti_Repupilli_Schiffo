<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Acerca del shopping</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<link rel="stylesheet" href="estilos/acercaDe.css">
 <link rel="stylesheet" href="estilos/global.css" />
</head>

<body class="d-flex flex-column min-vh-100">

<header class="p-3 text-bg-dark">
<?php include '../header.php'; ?>
</header>


<!-- CAROUSEL -->
<div class="section section-light">
<div class="container my-2">
<div id="carouselExampleCaptions" class="carousel slide">

<div class="carousel-indicators">
<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"></button>
<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></button>
<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"></button>
</div>

<div class="carousel-inner">

<div class="carousel-item active">

<img src="imagenes/carrusel1.jpg" class="d-block w-100" alt="Mujer caminando en shopping">

<div class="carousel-overlay"></div>

</div>

<div class="carousel-item">

<img src="imagenes/carrusel2.jpg" class="d-block w-100" alt="patio comidas">

<div class="carousel-overlay"></div>

</div>

<div class="carousel-item">

<img src="imagenes/carrusel3.png" class="d-block w-100" alt="ubicacion en un mapa del shopping">

<div class="carousel-overlay"></div>

</div>

</div>

<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
<span class="carousel-control-prev-icon"></span>
</button>

<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
<span class="carousel-control-next-icon"></span>
</button>

</div>
</div>
</div>

<!-- ACERCA DEL SHOPPING -->
<div class="section section-light">
<div class="container">

<h2 class="text-center section-title">Acerca del shopping</h2>

<div class="text-about text-center">

<p>
Nuestro shopping es un espacio pensado para brindar una experiencia completa de compras, gastronomía y entretenimiento.
Aquí podés encontrar una amplia variedad de tiendas, restaurantes y servicios para toda la familia.
</p>

<p>
Nuestro objetivo es ofrecer un ambiente moderno, cómodo y seguro donde los visitantes puedan disfrutar su tiempo,
descubrir nuevas marcas y compartir momentos únicos.
</p>

</div>

</div>
</div>


<!-- CONTACTO Y UBICACION -->

<div class="section section-light">

<div class="container">

<div class="row g-4 align-items-start">

<div class="col-md-6">

<h2 class="text-center section-title">Contáctanos</h2>

<?php include 'formConsultasAcercaDe.php'; ?>

</div>

<div class="col-md-6">

<h2 class="text-center section-title">Ubicación</h2>

<p class="text-center text-muted">
Estamos ubicados en una zona de fácil acceso con estacionamiento disponible para nuestros visitantes.
</p>

<div id="map"></div>

</div>

</div>

</div>

</div>


<footer class="footer mt-auto py-3 bg-body-tertiary">
<?php include '../footer.php'; ?>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.querySelectorAll('.navbar-nav .nav-link').forEach((link)=>{
link.addEventListener('click',()=>{
const navbarCollapse=document.querySelector('.navbar-collapse');
if(navbarCollapse.classList.contains('show')){
new bootstrap.Collapse(navbarCollapse).toggle();
}
});
});
</script>


<?php include '../modals/modalLogin.php'; ?>
<?php include '../modals/modalSignUp.php'; ?>
<?php include '../modals/modalSignUpD.php'; ?>
<?php include '../modals/modalRecuperar.php'; ?>


<?php if (!empty($login_error)){?>
<script>
document.addEventListener('DOMContentLoaded',function(){
var modal=new bootstrap.Modal(document.getElementById('loginModal'));
modal.show();
});
</script>
<?php }; ?>


<?php if (!empty($signUp_error)){?>
<script>
document.addEventListener('DOMContentLoaded',function(){
var modal=new bootstrap.Modal(document.getElementById('registroModal'));
modal.show();
});
</script>
<?php }; ?>


<?php if (isset($_GET['recuperar']) || !empty($recuperar)){?>
<script>
document.addEventListener('DOMContentLoaded',function(){
var modal=new bootstrap.Modal(document.getElementById('recuperarModal'));
modal.show();
});
</script>
<?php }; ?>


<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

var lat = -32.9275;
var lng = -60.6683;

var map = L.map('map').setView([lat,lng],16);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
attribution:'© OpenStreetMap contributors'
}).addTo(map);

L.marker([lat,lng]).addTo(map)
.bindPopup('Alto Rosario Shopping')
.openPopup();

</script>

</body>
</html>