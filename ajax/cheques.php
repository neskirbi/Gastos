<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
    include "../config/config.php";//Contiene funcion que conecta a la base de datos
    session_start();
    function verificar($id)
    {
        global $con;
        $consulta="SELECT * from desglose where id_cheque='".$id."' ";
        $sql_data=mysqli_query($con,$consulta);
        $num=mysqli_num_rows($sql_data);

        $consulta="SELECT * from desglose where id_cheque='".$id."' and ok_val='1' ";
        $sql_data=mysqli_query($con,$consulta);
        $num2=mysqli_num_rows($sql_data);

        $conf="0";
        if($num==$num2 and $num!="0")
        {
            $conf="1";
        }

        return $conf;
    } 
	
	
    
    $daterange = mysqli_real_escape_string($con,(strip_tags($_REQUEST['daterange'], ENT_QUOTES)));
    $action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    $filtro="";

    if( $_SESSION['user_tipo']=="1" )
    {
      $filtro=" (che.status='1') or che.fecha='$daterange'  ";

    }else if($_SESSION['user_tipo']=="2" || $_SESSION['user_tipo']=="3" || $_SESSION['user_tipo']=="5" || $_SESSION['user_tipo']=="4" )
    {
      $filtro="  che.programa='".$_SESSION['programa']."' and usu.rutas IN ('".str_replace(",","','",$_SESSION['rutas'])."')  ";

    }else if($_SESSION['user_tipo']=="0")
    {
    	$filtro=" ( che.programa!='0')  ";
    }

    if($action == 'ajax'){
        
        // escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
         $aColumns = array('id');//Columnas de busqueda
            

        $consulta="SELECT count(che.id) as filas FROM cheques as che join user as usu on usu.id=che.beneficiario  where $filtro ";
        $numero=mysqli_query($con,$consulta);
        $num=mysqli_fetch_array($numero);        
        $numrows= intval($num['filas']);

        $sql="SELECT che.id as id ,che.no_cheque,che.status as status,che.monto,che.bennombre,che.beneficiario,che.t_cheque,che.concepto,che.programa,che.fecha,che.fecha_confirm, che.semana, che.periodo, che.Cuenta, che.tipopago FROM cheques as che join user as usu on usu.id=che.beneficiario  where $filtro ";

        $query = mysqli_query($con, $sql);

        
        if ($numrows>0){
            
            ?>
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                    <tr class="headings" >
                        <th class="column-title">Periodo</th>
						<th class="column-title">Semana</th>
                        <th class="column-title">Gasto </th>
                        <th class="column-title">Concepto</th>
                        <th class="column-title">Beneficiario </th>
                        <th class="column-title">Programa </th>
                        <th class="column-title">Solicitud </th>
                        <th class="column-title">Monto </th>                        
                        <th class="column-title">Entregado</th>
						<th class="column-title">Tipo dePago</th>
						<th class="column-title">Cuenta deposito</th>
                        <th class="column-title">No. Cheque </th>
						<th class="column-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
						<th class="column-title">&nbsp;&nbsp;&nbsp;&nbsp;✓&nbsp;</th>
						<th class="column-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;×&nbsp;</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $cont=0;
                        while ($r=mysqli_fetch_array($query)) {
                            $id=$r['id'];
                            $no_cheque=$r['no_cheque'];
                            $status=$r['status'];
                           
                            switch($status)
                            {
                                case "0":
                                    $status="Recahzado";
                                break;

                                case "1":
                                    $status="Pendiente";
                                break;

                                case "2":
                                    $status="Aceptado";
                                break;
                            }
                            
                            $monto=$r['monto'];
                            
                            if($r['bennombre']=="0")
                            {
                                $consulta="SELECT name from user where id='".$r['beneficiario']."' ";
                                $sql_data=mysqli_query($con ,$consulta) ;
                                $nametemp=mysqli_fetch_array($sql_data);
                                $name=$nametemp['name'];
                            }else
                            {
                                $name=$r['bennombre'];
                            }

                            $consulta="SELECT name from t_cheque where id='".$r['t_cheque']."' ";
                            $sql_data=mysqli_query($con ,$consulta) ;
                            $nametemp=mysqli_fetch_array($sql_data);
                            $t_gasto=$nametemp['name'];
                            

							$periodo=$r['periodo'];
                            $semana=$r['semana'];
							$concepto=$r['concepto'];
                            $programa=$r['programa'];
							$Cuenta=$r['Cuenta'];
							$tipop=$r['tipopago'];
							
                            $consulta="SELECT name from programas where id='".$programa."' ";
                            $sql_data=mysqli_query($con ,$consulta) ;
                            $pro=mysqli_fetch_array($sql_data);
                            $programa=$pro['name'];

							$consulta_ctp="SELECT name from t_pago where id='".$tipop."' ";
                            $sql_data=mysqli_query($con ,$consulta_ctp) ;
                            $tpag=mysqli_fetch_array($sql_data);
                            $tipopago=$tpag['name'];


                            $fecha_entrega=$r['fecha_confirm'];
                            $fecha=$r['fecha'];
                ?>
				    <input type="hidden" value="<?php echo $name;?>" id="name<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $concepto;?>" id="concepto<?php echo $id;?>">
					<input type="hidden" value="<?php echo $status;?>" id="status_user<?php echo $id;?>">
                    <?php
                        if(verificar($id)=="1" or $r['t_cheque']!="3" or $_SESSION['user_tipo']!="1")
                        {
                    ?>

                    <tr class="even pointer">
					
						<td><div style="width:50px"><?php echo $periodo;?></div></td>
						<td><div style="width:50px"><?php echo $semana; ?></div></td>
					
                    	<td><div style="width:120px"><?php echo $t_gasto;?></div></td>
                        <td><div style="width:200px"><?php echo $concepto;?></div></td>
                        <td><div style="width:200px"><?php echo utf8_encode($name);?></div></td>
                        <td><div style="width:100px"><?php echo $programa;?></div></td>
                        <td><div style="width:80px"><?php echo $fecha; ?></div></td>
                        <td><div style="width:90px">$<?php echo number_format($monto,2);?></div></td>
                        <td><div style="width:80px"><?php echo $fecha_entrega; ?></div></td>
						<td><div style="width:80px"><?php echo $tipopago; ?></div></td>
						<td><div style="width:110px"><?php echo $Cuenta; ?></div></td>
                        <?php
                        

                            
                        
                            if (($_SESSION['user_tipo']=="1" ||  $_SESSION['user_tipo']=="0") && $r['status']!="2")
                            {
                                ?>
                                <td>
                                <input class="form-control" style="width:120px" type="text" name="no_cheque" id="no_cheque<?php echo $cont;?>" placeholder="No. Cheque" >
                                </td>
                                <?php                            
                            }else
                            {
                                ?>
                                    <td><?php echo $no_cheque;?></td>
                                <?php
                            }
                        
                        ?>
                        <td>
                        <?php
                        if($_SESSION['user_tipo']=="1"  || $_SESSION['user_tipo']=="0")
                        {
	                        if($r['status']=="1"){
	                        ?>
							 <td colspan="1">	
		                       <div style="width:10px"><a id="a<?php echo $cont;?>" href="#" class='btn btn-success' title='Aceptar'  onclick="aceptar_cheque ('<?php echo $id;?>','<?php echo $cont;?>');"data-toggle="modal" data-target=".bs-example-modal-lg-upd"><i class="fa fa-check"></i></a> </div>
		                	 </td>
							 <td colspan="1">	
		                       <div style="width:10px"><a id="c<?php echo $cont;?>" href="#" class='btn btn-danger'  title='Rechazar' onclick="rechazar_cheque('<?php echo $id;?>','<?php echo $cont;?>')"><i class="fa fa-close"></i> </a> </div>
							 </td>
							<?php
	                        }else if($r['status']=="2")
	                        {
	                            ?>
	                           <td colspan="1">	
		                            <center><div class="alert-success" style="width:60px"><i class="fa fa-check "></i>&nbsp;Aceptado&nbsp;</div></center>
								</td>                              
							   <td colspan="1">	
		                       <center><div style="width:10px"> <a  href="#" class='btn btn-danger' title='Rechazar' onclick="cancelar_cheque('<?php echo $id; ?>','<?php echo $cont;?>')"><i class="fa fa-close"></i> </a>
                               </div></center>
							  </td> 
							  
								<?php
	                        }else if($r['status']=="0")
	                        {
	                            ?>
	                                <center><div class="alert-danger"><i class="fa fa-close"></i> Rechazado</div></center>
	                            <?php
	                        }
                  		}else{

                  		  	if($r['status']=="2")
	                        {
	                            ?>
	                                <center><div class="alert-success"><i class="fa fa-check "></i> Aceptado</div></center>
	                            <?php
	                        }else if($r['status']=="0")
	                        {
	                            ?>
	                                <center><div class="alert-danger"><i class="fa fa-close"></i> Rechazado</div></center>
	                            <?php
	                        }else if($r['status']=="1")
	                        {
	                        	?>
                                <center><div class="alert-warning"><i class="fa fa-clock-o"></i> Pendiente</div></center>
                            	<?php
	                        }
                        	
               			 }
                        ?>

                        </td>
                        
                    </tr>
                <?php
            }
                    $cont++;
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
    }
?>