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
      if(isset($_GET['s'])){
            switch ($_GET['s']) {
                case '0':
                    $filtro=" che.status='0' and che.fecha='$daterange' and che.pagoservicio!='1'  ";
                    if($daterange==''){
                        $filtro=" che.status='0' and che.pagoservicio!='1'  ";
                    }
                    
                break;
                
                case'1':
                    $filtro=" che.status='1' and che.fecha='$daterange' and che.pagoservicio!='1'   ";
                    if($daterange==''){
                        $filtro=" che.status='1' and che.pagoservicio!='1'  ";
                    }
                break;

                case'2':
                    $filtro=" che.status='2' and che.fecha='$daterange' and che.pagoservicio!='1' and che.autorizado='0' ";
                    if($daterange==''){
                        $filtro=" che.status='2' and che.pagoservicio!='1' and che.autorizado='0' ";
                    }
                break;

                case's':
                    $filtro=" che.fecha='$daterange' and che.pagoservicio='1'  ";
                    if($daterange==''){
                        $filtro=" che.pagoservicio='1'  ";
                    }
                break;
            }
        }else{

          $filtro=" che.status='1' or (che.fecha='$daterange' and che.status='1')  ";
        }

    }else if($_SESSION['user_tipo']=="2" || $_SESSION['user_tipo']=="3" || $_SESSION['user_tipo']=="5" || $_SESSION['user_tipo']=="4" )
    {
      //$filtro="  che.programa='".$_SESSION['programa']."' and usu.rutas IN ('".str_replace(",","','",$_SESSION['rutas'])."')  ";
      $filtro="  che.programa='".$_SESSION['programa']."'  ";

    }else if($_SESSION['user_tipo']=="0")
    {
        $filtro=" ( che.programa!='0')  ";
    }

    if($action == 'ajax'){
        
        // escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
         $aColumns = array('id');//Columnas de busqueda
            

        

        $sql="SELECT prov.titular,prov.tipocuenta,che.id as id ,che.no_cheque,che.status as status,che.monto,che.bennombre,che.beneficiario,
        tche.name as t_cheque,che.concepto,pro.name as programa,che.fecha,che.fecha_confirm, che.semana, che.periodo, che.Cuenta, tpag.name as tipopago,
        che.clasificacion,cla.descripcion,che.FolioSantander,che.referencia,cs.name as cuentasalida,cs.id as csid  
        FROM cheques as che 
        left join proveedores as prov on prov.id=che.beneficiario 
        left join t_cheque as tche on tche.id=che.t_cheque 
        left join programas as pro on pro.id=che.programa 
        left join t_pago as tpag on tpag.id=che.tipopago
        left join clasificacion as cla on cla.id=che.clasificacion 
        left join cuentasalida as cs on cs.id=che.cuentasalida
        where $filtro   order by che.FolioSantander desc";


        if(!$query = mysqli_query($con, $sql)){
            echo mysqli_errno($con);
        } 
            
        ?>
        <table class="table table-striped jambo_table bulk_action" style="width :150%;">
            <thead>
                <tr class="headings" >
                    <th class="column-title">Periodo</th>
                    <th class="column-title">Semana</th>
                    <th class="column-title">Gasto </th>
                    <th class="column-title">Clasificaci&oacute;n</th>
                    <th class="column-title">Descripci&oacute;n</th>
                    <th class="column-title">Beneficiario </th>
                    <th class="column-title">Tipo Cuenta</th>
                    <th class="column-title">Programa </th>
                    <th class="column-title">Solicitud </th>
                    <th class="column-title">Monto </th>                        
                    <th class="column-title">Entregado</th>
                    <th class="column-title">Tipo dePago</th>
                    <th class="column-title">Cuenta deposito</th>
                    <th class="column-title">Cuenta de Salida</th>                    
                    <th class="column-title">No. Cheque </th>
                    <th class="column-title" style="width:310px;">Folio Envio </th>
                    <th class="column-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th class="column-title">&nbsp;&nbsp;&nbsp;&nbsp;✓&nbsp;</th>
                    <th class="column-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;×&nbsp;</th>
                    <th class="column-title">Autorizar</th>
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
                           
                            $titular=$r['titular'];
                        }else
                        {
                            $titular=$r['bennombre'];
                        }
                        $tipocuenta=$r['tipocuenta'];

                        
                        $t_gasto=$r['t_cheque'];
                        $referencia=$r['referencia'];                        

                        $periodo=$r['periodo'];
                        $semana=$r['semana'];
                        $concepto=$r['concepto'];
                        //$programa=$r['programa'];
                        $Cuenta=$r['Cuenta'];
                        $cuentasalida=$r['cuentasalida'];
                        $csid=$r['csid'];
                        //$tipop=$r['tipopago'];
                        $programa=$r['programa']; 
                        $clasificacion=$r['descripcion']; 
                        $tipopago=$r['tipopago'];
                        $fecha_entrega=$r['fecha_confirm'];
                        $fecha=$r['fecha'];
            ?>
                <input type="hidden" value="<?php echo $titular;?>" id="name<?php echo $id;?>">
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
                    <td><div style="width:200px"><?php echo $clasificacion;?></div></td>
                    <td><div style="width:200px"><?php echo $concepto;?></div></td>
                    <td><div style="width:200px"><?php echo utf8_encode($titular);?></div></td>
                    <td><div style="width:200px"><?php echo $tipocuenta;?></div></td>
                    <td><div style="width:100px"><?php echo $programa;?></div></td>
                    <td><div style="width:150px"><?php echo $fecha; ?></div></td>
                    <td><div style="width:150px">$<?php echo number_format($monto,2);?></div></td>
                    <td><div style="width:150px"><?php echo $fecha_entrega; ?></div></td>
                    <td><div style="width:150px"><?php echo $tipopago; ?></div></td>
                    <td><div style="width:200px"><?php echo $Cuenta; ?></div></td>
                    <td>
                        <div style="width:200px">
                            <?php
                            if ($r['status']=="1")
                            {?> 
                                <select class="form-control" data-id="<?php echo $id; ?>" id="cuentasalida" name="cuentasalida" required="required" onchange="Editarcuentasalida(this);">
                                    <option value="<?php echo $csid;?>"><?php echo $cuentasalida;?></option>
                                    <optgroup>
                                    <?php
                                    $categories = mysqli_query($con,"SELECT * from cuentasalida");
                                    while ($cat=mysqli_fetch_array($categories)) { ?>
                                    <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                                    <?php 
                                    } 
                                    ?>
                                </optgroup>
                                </select>
                                 <?php
                            }else{
                                echo $cuentasalida;
                            }?>
                        </div>
                    </td>
                    <?php
                    
                    

                        
                        if($tipopago!="Transferencia"){
                            if (($_SESSION['user_tipo']=="1" ||  $_SESSION['user_tipo']=="0") && $r['status']=="1")
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

                        }else{
                            echo'<td></td>';
                        }
                        
                    
                    ?>
                   
                    <?php
                    if ( $r['status']=="1")
                    {
                        echo'<td><div style="width:300px"><input id="FS'.$id.'" type="text" class="form-control" name="FolioSantander" value="'.$FolioSantander.'" onkeyup="EditarFolioSantander(this);" data-id="'.$id.'"></div></td>';
                    }else{
                        echo'<td><div style="width:300px">'.$FolioSantander.'</div></td>';
                    }
                    
                    echo'<td>';
                    if($_SESSION['user_tipo']=="1"  || $_SESSION['user_tipo']=="0")
                    {
                        if($r['status']=="1"){
                        ?>
                         <td colspan="1">   
                           <div style="width:10px"><a id="a<?php echo $cont;?>" href="#" class='btn btn-success' title='Aceptar'  onclick="aceptar_cheque('<?php echo $id;?>','<?php echo $cont;?>','<?php echo $tipopago;?>');"data-toggle="modal" data-target=".bs-example-modal-lg-upd"><i class="fa fa-check"></i></a> </div>
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


                    <td>
                        <?php if($_SESSION['user_tipo']=="1"){
                            echo '<center><input type="checkbox" data-id="'.$id.'" name="autorizarcheck"></center>';
                        }?>
                        
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