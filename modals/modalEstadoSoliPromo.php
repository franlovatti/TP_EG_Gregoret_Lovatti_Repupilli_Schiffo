<?php
$estado = $_GET['estado'] ?? '';
$estado = htmlspecialchars($estado);
?>
<div class="modal fade" id="estadoSoliPromo" tabindex="-1" aria-labelledby="confirmarModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmarModalLabel">Estado promocion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>La solicitud ha sido <strong><?php 
                                        if($estado == "aceptada"){
                                        ?>
                                        <span class="text-success">aceptada</span>
                                        <?php } else{
                                          ?>
                                          <span class="text-danger">rechazada</span>
                                        <?php
                                        }
                                        ?></strong>
        .</p>
      </div>
    </div>
  </div>
</div>