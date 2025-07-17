  <div class="modal fade" id="promoModal" tabindex="-1" aria-labelledby="promoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="promoModalLabel">Detalles de la Promoción</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <img id=promoModalImg src="" class="img-fluid mb-3" alt="Promoción">
          <h5><span id=promoModalNombreLoc></span></h5>
          <p id="promoModalDesc"></p>
          <p><strong>Fecha de inicio: </strong><span id="promoModalDesde"></span></p>
          <p><strong>Fecha de finalización: </strong><span id="promoModalHasta"></p>
          <p><strong>Dias disponibles: </strong><span id="promoModalDias"></span></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary">Aprovechar Promoción</button>
        </div>
      </div>
    </div>
  </div>
