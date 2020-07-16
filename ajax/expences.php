<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

    include "../config/config.php";//Contiene funcion que conecta a la base de datos

    function folio_fis($id,$folio)
    {
    	global $con;
	    if($folio!="")
	    {
	    	$cons="SELECT * from desglose where comprobante like '%$folio%' and id_cheque='$id' ";
	    	$sql=mysqli_query($con,$cons);
	    	$numero= mysqli_num_rows($sql);

	    	if(($numero*1)>0)
	    	{
	    		return true;
	    	}else
	    	{
	    		return false;
	    	}
	    }else{
	    	return true;
	    }

    	
    }

    function array_multi($array)
    {
        $restem=1;
        $res=0;
        for ($i=0; $i < count($array) ; $i++) { 
            $restem=$restem*$array[$i];
        }
        if($i==0)
            {
                $res=0;
            }else{
                $res=$restem;
            }
        
        return $res;
    }

    function fr($id)
    {
        global $con;
        $res=array();
        $consulta="SELECT * from cheques as c join desglose as d on d.id_cheque=c.id where c.id='$id' ";
        $sql=mysqli_query($con,$consulta);
        while ($sql_data=mysqli_fetch_array($sql))
        {
            if ($sql_data['comprobante']=="") {
                $res[]=0;
            }else
            {
                $res[]=1;
            }
        }
        $res=array_multi($res);
        
        if($res==1)
        {
            echo '<img src="images/palomita.png" width="20px" alt="1" >';

        }else
        {
            echo '<img src="images/tachado.png" width="20px" title="Falta subir facturas o recibos" alt="2">';
     
        }
    }
    
    function reg_ok($id)
    {
        global $con;
        $res=array();
        $fecha=array();        
        $consulta="SELECT * from cheques as c join desglose as d on d.id_cheque=c.id where c.id='$id' ";
        $sql=mysqli_query($con,$consulta);
        while ($sql_data=mysqli_fetch_array($sql))
        {
            $res[]=$sql_data['ok_sup'];
            $fecha[]=$sql_data['fecha_ok_sup'];
        }
        $res=array_multi($res);
        
        if($res==1)
        {
            echo '<img src="images/palomita.png" width="20px" alt="1"  title="Se autoriz&oacute; el '.$fecha[count($fecha)-1].'" >';
        }else
        {
            echo '<img src="images/tachado.png" width="20px" alt="2"  title="Falta autarizaci&oacute;n de Regional">';
        }
    }
    
    function cli_ok($id)
    {
        global $con;
        $res=array();
        $fecha=array();
        $consulta="SELECT * from cheques as c join desglose as d on d.id_cheque=c.id where c.id='$id' ";
        $sql=mysqli_query($con,$consulta);
        while ($sql_data=mysqli_fetch_array($sql))
        {
            $res[]=$sql_data['ok_cli'];
            $fecha[]=$sql_data['fecha_ok_cli'];
        }
        $res=array_multi($res);
        
        if($res==1)
        {
            echo '<img src="images/palomita.png" width="20px" alt="1"  title="Se autoriz&oacute; el '.$fecha[count($fecha)-1].'" >';
        }else
        {
            echo '<img src="images/tachado.png" width="20px" alt="2"  title="Falta autarizaci&oacute;n de el cliente">';
        }
    }
    
    function ad_ok($id)
    {
        global $con;
        $res=array();
        $consulta="SELECT * from cheques as c join desglose as d on d.id_cheque=c.id where c.id='$id' ";
        $sql=mysqli_query($con,$consulta);
        while ($sql_data=mysqli_fetch_array($sql))
        {
            $res[]=$sql_data['si_aid'];
        }

        $res=array_multi($res);
        
        if($res==1)
        {
            echo '<img src="images/palomita.png" alt="1"  width="20px" >';
        }else
        {
            echo '<img src="images/tachado.png" alt="2"  width="20px" title="Falta autarizaci&oacute;n de Operaciones">';
        }
    }
    
    function pago($id)
    {
        global $con;
        $res=0;
        $consulta="SELECT * from cheques  where id='$id' ";
        $sql=mysqli_query($con,$consulta);
        while ($sql_data=mysqli_fetch_array($sql))
        {
            $res=$sql_data['no_cheque'];
            $fecha=$sql_data['fecha_confirm'];
        }
        
        if (($res*1)==0) {
            $res=0;
        }else
        {
            $res=1;
        }
        
        if($res==1)
        {

            $fecha=" title=' Se pago el:  ".$fecha."' " ;
            echo '<img src="images/palomita.png" alt="1"  width="20px" '.$fecha.' >';
        }else
        {
            echo '<img src="images/tachado.png" alt="2"  width="20px"  >';
        }
    }
    
    function verificar($id,$tipo)
    {
        if($tipo=="-2")
        {
            global $con;
            $consulta="SELECT * from desglose where id_cheque='".$id."' ";
            $sql_data=mysqli_query($con,$consulta);
            $num=mysqli_num_rows($sql_data);
            
            $consulta="SELECT * from desglose where id_cheque='".$id."' and si_aid='1' ";
            $sql_data=mysqli_query($con,$consulta);
            $num2=mysqli_num_rows($sql_data);
            
            
            if($num==$num2 and $num!="0")
            {
                
                return true;
            }else
            {

                return false;
            }
            
        }else{
            return true;
        }
        

       
    } 


    function estatus($id)
    {
        global $con;
        $consulta="SELECT * from cheques as che join desglose as des on des.id_cheque=che.id where che.id='$id' ";
        $sql=mysqli_query($con,$consulta);
        $gastos= mysqli_num_rows($sql);
        
        $consulta="SELECT * from cheques as che join desglose as des on des.id_cheque=che.id where (che.id='$id' and des.comprobante!='') or (che.id='$id' and des.deducible='0') ";
        $sql=mysqli_query($con,$consulta);
        $sin_comprobar= mysqli_num_rows($sql);

        $consulta="SELECT * from cheques as che join desglose as des on des.id_cheque=che.id where (che.id='$id' and des.ok_sup='0')  ";
        $sql=mysqli_query($con,$consulta);
        $ok_sup= mysqli_num_rows($sql);

        if(intval($ok_sup)>0)
        {
            return "3";
        }else if((intval($gastos)-intval($sin_comprobar))>0)
        {
            return "2";
        } else{
            return "1";
        }
    }
    function estatus_cli($id)
    {
        global $con;
        $consulta="SELECT * from cheques as che join desglose as des on des.id_cheque=che.id where che.id='$id' ";
        $sql=mysqli_query($con,$consulta);
        $gastos= mysqli_num_rows($sql);
        
        $consulta="SELECT * from cheques as che join desglose as des on des.id_cheque=che.id where (che.id='$id' and des.comprobante!='') or (che.id='$id' and des.deducible='0') ";
        $sql=mysqli_query($con,$consulta);
        $sin_comprobar= mysqli_num_rows($sql);

        $consulta="SELECT * from cheques as che join desglose as des on des.id_cheque=che.id where (che.id='$id' and des.ok_cli='0')  ";
        $sql=mysqli_query($con,$consulta);
        $ok_sup= mysqli_num_rows($sql);

        if(intval($ok_sup)>0)
        {
            return "3";
        }else if((intval($gastos)-intval($sin_comprobar))>0)
        {
            return "2";
        } else{
            return "1";
        }
    }
    session_start();
    $action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    


    if($action == 'ajax'){
        // escaping, additionally removing everything that could be (html/javascript-) code
         //$daterange = mysqli_real_escape_string($con,(strip_tags($_REQUEST['daterange'], ENT_QUOTES)));
		 $status=intval($_REQUEST['status']);
         $user=$_REQUEST['user'];
         $date1=$_REQUEST['date1'];
         $date2=$_REQUEST['date2'];
         @$folio=$_REQUEST['folio'];
       

         if($_REQUEST['page']=="0")
         {
          $arraydate[0]="2015-01-01";
          $arraydate[1]=date("Y-m-d");
         }else{
            //$arraydate[0]=str_replace(" ","",($fecha1[2]."-".$fecha1[1]."-".$fecha1[0])); 
            $arraydate[0]=$date1; 
            $arraydate[1]=$date2;  
         }
         
         //$arraydate[1]=str_replace(" ","",($fecha2[2]."-".$fecha2[1]."-".$fecha2[0]));
                 
        $por_per="";
        if($user!="0")
        {
            $por_per="usu.id='".$user."' and ";
        }

        $filtro="";
        if($_SESSION['user_tipo']=="0" || $_SESSION['user_tipo']=="1" || $_SESSION['user_tipo']=="-2")
        {
          $filtro=" che.programa!='100' and $por_per ";
        }
        
        if($_SESSION['user_tipo']=="3" ||$_SESSION['user_tipo']=="4" )
        {
            
          //$filtro=" che.programa='".$_SESSION['programa']."' and usu.rutas IN ('".str_replace(",","','",$_SESSION['rutas'])."') and  $por_per ";
          $filtro=" che.programa='".$_SESSION['programa']."' and  $por_per ";
        }
        if($_SESSION['user_tipo']=="5"){
             $filtro="  $por_per ";
        }
        if($_SESSION['user_tipo']=="2")
        {
          //$filtro="  usu.id='".$_SESSION['user_id']."' and   ";
          $filtro="    ";
        }

			
        $montof=array();
        $comprobadof=array();
        $balancef=array();
        //main query to fetch the data
        $sql="SELECT  prov.titular,prov.tipocuenta,che.id as id ,che.no_cheque,che.status as status,che.monto,che.bennombre,che.beneficiario,
        tche.name as t_cheque,che.concepto,pro.name as programa,che.fecha,che.fecha_confirm, che.semana, che.periodo, che.Cuenta, tpag.name as tipopago,
        cla.name as clasificacion,cla.descripcion,che.FolioSantander,che.referencia,cs.name as cuentasalida,cs.id as csid  ,gas.id, gas.id_cheque, gas.fecha, gas.fecha_comp, gas.status, gas.t_gasto,che.fecha_pago,che.pago,des.com_val,des.ok_val,des.id

        FROM gastos as gas 
        join cheques as che on che.id=gas.id_cheque 
        join desglose as des on des.id_cheque=gas.id_cheque 
        left join proveedores as prov on prov.id=che.beneficiario 
        left join t_cheque as tche on tche.id=che.t_cheque 
        left join programas as pro on pro.id=che.programa 
        left join t_pago as tpag on tpag.id=che.tipopago
        left join clasificacion as cla on cla.id=che.clasificacion 
        left join cuentasalida as cs on cs.id=che.cuentasalida
         where $filtro    gas.fecha between '$arraydate[0]' and '$arraydate[1]' order by gas.fecha desc ";
        $query = mysqli_query($con, $sql);
        $numrows=mysqli_num_rows($query);
		
		
        //loop through fetched data
        if ($numrows>0){
            
            ?>
            
           
            <table  id="tabla" class="table table-striped jambo_table bulk_action" style="width: 150%;">
                <thead >
                    <tr class="headings" >

                        <th class="column-title" >Folio</th>
                        <th class="column-title" >Pago</th>
                        <th class="column-title" >Gasto</th>
						<th class="column-title" >Forma Pago</th>
						<th class="column-title" >Cuenta</th>
                        <th class="column-title" >Beneficiario</th>
                        <th class="column-title" >CEDIS</th>
                        <th class="column-title" >Solicitud</th>
                        <th class="column-title" >Monto</th>                        
                        <th class="column-title" >Entregado</th>
                        <td class="column-title" >Cuenta salida</td>
                        <th class="column-title" >Cheque</th>
                        <th class="column-title" >Folio de Envio</th>
                        <th class="column-title" >Comprobado</th>
                        <th class="column-title">Por comprobar </th>
                        <th class="column-title" >Factura OK</th>
                        <th class="column-title" >Compl. OK</th>
                        <th class="column-title" >OK Cliente</th>
                        <th class="column-title" >OK Admón</th>
                        <th class="column-title" >Depositado</th>
						<th class="column-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-edit">&nbsp;&nbsp;&nbsp;</th>
						<th class="column-title">&nbsp;&nbsp;&nbsp;<i class="fa fa-cloud-download">&nbsp;</th>
						<th class="column-title">&nbsp;</th>
						                   
				   </tr>
                </thead>
              
                <tbody>
                <?php 
                        while ($r=mysqli_fetch_array($query)) {
                            $id=$r['id'];
                            $check3="";
                            $display3='';
							if($r['ok_val']=="1")
                            {
                                $check3="checked";
                                $display3='style="display:none;"';
                                
                            }
                            $fechaPago=$r['fecha_pago'];
							
							
							$tipopago=$r['tipopago'];

                          
                            
                            $staus_che=$r['status'];
                            
                            
                            if($r['bennombre']=="0")
                            {
                               
                                $titular=$r['titular'];
                            }else
                            {
                                $titular=$r['bennombre'];
                            }
                            $tipocuenta=$r['tipocuenta'];
                            $clasif=$r['clasificacion'];

                            
                            $no_cheque=$r['no_cheque'];
                            $id_cheque=$r['id'];
                            
                            $pago="checked disabled";
                            if($r['pago']==0)
                            {
                                $pago="";
                                if($_SESSION['user_id']=="4")
                                {
                                    $pago="disabled";
                                }
                            }

                            $fecha=$r['fecha'];
                            $fecha_confirm=$r['fecha_confirm'];
                            $Cuenta=$r['Cuenta'];
                            $cuentasalida=$r['cuentasalida'];
                            $csid=$r['csid'];
                            $FolioSantander=$r['FolioSantander'];
                            $description=$r['concepto'];
                            $monto=$r['monto'];
                            $concepto=$r['concepto'];
                            
                            

                          
                            $t_cheque=$r['t_cheque'];
                            $programa=$r['programa'];
                            $comen3=$r['com_val'];


                            $comprovado="SELECT sum(amount+iva) as balance from desglose where ((id_cheque='$id_cheque' and comprobante!='') )  ";
                            $comprovado=mysqli_query($con,$comprovado);
                            $comprovado=mysqli_fetch_array($comprovado);
                            $comprovado=$comprovado['balance'];

                            $balance=$monto-$comprovado;


                            $coin_name = "coin";
                            $querycoin = mysqli_query($con,"SELECT * from configuration where name=\"$coin_name\" ");
                            if ($r = mysqli_fetch_array($querycoin)) {
                                $coin=$r['val'];
                            }
                            
                            /*$consulta="SELECT name from programas where id='".$programa."' ";
                            $sql_data=mysqli_query($con ,$consulta) ;
                            $pro=mysqli_fetch_array($sql_data);
                            $programa=$pro['name'];*/
                           
                            $montof[]=$monto;
                            $comprobadof[]=$comprovado;
                            $balancef[]=$balance;
                           
                            $color="";
                            if(round($balance,0)<=0 && round($comprovado,0)>0){
                                $color='class="success"';
                            }



                            if((round($balance,0)<=0 && round($comprovado,0)>0) && ($status==2) ){
                                //echo$status;
                                continue;

                            }

                            if($color==""  && ($status==1)){
                                //echo$status;
                                continue;
                            }

                            $results=mysqli_fetch_array(mysqli_query($con ,"SELECT email from user where name='$titular'"));
                            @$correo=$results['email'];

                            if(verificar($id_cheque,$_SESSION['user_tipo'])){
                            	if(folio_fis($id_cheque,$folio)){

                ?>
                    <!-- <input type="hidden" value="<?php echo $fecha;?>" id="fecha<?php echo $id;?>"> -->

                    <tr <?php echo $color; ?> style="width:1500px" >
                        <td><div style="width:30px"><?php echo $id_cheque?></div></td>
                        <td><div style="width:50px"><input style="width:45px" value="<?php echo $id_cheque; ?>" type="checkbox" onchange="pago(this);" <?php echo $pago; ?>  > <?php echo $fechaPago;?> </div></td>
						<td><div style="width:130px"><?php echo $t_cheque?></div></td>
						<td><div style="width:90px"><?php  echo $tipopago?></div></td>                       
					    <td><div style="width:150px"><?php echo $Cuenta?></div></td>
						<td><div style="width:250px" style="font-size:12px" ><?php echo utf8_encode($titular); ?></div></td>
                        <td ><div style="width:110px"><?php echo $programa; ?></div></td>
                        <td><div style="width:80px"><?php echo $fecha;?></div></td>
                        <td><div style="width:80px">$<?php echo number_format($monto,2);?></div></td>
                        <td><div style="width:80px"><?php echo $fecha_confirm;?></div></td>
                        <td>
                            <select class="form-control" data-id="<?php echo $id_cheque; ?>" id="cuentasalida" name="cuentasalida" onchange="Editarcuentasalida(this);">
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
                        </td>
                        <td> <div style="width:80px"><?php echo $no_cheque;
                                $archivo = glob("../vouchers/voucher-".$id_cheque.".*");
                        if (!empty($archivo)) {
                            echo "<a style='margin-left: 5px;' href='./vouchers/".$archivo[0]."'  class='btn btn-default'download><i class='glyphicon glyphicon-save'></i></a>";
                        } 
                        ?> </div></td>
                        <td style="width:310px;"><input id="<?php echo 'FS'.$id_cheque;?>" type="text" class="form-control" name="FolioSantander" value="<?php echo $FolioSantander;?>" onkeyup="EditarFolioSantander(this);" data-id="<?php echo $id_cheque; ?>"></td>
                        <td ><div style="width:80px">$<?php echo number_format($comprovado,2); ?></div></td>
                        
                        <td><div style="width:95px">$<?php echo number_format($balance,2); ?></div></td>
						<td><div style="width:75px"><?php fr($id_cheque);?></div></td>
                        <td><div style="width:85px"><?php reg_ok($id_cheque);?></div></td>
                        <td><div style="width:70px"><?php cli_ok($id_cheque);?></div></td>
                        
                        <td><input  type="checkbox" onchange="ok_val(this);" value="<?php echo $id;?>" <?php echo $check3; ?> >
                            <br><input value="<?php echo $comen3; ?>" class="form-control" onkeyup="guarda_com_val(this);" type="text"  <?php echo $display3; ?> id="comen3<?php echo $id;?>"></td>
                        <!--<td><div style="width:70px"><?php ad_ok($id_cheque);?></div></td>-->
                        <td><div style="width:70px"><?php pago($id_cheque);?></div></td>

                             <?php

                        ?>
                                               
                        <td colspan="1">						
		                       <div style="width:10px"><a href="#" class='btn btn-default' title='A&ntilde;adir gasto' onclick="GetCategoriaIncome();obtener_datos('<?php echo $id_cheque;?>' , '<?php echo $titular;?>', '<?php echo $correo;?>');" data-toggle="modal" data-target=".bs-example-modal-lg-udp"><i class="glyphicon glyphicon-edit"></i></a> 
						</div>
						</td>    
					
						<td colspan="1">	
		                       <div style="width:10px"><a target="_blank" href="action/descarga_fac.php?id=<?php echo $id_cheque;?>" class="btn btn-default" title="Descarga de facturas"><i class="fa fa-cloud-download"></i> </a>
                       	</div>
						</td>
					   <?php

                        
                        if($staus_che=='0' && ($_SESSION['user_tipo']=='2' || $_SESSION['user_tipo']=='3' || $_SESSION['user_tipo']=='4') )
                        {
                            ?>
                            <button class="btn btn-default" title="Solicitar" onclick="solicitar_cheque(<?php echo $id_cheque;?>);">
                             <i class="fa fa-check"></i>Autorizar </button>
                            <?php      
                        }
                                    
                        
                                
                                ?>
                    </td>
                    </tr>
                <?php
            }}
                    } //en while
                ?>
                <tr>
                    <td>Total</td>
                    <td></td>
                    <td></td>
                    <td></td>
					<td></td>
					<td></td>
                    <td></td>
                    <td></td>
                    <td>$<?php echo number_format(array_sum($montof),2);?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>$<?php echo number_format(array_sum($comprobadof),2);?></td>
                    <td>$<?php echo number_format(array_sum($balancef),2);?></td>
                    <td></td>
					<td></td>
					<td></td>
					<td></td>
                    <td></td>
					<td></td>
					<td></td>
					<td></td>
                </tr>
               
              </table>
            </div>
            <?php
            $montof=array();
            $comprobadof=array();
            $balancef=array();
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