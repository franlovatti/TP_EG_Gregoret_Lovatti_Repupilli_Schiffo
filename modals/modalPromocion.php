<?php
$tipoUsuario = $_SESSION['tipoUsuario'] ?? null;
?>
<div class="modal fade" id="promoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="promoModalLabel">Detalles de la Promoción</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span class="visually-hidden">Cerrar</span>
          </button>
        </div>
        <div class="modal-body">
          <img id=promoModalImg src="imagenes/placeholder.jpg" class="img-fluid mb-3" alt="Promoción">
            <span class="visually-hidden">Imagen de la promocion del local</span>
          <h5><span id=promoModalNombreLoc></span></h5>
          <input type="hidden" id="promoModalIdPromo" value="">
          <p><strong>Promo: </strong><span id="promoModalDesc"></span></p>
          <p><strong>Fecha de inicio: </strong><span id="promoModalDesde"></span></p>
          <p><strong>Fecha de finalización: </strong><span id="promoModalHasta"></span></p>
          <p><strong>Dias disponibles: </strong><span id="promoModalDias"></span></p>
        </div>
        <div class="modal-footer">
          <span class="text-muted">Si aprovechas la promocion te va a llegar a tu mail un codigo para usarla 
            cuando el dueño del local apruebe tu solicitud.</span>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Cerrar">Cerrar</button>
          <?php if($tipoUsuario != 'dueño' && $tipoUsuario != 'administrador'){ ?>
          <button type="button" class="btn btn-primary" id="btnAprovecharPromo" aria-label="Aprovechar promocion">Aprovechar Promoción</button>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>

  <!--Logica para modal segun si esta logueado o no -->
  <?php
  //guardamos esto para pasarlo a js
  $usuarioLogueado = isset($_SESSION['usuario']);
  if ($usuarioLogueado) {
    $idCliente = $_SESSION['idUsuario'];
    ?>
    <form id="formAprovecharPromo" action="nuevaSolicitudPromoUsuario.php" method="POST">
      <input type="hidden" name="idPromo" id="idPromo">
      <input type="hidden" name="idCliente" id="idCliente" value="<?php echo $idCliente; ?>">
    </form>
    <?php
  } 
  ?>

  <?php include "modalNecesitasLogin.php"?>

  <!--Scripts para aprovechar promoción-->
  <script>
    document.addEventListener('DOMContentLoaded', function(){
      const btn = document.getElementById("btnAprovecharPromo");
      const promoModalEl = document.getElementById("promoModal");
      const necesitarLoginEl = document.getElementById("necesitarLoginModal");
      const loginModalEl = document.getElementById("loginModal");
      const promoModal = new bootstrap.Modal(promoModalEl);
      const necesitarLogin = new bootstrap.Modal(necesitarLoginEl);
      const loginModal = loginModalEl ? new bootstrap.Modal(loginModalEl) : null;
      const estaLogueado = <?php echo json_encode($usuarioLogueado); ?>;
      const form = document.getElementById('formAprovecharPromo');
      const btnAbrirLogin = document.getElementById('btnAbrirLoginDesdeNecesitar');

      function limpiarFocoModal(modalEl) {
        if (!modalEl) {
          return;
        }

        const sacarFoco = function() {
          if (document.activeElement && modalEl.contains(document.activeElement)) {
            document.activeElement.blur();
          }
        };

        modalEl.addEventListener('hide.bs.modal', sacarFoco);
        modalEl.addEventListener('hidden.bs.modal', sacarFoco);
      }

      limpiarFocoModal(promoModalEl);
      limpiarFocoModal(necesitarLoginEl);
      limpiarFocoModal(loginModalEl);

      if(!btn){
        return;
      }


      btn.addEventListener("click", function () {
        if (document.activeElement) {
          document.activeElement.blur();
        }

        // Ocultar la modal actual
        promoModal.hide();

        // Esperar a que termine de cerrarse antes de mostrar la otra
        promoModalEl.addEventListener('hidden.bs.modal', function () {
          if(estaLogueado){
            //logica para mandar los datos a gestionarPromoUsuario.php
            const idPromoModal = document.getElementById('promoModalIdPromo').value;
            if (!idPromoModal) {
              alert("Error: promoción inválida");
              return;
            }
            const inputForm = document.getElementById('idPromo');
            inputForm.value = idPromoModal;
            form.submit();
          } else{
            //Abre modal de necesidad de login
            necesitarLogin.show();
          }
        }, { once: true }); // `once: true` evita que se ejecute más de una vez
      });

      if (btnAbrirLogin && loginModal) {
        btnAbrirLogin.addEventListener('click', function () {
          if (document.activeElement) {
            document.activeElement.blur();
          }

          necesitarLoginEl.addEventListener('hidden.bs.modal', function () {
            loginModal.show();
          }, { once: true });

          necesitarLogin.hide();
        });
      }
  });
  </script>
