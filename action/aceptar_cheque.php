<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include"../config/config.php";
session_start();
if (isset($_GET['id']))
{
  $idcheque=$_GET['id'];
  $no_cheque=intval($_GET['nocheque']);
  $fecha_confirm=date('Y-m-d');

  $consulta="SELECT t_cheque from cheques where id='$idcheque' ";
  $tipo=mysqli_query($con,$consulta);
  $tipo=mysqli_fetch_array($tipo);
  if ($tipo['t_cheque']=="3") 
  {
      $con_up="UPDATE cheques SET status=2,fecha_confirm='$fecha_confirm',no_cheque=$no_cheque WHERE id='$idcheque'"; 

      if (mysqli_query($con,$con_up))
      {
        ?>
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Aviso!</strong> Cheque Aceptado.
        </div>
      
        <?php 
      }else {
        ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
        </div>
        <?php
      } //end else
  }else{
    $consulta="INSERT into gastos (id_cheque,fecha,fecha_comp,status,t_gasto) values('$idcheque','$fecha_confirm','0000-00-00','1','0')";
    if(mysqli_query($con,$consulta))
    {
      ?>
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Aviso!</strong> Gasto Aceptado.
      </div>
      <?php
      /////// una ves guaqrdodoel gasto se confirma el cheque
      $con_up="UPDATE cheques SET status=2,fecha_confirm='$fecha_confirm',no_cheque=$no_cheque WHERE id='$idcheque'"; 

      if (mysqli_query($con,$con_up))
      {
          ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Aviso!</strong> Cheque Aceptado.
          </div>
        
          <?php 
      }else {
          ?>
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
          </div>
          <?php
      } //end else
    }
  }



}else
{
  ?>
  <div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
  </div>
  <?php
}




?>