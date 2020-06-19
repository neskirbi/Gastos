
<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
}
-->
</style>
<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
        <page_footer>
        <table class="page_footer">
        <?php
            $configuration = mysqli_query($con, "select * from configuration");
        ?>
            <tr>
                <td style="width: 50%; text-align: left">
                    P&aacute;gina [[page_cu]]/[[page_nb]]
                </td>
                <td style="width: 50%; text-align: right">
                     <?php echo "PROMOTECNICAS Y VENTAS S.A. DE C.V."; echo  $anio=date('Y'); ?>
                </td>
            </tr>
        </table>
    </page_footer>
    <table cellspacing="0" style="width: 100%;">
        <tr>
        <?php foreach ($configuration as $settings) { ?> 
        <?php if ($settings['name']=="logo") { ?>
            <td style="width: 25%; color: #444444;">
                <img style="width: 40%;" src="../../images/<?php echo $settings['val']; ?>" alt="Logo"><br>
            </td>
        <?php } ?>   
		<?php } //end foreach ?>   
            <td style="width: 75%;text-align:right">
                <h2 style="color: #16a085;">Gastos</h2>
            </td>
        </tr>
    </table>

	
	<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
		<tr>
			<td style="width: 100%;text-align:right">
			Fecha: <?php echo date("d/m/Y");?>
			</td>
		</tr>
	</table>

    <br>
  
    

	<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');




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

    $action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    


    if($action == 'ajax'){
        // escaping, additionally removing everything that could be (html/javascript-) code
         $daterange = mysqli_real_escape_string($con,(strip_tags($_REQUEST['daterange'], ENT_QUOTES)));
		 $arraydate=explode("-", $daterange);
         $fecha1=explode("/",$arraydate[0]);
         $fecha2=explode("/",$arraydate[1]);

         
         
         $arraydate[0]=str_replace(" ","",($fecha1[2]."-".$fecha1[1]."-".$fecha1[0]));   
         
         
         $arraydate[1]=str_replace(" ","",($fecha2[2]."-".$fecha2[1]."-".$fecha2[0]));

          $filtro="";
        if($_SESSION['user_tipo']=="0" || $_SESSION['user_tipo']=="1")
        {
          $filtro=" che.programa!='0' and ";
        }
        if($_SESSION['user_tipo']!="2" and $_SESSION['user_tipo']!="0"  and $_SESSION['user_tipo']!="1")
        {
          $filtro=" che.programa='".$_SESSION['programa']."' and usu.rutas IN ('".str_replace(",","','",$_SESSION['rutas'])."') and   ";
        }
        if($_SESSION['user_tipo']=="2")
        {
          $filtro="  usu.id='".$_SESSION['user_id']."' and   ";
        }
			
        $montof=array();
        $comprobadof=array();
        $balancef=array();
        //main query to fetch the data
         $sql="SELECT gas.id, gas.id_cheque, gas.fecha, gas.fecha_comp, gas.status, gas.t_gasto FROM gastos as gas join cheques as che on che.id=gas.id_cheque join user as usu on usu.id=che.beneficiario where $filtro gas.fecha between '$arraydate[0]' and '$arraydate[1]' order by gas.fecha desc ";
        $query = mysqli_query($con, $sql);
        $numrows=mysqli_num_rows($query);
        //loop through fetched data
        if ($numrows>0){
            
            ?>
            <table border="1" style="font-size: 11px; border-collapse:  collapse; ">
                <thead>
                    <tr style="background-color: #3F5367; color: #fff;">

                        <th style="padding: 8px;" class="column-title">Tipo de gasto </th>
                        <th style="padding: 8px;" class="column-title">Concepto </th>
                        <th style="padding: 8px;" class="column-title">Beneficiario </th>
                        <th style="padding: 8px;" class="column-title">Programa </th>
                        <th style="padding: 8px;" class="column-title">Fecha de Solicitud </th>
                        <th style="padding: 8px;" class="column-title">Monto </th>                        
                        <th style="padding: 8px;" class="column-title">Fecha de entrega</th>
                        <th style="padding: 8px;" class="column-title">No. Cheque </th>
                        <th style="padding: 8px;" class="column-title">Comprobado </th>
                        <th style="padding: 8px;" class="column-title">X Comprobar </th>
                    </tr>
                </thead>
                
                <?php 
                        while ($r=mysqli_fetch_array($query)) {
                            $consulta="SELECT * from cheques where id='".$r['id_cheque']."'";
                            $sql=mysqli_query($con,$consulta);
                            $sql_data=mysqli_fetch_array($sql);
                            
                            if($sql_data['bennombre']=="0")
                            {
                                $consulta_n="SELECT * from user where id='".$sql_data['beneficiario']."'";
                                $sql_n=mysqli_query($con,$consulta_n);
                                $sql_data_n=mysqli_fetch_array($sql_n);
                                $nombre=$sql_data_n['name'];
                            }else
                            {
                                $nombre=$sql_data['bennombre'];
                            }

                            
                            $no_cheque=$sql_data['no_cheque'];
                            $id_cheque=$r['id_cheque'];
                            $fecha=$sql_data['fecha'];
                            $fecha_confirm=$sql_data['fecha_confirm'];
                            $description=$sql_data['concepto'];
                            $monto=$sql_data['monto'];
                            
                            

                            $consulta2="SELECT * from t_cheque where id='".$sql_data['t_cheque']."'";
                            $sql2=mysqli_query($con,$consulta2);
                            $sql_data2=mysqli_fetch_array($sql2);
                            $name_category=$sql_data2['name'];


                            $comprovado="SELECT sum(amount+iva) as balance from desglose where ((id_cheque='$id_cheque' and comprobante!='') or (id_cheque='$id_cheque' and deducible='0')) and ok_cli='1'  ";
                            $comprovado=mysqli_query($con,$comprovado);
                            $comprovado=mysqli_fetch_array($comprovado);
                            $comprovado=$comprovado['balance'];

                            $balance=$monto-$comprovado;


                            $coin_name = "coin";
                            $querycoin = mysqli_query($con,"select * from configuration where name=\"$coin_name\" ");
                            if ($r = mysqli_fetch_array($querycoin)) {
                                $coin=$r['val'];
                            }
                            $concepto=$sql_data['concepto'];
                            $programa=$sql_data['programa'];
                            $consulta="SELECT name from programas where id='".$programa."' ";
                            $sql_data=mysqli_query($con ,$consulta) ;
                            $pro=mysqli_fetch_array($sql_data);
                            $programa=$pro['name'];
                           
                            $montof[]=$monto;
                            $comprobadof[]=$comprovado;
                            $balancef[]=$balance;
                ?>
                    <!-- <input type="hidden" value="<?php echo $fecha;?>" id="fecha<?php echo $id;?>"> -->

                    <tr class="even pointer">
                        <td style="padding: 8px;" ><?php echo $name_category;?></td>
                        <td style="padding: 8px;" ><?php echo $concepto?></td>
                        <td style="padding: 8px;" ><?php echo $nombre; ?></td>
                        <td style="padding: 8px;" ><?php echo $programa; ?></td>
                        <td style="padding: 8px;" ><?php echo $fecha;?></td>
                        <td style="padding: 8px;" >$<?php echo number_format($monto,2);?></td>                        
                        <td style="padding: 8px;" ><?php echo $fecha_confirm;?></td>
                        <td style="padding: 8px;" ><?php echo $no_cheque;?></td>
                        <td style="padding: 8px;" >$<?php echo number_format($comprovado,2);; ?></td>
                        <td style="padding: 8px;" >$<?php echo number_format($balance,2);; ?></td>
                        
                    </tr>
                <?php
                    } //en while
                ?>
                <tr>
                    <td style="padding: 8px;" >Total</td>
                    <td style="padding: 8px;" ></td>
                    <td style="padding: 8px;" ></td>
                    <td style="padding: 8px;" ></td>
                    <td style="padding: 8px;" ></td>
                    <td style="padding: 8px;" >$<?php echo number_format(array_sum($montof),2);?></td>
                    <td style="padding: 8px;" ></td>
                    <td style="padding: 8px;" ></td>
                    <td style="padding: 8px;" >$<?php echo number_format(array_sum($comprobadof),2);?></td>
                    <td style="padding: 8px;" >$<?php echo number_format(array_sum($balancef),2);?></td>
                    
                </tr>
              </table>
            
            <?php
            $montof=array();
            $comprobadof=array();
            $balancef=array();
        }else{
           ?> 
            
        <?php    
        }
    }
?>
  

</page>
