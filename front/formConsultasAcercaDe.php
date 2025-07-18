<?php
require("scriptFormConsultasAcercaDe.php");
?>
<?php 
  if(isset($_POST['submit'])){
    if(empty($_POST['email']) || empty($_POST['nombre']) || empty($_POST['mensaje'])){
        $response = "All fields are required";
    }else{
        $response = sendMail($_POST['email'], $_POST['nombre'], $_POST['mensaje']);
    }
  }
?>
<form action="" method="post">
  <div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" class="form-control" id="nombre" name="nombre" required />
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Correo electrónico</label>
    <input type="email" class="form-control" id="email" name="email" required />
  </div>
  <div class="mb-3">
    <label for="mensaje" class="form-label">Mensaje</label>
    <textarea class="form-control"  id="mensaje" name="mensaje" rows="4" required></textarea>
  </div>
  <button type="submit" name="submit" class="btn btn-primary">Enviar</button>
</form>
<?php
  if(@$response == "success"){
      include '../modals/modalRecibimosMailConsulta.php';
  }else{
      ?>
        <p class="error"><?php echo @$response; ?></p>
      <?php
  }
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = new bootstrap.Modal(document.getElementById('modalRecibimosMailConsulta'));
        modal.show();
    });
</script>