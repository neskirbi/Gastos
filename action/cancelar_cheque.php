<?php

    include "../config/config.php";//Contiene funcion que conecta a la base de datos
    
    if (isset($_GET['id']))
    {
        $id_expence=intval($_GET['id']);
        
        $fecha_confirm=date('Y-m-d');


        $consulta="SELECT t_cheque from cheques where id='".$id_expence."' ";
        $tipo=mysqli_query($con,$consulta);
        $tipo=mysqli_fetch_array($tipo);

        if ($tipo['t_cheque']=="3") 
        {


            if ($delete1=mysqli_query($con,"UPDATE cheques SET no_cheque='' WHERE id='".$id_expence."'"))
            {
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


        }else
        {

            if ($delete1=mysqli_query($con,"DELETE from gastos  WHERE id_cheque='".$id_expence."'" ))
            {

                if ($delete1=mysqli_query($con,"UPDATE cheques SET status=1,fecha_confirm='$fecha_confirm',no_cheque='' WHERE id='".$id_expence."'"))
                {
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
        }


       
    }
        
        ?>
