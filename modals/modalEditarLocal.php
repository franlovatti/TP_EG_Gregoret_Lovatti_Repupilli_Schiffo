<div class="modal fade" id="modalEditarLocal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Editar local</h5>
      <button type="button" class="btn-close " data-bs-dismiss="modal"></button>

    </div>
    <div class="modal-body">
<?php
include '../conexion.php';
$vSQL="SELECT * FROM usuario where tipo_usuario= 'dueño' AND estado ='activo'"; 
$vResult=mysqli_query($conexion,$vSQL);
?>  
    <form id="formEditarLocal" action="gestionarEdicionLocal.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="id_local" id="modal-id">

  <div class="mb-3">
    <label for="editLocalNombre" class="form-label">Nombre del Local</label>
    <input type="text" class="form-control" id="modal-nombre" name="nombre_local"  required>
  </div>
  
  <div class="mb-3">
    <label for="editLocalUbicacion" class="form-label">Ubicación</label>
    <input type="text" class="form-control" id="modal-ubicacion" name="ubicacion" required>
  </div>
  
  <div class="mb-3">
    <label for="editLocalRubro" class="form-label">Rubro</label>
    <input type="text" class="form-control" id="modal-rubro" name="rubro" required>
  </div>
  
  
  <div class="mb-3">
        <label for="editLocalUsuario" class="form-label">Id del dueño del local</label>
        <select class="form-select" name="id_usuario" id="modal-usuario" required>
            <?php while ($fila = mysqli_fetch_assoc($vResult)){
            ?> <option value="<?php echo  $fila['id_usuario'] ;?>" ><?php echo  $fila['id_usuario'] ;?></option><?php ;}?>
        </select>
    </div>
  
  <div class="mb-3">
    <label for="editLocalDesc" class="form-label">Descripción</label>
    <textarea class="form-control" id="modal-desc" name="descripcion" rows="3" ></textarea>
  </div>
  <div class="mb-3">
            <label for="imagen" class="form-label">Imagen del local:</label>
            <input type="file" name="imagen_local" id="imagen_local" accept="image/*" class="form-control" >
  </div>
   <input type="hidden" name="estado" value="activo">
  
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-primary">Guardar cambios</button>
  </div>
</form>

  


    </div>
  </div>
</div>
</div>
