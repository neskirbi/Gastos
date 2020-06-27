<?php
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
      $filtro=" che.status='1' or (che.fecha='$daterange' and che.status='1')  ";

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
            

        

        $sql="SELECT usu.name as nombre,che.id as id ,che.no_cheque,che.status as status,che.monto,che.bennombre,che.beneficiario,
        tche.name as t_cheque,che.concepto,pro.name as programa,che.fecha,che.fecha_confirm, che.semana, che.periodo, che.Cuenta, tpag.name as tipopago,
        che.clasificacion,cla.descripcion,che.FolioSantander  
        FROM cheques as che 
        left join user as usu on usu.id=che.beneficiario 
        left join t_cheque as tche on tche.id=che.t_cheque 
        left join programas as pro on pro.id=che.programa 
        left join t_pago as tpag on tpag.id=che.tipopago
        left join clasificacion as cla on cla.id=che.clasificacion 
        where $filtro ";


        if(!$query = mysqli_query($con, $sql)){
            echo mysqli_errno($con);
        } 
            
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
                    <th class="column-title" style="width:310px;">Folio Envio </th>
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
                        $FolioSantander=$r['FolioSantander'];
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
                           
                            $name=$r['nombre'];
                        }else
                        {
                            $name=$r['bennombre'];
                        }

                        
                        $t_gasto=$r['t_cheque'];
                        

                        $periodo=$r['periodo'];
                        $semana=$r['semana'];
                        $concepto=$r['concepto'];
                        //$programa=$r['programa'];
                        $Cuenta=$r['Cuenta'];
                        //$tipop=$r['tipopago'];
                        $programa=$r['programa']; 
                        $tipopago=$r['tipopago'];
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
                   
                    <?php
                    echo'<td>'.$FolioSantander.'</td>';
                    echo'<td>';
                    if($_SESSION['user_tipo']=="1"  || $_SESSION['user_tipo']=="0")
                    {
                        if($r['status']=="1"){
                        ?>
                         <td colspan="1">   
                           <div style="width:10px"><a id="a<?php echo $cont;?>" href="#" class='btn btn-success' title='Aceptar'  onclick="aceptar_cheque('<?php echo $id;?>','<?php echo $cont;?>');"data-toggle="modal" data-target=".bs-example-modal-lg-upd"><i class="fa fa-check"></i></a> </div>
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
        
    }
?>