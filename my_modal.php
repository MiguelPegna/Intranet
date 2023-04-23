<!--modal-->
<div class="modal" id="confirm-delete"<?php echo $producto['Id_producto']; ?> tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-title"><h2>Borrar</h2></div>
            <i class="far fa-times-circle" id="close" data-bs-dismiss="modal"></i>
            <div class="modal-body"> 
                <p>¿Estás seguro de querer borrar este producto de la lista?</p>
                <div class="botones">
                    <button class="btn-red close" data-bs-dismiss="modal">CANCELAR</button>
                    <button type="submit" class="btn btn-danger btnBorrar" data-dismiss="modal" id="<?php echo $producto['id']; ?>">ACEPTAR</button>
                </div>
            </div> 
            <div class="modal-title"></div>
        </div>
    </div>  
</div>