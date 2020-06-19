<?php
session_start();
$remi=$_SESSION['user_id'];
date_default_timezone_set('America/Mexico_City');
include"../config/config.php";
$destina=explode(",",$_REQUEST['destina']);
$asunto=mysqli_real_escape_string($con,$_REQUEST['asunto']);
$msn=$_REQUEST['msn'];
$fecha=date('Y-m-d H:i:s');

for ($i=0; $i <count($destina) ; $i++) { 
$ids=$destina[$i];
$cons="INSERT into notificaciones(asunto,remitente,destina,mensaje,fecha,visto) values('$asunto',$remi,$ids,'$msn','$fecha',0)";
if($sql=mysqli_query($con,$cons))
{
  if (count($destina)==1) {
    ?>
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Correcto!</strong> Mensaje enviado correctamente.
    </div>
    <?php
  }else{
    echo "Correcto! Mensaje enviado correctamente.";
  }
	
}else{
  if (count($destina)==1) {
    ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Error!</strong> Lo siento algo ha salido mal, notifique al area de sistemas : <?php echo mysqli_error($con); ?>.
    </div>
   <?php
  }else{
    echo "Lo siento algo ha salido mal, notifique al area de sistemas : ".mysqli_error($con) ;
  }
	
}

}

?>