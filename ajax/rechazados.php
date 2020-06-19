<?php
    include "../config/config.php";//Contiene funcion que conecta a la base de datos
    session_start();
   
$programa=$_SESSION['programa'];

$date=$_REQUEST['date'];
$date2=$_REQUEST['date2'];
$user=$_REQUEST['user'];


if ($_SESSION['user_tipo']=='2') {
    
    $user=$_SESSION['user_id'];
}

if ($user!='0') {
	$user=" and u.id='$user' ";
}else{
	$user="";

}

if ($programa!="0") {
    $programa="c.programa='$programa'";
}else
{
    $programa="c.programa!='0'";
}
        //main query to fetch the data
        $sql="SELECT u.name,d.fecha,d.comentario,d.id_desglose,d.id_cheque,dd.amount,dd.iva,dd.description,dd.deducible FROM  user  as u join cheques as c on c.beneficiario=u.id join papelera_desglose as d on d.id_cheque=c.id join desglose as dd on dd.id=d.id_desglose where  $programa $user  and d.fecha between '$date' and '$date2' and d.restaurar='0' ";
        $query = mysqli_query($con, $sql);
        //loop through fetched data
        $numrows=mysqli_num_rows($query);
        if ($numrows>0){
            
          
            ?>
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                    <tr class="headings">
                        <th class="column-title">Fecha rechazo </th>
                        <th class="column-title">Nombre</th>
                        <th class="column-title">Comentario </th>
                        <th class="column-title">Monto A.IVA </th>
                        <th class="column-title">IVA </th>
                        <th class="column-title">Total </th>
                        <th class="column-title">Deducible </th>
                        <th class="column-title">Concepto </th>
                        <th></th>

                    </tr>
                </thead>
                <tbody>
                <?php 
                        while($r=mysqli_fetch_array($query)) {
                            
                            $id=$r['id_desglose'];
                            $nombre=utf8_encode($r['name']);
                            $comen=$r['comentario'];
                            $id_cheque=$r['id_cheque'];
                            $fecha=$r['fecha'];
                            $comentario=$r['comentario'];
                            $monto=$r['amount'];
                            $iva=$r['iva'];
                            $total=$r['amount']+$r['iva'];
                            $description=$r['description'];
                            if($r['deducible']=='1')
                            {
                                $dedu="S&iacute;";
                            }else{
                                $dedu="No";
                            }
                            

                           
                            
                ?>
                    

                    <tr >
                        <td><?php echo $fecha; ?></td>
                        <td><?php echo $nombre; ?></td>
                        <td><?php echo $comentario; ?></td>
                        <td>$<?php echo $monto; ?></td>
                        <td>$<?php echo $iva; ?></td>
                        <td>$<?php echo $total; ?></td>
                        <td><?php echo $dedu; ?></td>
                        <td><?php echo $description; ?></td>
                        <td><a class="btn btn-default" href="#" title="Solicitar reembolso" onclick="reciclar(<?php echo $id; ?>);"><i class="fas fa-angle-double-up"></i></a></td>
                           
                    </tr>
                <?php
                    } //end while
                ?>
                
              </table>
            </div>
            <?php
        }else{
           ?> 
            <div class="alert alert-warning alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Aviso!</strong> No hay datos para mostrar
            </div>
        <?php    
        }
    
?>