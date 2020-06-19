<?php

    include "../config/config.php";//Contiene funcion que conecta a la base de datos
    
    if (isset($_GET['id'])){
        $id_expence=intval($_GET['id']);
        
        $fecha_confirm=date('Y-m-d');
            if ($delete1=mysqli_query($con,"UPDATE cheques SET status=0,fecha_confirm='$fecha_confirm' WHERE id='".$id_expence."'")){
            ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Aviso!</strong> Cheque rechazado.
            </div>
            <?php 
        }else {
            ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
            </div>
        <?php
            } //end else*/
    } //end if
        ?>
