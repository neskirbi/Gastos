<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

    include "../config/config.php";//Contiene funcion que conecta a la base de datos
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
    session_start();
    $action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    


    if($action == 'ajax'){
        // escaping, additionally removing everything that could be (html/javascript-) code
         $daterange = mysqli_real_escape_string($con,(strip_tags($_REQUEST['daterange'], ENT_QUOTES)));
		 $category=intval($_REQUEST['category']);

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
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                    <tr class="headings">

                        <th class="column-title">Tipo de gasto </th>
                        <th class="column-title">Concepto </th>
                        <th class="column-title">Beneficiario </th>
                        <th class="column-title">Programa </th>
                        <th class="column-title">Fecha de Solicitud </th>
                        <th class="column-title">Monto </th>                        
                        <th class="column-title">Fecha de entrega</th>
                        <th class="column-title">No. Cheque </th>
                        <th class="column-title">Comprobado </th>
                        <th class="column-title">X Comprobar </th>
                        <?php
                            if($_SESSION['user_tipo']=="5")
                            {
                                ?>
                                <th></th>
                                <?php
                            }
                        ?>
                        <th class="column-title"></th>
                    </tr>
                </thead>
                <tbody>
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


                            $comprovado="SELECT sum(amount+iva) as balance from desglose where (id_cheque='$id_cheque' and comprobante!='') or (id_cheque='$id_cheque' and deducible='0')  ";
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
                        <td><?php echo $name_category;?></td>
                        <td><?php echo $concepto?></td>
                        <td ><?php echo $nombre; ?></td>
                        <td ><?php echo $programa; ?></td>
                        <td><?php echo $fecha;?></td>
                        <td>$<?php echo number_format($monto,2);?></td>
                        
                        <td><?php echo $fecha_confirm;?></td>
                        <td><?php echo $no_cheque;?></td>
                        <td >$<?php echo number_format($comprovado,2);; ?></td>
                        
                        <td >$<?php echo number_format($balance,2);; ?></td>
                        
                             <?php
                            if($_SESSION['user_tipo']=="5")
                            {
                                $estatus=estatus($id_cheque);
                                switch($estatus)
                                {
                                    case "1":
                                    ?>
                                        <td ><span ><i class="fa fa-exclamation-triangle btn-success"></i></span></td>
                                    <?php
                                    break;
                                    case "2":
                                    ?>
                                        <td ><span ><i class="fa fa-exclamation-triangle btn-warning"></i></span></td>
                                    <?php
                                    break;
                                    case "3":
                                    ?>
                                        <td ><span ><i class="fa fa-exclamation-triangle btn-danger"></i></span></td>
                                    <?php
                                    break;
                                }
                                
                            }
                        ?>
                        
                       
                        <td ><span class="pull-right">
                        <a href="#" class='btn btn-default' title='A&ntilde;adir gasto' onclick="obtener_datos('<?php echo $id_cheque;?>');" data-toggle="modal" data-target=".bs-example-modal-lg-udp"><i class="glyphicon glyphicon-edit"></i></a> 
                        <!--<a href="#" class='btn btn-default' title='Borrar producto' onclick="eliminar('<?php echo $id; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>s</span>--></td>
                    </tr>
                <?php
                    } //en while
                ?>
                <tr>
                    <td>Total</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>$<?php echo number_format(array_sum($montof),2);?></td>
                    <td></td>
                    <td></td>
                    <td>$<?php echo number_format(array_sum($comprobadof),2);?></td>
                    <td>$<?php echo number_format(array_sum($balancef),2);?></td>
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