<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Home</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
<link rel="stylesheet" href="estilos/home.css">

</head>

<body class="d-flex flex-column min-vh-100">

<header class="p-3 text-bg-dark">
<?php include '../header.php'; ?>
</header>

<main class="flex-grow-1">

<!-- HERO -->
<div class="hero">

<img src="imagenes/alto2.jpg" alt="shopping">

<div class="hero-overlay"></div>

<div class="hero-content">
<h1 class="display-5 fw-bold">Descubrí las mejores promociones</h1>
<p class="lead">Ofertas exclusivas de nuestros locales todos los días</p>
<a href="promociones.php" class="btn btn-primary">Ver promociones</a>
</div>

</div>

<!-- PROMOCIONES -->

<div class="section-promos container">

<h2 class="text-center section-title">Promociones destacadas</h2>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 justify-content-center">

<?php

require_once '../conexion.php';
global $conexion;

error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', 0);

global $recuperar_error;

$query ="SELECT p.descripcion, p.fecha_desde, p.fecha_hasta,
p.lunes, p.martes, p.miercoles, p.jueves, p.viernes, p.sabado, p.domingo, p.imagen_prom,
loc.nombre_local
FROM promocion p
INNER JOIN local loc ON p.id_local = loc.id_local
WHERE p.fecha_hasta >= CURDATE()
AND p.fecha_desde <= CURDATE()
AND p.estado='activa'
LIMIT 4";

$resultado = mysqli_query($conexion, $query);

if(!$resultado){
$recuperar_error = "Error al recuperar las promociones: " . mysqli_error($conexion);
}else{

while($row = $resultado->fetch_assoc()){

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->buffer($row['imagen_prom']);

?>

<div class="col d-flex justify-content-center">

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

<p class="card-text">
<?php echo htmlspecialchars($row['descripcion']); ?>
</p>

</div>

</div>

</div>

<?php
}
}

mysqli_free_result($resultado);
mysqli_close($conexion);
?>

</div>

<div class="text-center mt-4">
<a href="promociones.php" class="btn btn-primary">Ver todas las promociones</a>
</div>

</div>

</main>

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
<?php include "../modals/modalPromocion.php"; ?>
<?php include '../modals/modalRecuperar.php'; ?>
<?php include '../modals/modalCambiarClave.php'; ?>
<?php include '../modals/modalToken.php'; ?>

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

<?php if (!empty($cambiar_error) || $token_resultado == '1'){?>
<script>
document.addEventListener('DOMContentLoaded',function(){
var modal=new bootstrap.Modal(document.getElementById('cambiarClaveModal'));
modal.show();
});
</script>
<?php }; ?>

<?php if ($token_resultado == '0'){?>
<script>
document.addEventListener('DOMContentLoaded',function(){
var modal=new bootstrap.Modal(document.getElementById('tokenModal'));
modal.show();
});
</script>
<?php } ?>

<script>

document.addEventListener('DOMContentLoaded',function(){

var promoModal=document.getElementById('promoModal');

promoModal.addEventListener('show.bs.modal',function(event){

var card=event.relatedTarget;

document.getElementById('promoModalLabel').textContent=card.getAttribute('data-nombre');

document.getElementById('promoModalImg').src=card.getAttribute('data-imagen');

document.getElementById('promoModalDesc').textContent=card.getAttribute('data-descripcion');

document.getElementById('promoModalDesde').textContent=card.getAttribute('data-fecha-desde');

document.getElementById('promoModalHasta').textContent=card.getAttribute('data-fecha-hasta');

const dias=['lunes','martes','miercoles','jueves','viernes','sabado','domingo']
.map(dia=>card.getAttribute('data-'+dia))
.filter(Boolean)
.join(', ');

document.getElementById('promoModalDias').textContent=dias;

});

});

</script>

</body>
</html>