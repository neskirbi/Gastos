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
                <tr>
                    <td style="width: 50%; text-align: left">
                        P&aacute;gina [[page_cu]]/[[page_nb]]
                    </td>
                    <td style="width: 50%; text-align: right">
                        
                    </td>
                </tr>
            </table>
        </page_footer>
<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
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

        $consulta="SELECT name as nombre, id from user where name!='' $where $usu  order by id";
        $sql1=mysqli_query($con,$consulta);

        $cont=0;

        while($data_user=mysqli_fetch_array($sql1))
        {

        $consulta="SELECT che.concepto,che.programa,che.no_cheque,che.fecha,che.id as id_cheque,che.monto,che.fecha_confirm from gastos as gas join cheques as che on che.id=gas.id_cheque  where (gas.fecha between '$fecha' and '$fecha2' ) and che.beneficiario='".$data_user['id']."' ";
        $sql=mysqli_query($con,$consulta);
        $sql3 = mysqli_query($con,$consulta);
        
        $numrows=mysqli_num_rows($sql);
       //loop through fetched data
        if ($numrows>0){
            $importett=array();
            $ivatt=array();
            $monto_chequestt=array();

            $nodeducible=0;
            $deducible=0;
              
            while($r_importe=mysqli_fetch_array($sql3))
            {
                $consulta2="SELECT * from desglose where id_cheque='".$r_importe['id_cheque']."'";
                            $sql33=mysqli_query($con,$consulta2);
                while ($r_importe1=mysqli_fetch_array($sql33)) 
                {

                    $importett[]=floatval($r_importe1['amount']);
                    $ivatt[]=$r_importe1['iva'];
                }
                $monto_chequestt[]=$r_importe['monto'];
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
                   
            }
                
            ?>
             <table cellspacing="0" style="width: 20%;  text-align: left ; font-size: 9.5pt;padding:1mm;">
                <tr>
                    <td style=' border: 1px solid black; font-size: 11pt;' colspan="2"><?php echo $data_user['nombre']?></td>
                </tr>
                <tr>
                    <td style=' border: 1px solid black;' style="width: 80%;">Deducible</td>
                    <td style=' border: 1px solid black;'><?="$".number_format($deducible,2)?></td>
                </tr>
                <tr>
                    <td style=' border: 1px solid black;'>No Deducible</td>
                    <td style=' border: 1px solid black;'><?="$".number_format($nodeducible,2)?></td>
                </tr>
                <tr>
                    <td style=' border: 1px solid black;'>Total</td>
                    <td style=' border: 1px solid black;'><?="$".number_format($total_final,2)?></td>
                </tr>
                <tr>
                    <td style=' border: 1px solid black;'>Diferecia</td>
                    <td style=' border: 1px solid black;'><?="$".number_format($diferencia_final,2)?></td>
                </tr>
            </table>
            
                <br>
                
                    
                
                
                    <?php
                    while($r=mysqli_fetch_array($sql))
                    {
                        ?>
                        <table cellspacing="0" style="width: 100%;  text-align: left; font-size: 9.5pt;padding:1mm; border: 1px solid black;">
                   
                        <tr>
                            <th style='width: 11%;'>Concepto </th>
                            <th style='width: 9%;'>Importe </th>
                            <th style='width: 8%;'>IVA</th>
                            <th style='width: 8%;'>Otros Gastos</th>
                            <th style='width: 8%;'>Total</th>
                            <th style='width: 8%;'>Fecha</th>
                            <th style='width: 8%;'>No.Cheque</th>
                            <th style='width: 8%;'>Monto</th>
                            <th style='width: 8%;'>Fecha Cheque</th>
                            <th style='width: 8%;'>Fecha deposito</th>
                            <th style='width: 8%;'>Diferencia</th>
                            <th style='width: 8%;'>Observacion</th>
                        </tr>
                   
                        <?php
                        $importet=array();
                        $ivat=array();
                        $ogastost=array();
                        $totalt=array();

                        $consulta2="SELECT * from desglose where id_cheque='".$r['id_cheque']."'";
                        $sql2=mysqli_query($con,$consulta2);
                        while ($r2=mysqli_fetch_array($sql2)) 
                        {
                            $importett[]=$importet[]=$importe=floatval($r2['amount']);
                            $ivatt[]=$ivat[]=$iva=$r2['iva'];
                            $totalt[]=$total=$iva+$importe;
                            $ogastost[]=0;
                            ?>
                        <tr>
                            <td><?php echo $r2['description'];?></td>
                            <td>$<?php echo number_format($importe,2);?></td>
                            <td>$<?php echo number_format($iva,2);?></td>
                            <td>------</td>
                            <td>$<?php echo number_format($total,2);?></td>
                            <td><?php echo $r2['created_at'];?></td>
                            <td></td>
                            <td></td>
                            <td>------</td>
                            <td>------</td>
                            <td>------</td>
                            <td><?php echo $r2['comentario'];?></td>
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
                            <td style="text-align: justify;"><?php echo $r['concepto'];?></td>
                            <td>$ <?php echo number_format(($importef),2);?></td>
                            <td>$ <?php echo number_format(($ivaf),2);?></td>
                            <td>$ <?php echo number_format(array_sum($ogastost),2);?></td>
                            <td>$ <?php echo number_format(($totalf),2);?></td>
                            <td></td>
                            <td><?php echo $r['no_cheque'];?></td>
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
                        </table>
                        <br>
                        <br>
                        <?php
                        $cont++;
                    }
                    ?>
            
            
            <?php
        
        }else{   
        }
    }
  
?>
</page>