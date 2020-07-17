<?php
    
    date_default_timezone_set('America/Mexico_City');
    include "../config/config.php";//Contiene funcion que conecta a la base de datos
    $jsons=$_POST['ids'];
    $arrayids=json_decode($jsons,true);
    //print_r($arrayids);
    $ids=array();
    foreach ($arrayids as $key => $value) {
        //print_r($value);
        $ids[]=$value['id'];
    }
    //print_r($ids);
    $ids = implode("','",$ids);
    $fecha=date("Y-m-d");
    $sql="UPDATE cheques SET autorizado='1',fechaautorizado='$fecha' WHERE id in ('".$ids."') " ;
    if ($autorizado=mysqli_query($con,$sql)){
        ?>
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Aviso!</strong> Gastos Autorizados.
        </div>
        <?php 
    }else {
        ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.<br><?php echo mysqli_error($con); ?>
        </div>
        <?php
    }
    
   
        
?>
