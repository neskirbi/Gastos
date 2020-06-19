<?php

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    include "../config/config.php";
    session_start();
    $fecha= $_REQUEST['fecha'];
    $fecha2= $_REQUEST['fecha2'];
    $user= $_REQUEST['user'];
    $cat=$_REQUEST['cat'];
    $cat_fil='';
    if ($cat!='') {
        $cat_fil=" and category_id='$cat' ";
    }

    $usu="";
    if($user!="0")
    {
        $usu="and id='$user' ";
    }
    $where="";
    if($_SESSION['user_tipo']=="0" || $_SESSION['user_tipo']=="1")
    {
    }else{
        $where=" and programa='".$_SESSION['programa']."' ";
        
    }

        $consulta="SELECT name as nombre,id from user where name!='' $where $usu  order by id";
        $sql1=mysqli_query($con,$consulta);
        
        $contid=0;
        $cont=0;
        while($data_user=mysqli_fetch_array($sql1))
        {
        $consulta="SELECT che.concepto,che.programa,che.no_cheque,che.fecha,che.id as id_cheque,che.monto,che.fecha_confirm from gastos as gas join cheques as che on che.id=gas.id_cheque  where (gas.fecha between '$fecha' and '$fecha2' ) and che.beneficiario='".$data_user['id']."' ";
        $sql=mysqli_query($con,$consulta);
        
        $numrows=mysqli_num_rows($sql);
       //loop through fetched data
        
            if($numrows>0)
            {
                $importett=array();
                    $ivatt=array();
                    $monto_chequestt=array();
            ?>
            <table border="1" class="table table-striped jambo_table bulk_action" style="font-size: 10px; width: 30%;">
                <tr>
                    <td colspan="2"><?php echo $data_user['nombre']?></td>
                </tr>
                <tr>
                    <td style="width: 80%;">Deducible</td>
                    <td><div id="d<?php echo $contid; ?>"></div></td>
                </tr>
                <tr>
                    <td>No Deducible</td>
                    <td><div id="nd<?php echo $contid; ?>"></div></td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td><div id="t<?php echo $contid; ?>"></div></td>
                </tr>
                <tr>
                    <td>Diferecia</td>
                    <td><div id="di<?php echo $contid; ?>"></div></td>
                </tr>
            </table>
            <table border="1" class="table table-striped jambo_table bulk_action" style="font-size: 10px;">
                
                    
                
                
                    <?php
                    
                    while($r=mysqli_fetch_array($sql))
                    {
                        ?>
                        

                    <thead>
                        <tr class="headings">
                            <th class="column-title">Categoria </th>
                            <th class="column-title">Descripci&oacute;n </th>
                            <th class="column-title">Importe </th>
                            <th class="column-title">IVA</th>
                            <th class="column-title">Total</th>
                            <th class="column-title">Fecha</th>
                            <th class="column-title">No.Cheque</th>
                            <th class="column-title">Monto</th>
                            <th class="column-title">Fecha Cheque</th>
                            <th class="column-title">Fecha deposito</th>
                            <th class="column-title">Diferencia</th>
                            <th class="column-title">Fecha aprobaci&oacute;n</th>
                            <th class="column-title">Observaci&oacute;n</th>
                        </tr>
                    </thead>
                    
                            
                        <?php
                        $importet=array();
                        $ivat=array();
                        $ogastost=array();
                        $totalt=array();

                        $consulta2="SELECT * from desglose as d join category_income as c on c.id=d.category_id where d.id_cheque='".$r['id_cheque']."' $cat_fil ";
                        $sql2=mysqli_query($con,$consulta2);
                        while ($r2=mysqli_fetch_array($sql2)) 
                        {
                            $importett[]=$importet[]=$importe=floatval($r2['amount']);
                            $ivatt[]=$ivat[]=$iva=$r2['iva'];
                            $totalt[]=$total=$iva+$importe;
                            
                            ?>
                            <tr>
                            <td><?php echo $r2['name'];?></td>
                            <td><?php echo $r2['description'];?></td>
                            <td>$<?php echo number_format($importe,2);?></td>
                            <td>$<?php echo number_format($iva,2);?></td>
                           
                            <td>$<?php echo number_format($total,2);?></td>
                            <td><?php echo $r2['created_at'];?></td>
                            <td></td>
                            <td></td>
                            <td>------</td>
                            <td>------</td>
                            <td>------</td>
                            <td><?php echo $r2['fecha_ok_cli'];?></td>
                            <td><?php echo $r2['com_cli'];?></td>
                        </tr>
                        <?php
                        }
                        $cpro="SELECT * from programas where id='".$r['programa']."'";
                        $sqlpro=mysqli_query($con,$cpro);
                        $pro=mysqli_fetch_array($sqlpro);
                        $programa=$pro['name'];
                        $importef=array_sum($importet);
                        $ivaf=array_sum($ivat);
                        $totalf=$importef+$ivaf;
                        $monto_chequestt[]=$monto_chequesf=$r['monto'];
                        $diferenciaf=$monto_chequesf-$totalf;
                        ?>
                        

                        
                        

                        <tr>
                            <td><?php echo $r['concepto'];?></td>
                            <td></td>
                            <td>$ <?php echo number_format(($importef),2);?></td>
                            <td>$ <?php echo number_format(($ivaf),2);?></td>
                           
                            <td>$ <?php echo number_format(($totalf),2);?></td>
                            <td></td>
                            <td><center><?php echo $r['no_cheque'];?></center></td>
                            <td>$<?php echo number_format($monto_chequesf,2);?></td>
                            <td><?php echo $r['fecha'];?></td>
                            <td><?php echo $r['fecha_confirm'];?></td>
                            <td>$ <?php echo number_format(($diferenciaf),2);?></td>
                            <td>------</td>
                        </tr>
                        <?php
                        $importet=array();
                        $ivat=array();
                        $ogastost=array();
                        $totalt=array();
                        ?>
                        <tr><td colspan="13"></td></tr>

                        <?php
                        $cont++;
                    }
                    ?>
            
              </table>
                
            <?php
            //echo "<br>".count($importett);
            //echo "<br>".count($ivatt);
            $nodeducible=0;
            $deducible=0;
            for($i=0;$i<count($importett);$i++)
            {
                if($ivatt[$i]==0)
                {
                    $nodeducible=$nodeducible+$importett[$i];
                }
                else
                {
                    $deducible=$deducible+$importett[$i]+$ivatt[$i];
                }
            }


            $total_final=array_sum($monto_chequestt);
            $diferencia_final=$total_final-($deducible+$nodeducible);
            echo"
<script>
valores(".json_encode("$".number_format($deducible,2)).",".json_encode("$".number_format($nodeducible,2)).",".json_encode("$".number_format($total_final,2)).",".json_encode("$".number_format($diferencia_final,2)).",".$contid.");


</script>




            ";
        }
            
        
    $contid++;
}
    if ($cont>0){
        }else{
           ?> 
            <div class="alert alert-warning alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Aviso!</strong> No hay datos para mostrar
            </div>
        <?php
  }
?>