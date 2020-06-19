<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
}
-->
</style>
<?php
            $configuration = mysqli_query($con, "select * from configuration");
        ?>
<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
        <page_footer>
            <table class="page_footer" style="font-size: 8PX;">
                <tr>
                    <td style="width: 50%; text-align: left">
                        P&aacute;gina [[page_cu]]/[[page_nb]]
                    </td>
                    <td style="width: 50%; text-align: right">
                        PROMOTECNICAS Y VENTAS, S.A. DE C.V.
                        
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
            
        </tr>
    </table>
<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    
    
    $consulta="SELECT des.o_impuestos,des.ret_iva,des.iva,des.amount as monto,cat.name as catego,usu.name as bene,tche.name as tipo,che.id as id  from  category_income as cat   left join desglose as des on (des.category_id=cat.id and des.id_cheque='$id' ) left join cheques as che on che.id=des.id_cheque left join t_cheque as tche on tche.id=che.t_cheque left join user as usu on usu.id=che.beneficiario   ";

    $consulta2="SELECT che.id,che.no_cheque as no_cheque ,che.concepto,tche.name as tipo,usu.name as nombre,pro.name as programa  from cheques as che join t_cheque as tche on tche.id=che.t_cheque join user as usu on usu.id=che.beneficiario join programas as pro on pro.id=usu.programa where che.id='$id' ";
    
    $sql2=mysqli_query($con,$consulta2);
    
    $sql=mysqli_query($con,$consulta);
    
    $sql_data2=mysqli_fetch_array($sql2);
    
    echo"<div style='text-align:center; width:100%;'><h4>".$sql_data2["tipo"]."</h4></div>";
    ?>
    <table style="width: 100%; font-size:11px; border-collapse: collapse;">
        <tr>
            <td style="width: 20%;">Nombre</td>
            <td style="width: 40%;"><?php echo $sql_data2['nombre'] ;?></td>
            <td style="width: 40%;"></td>
        </tr>
        <tr>
            <td style="width: 20%;">Proyecto</td>
            <td style="width: 40%;"><?php echo $sql_data2['programa'] ;?></td>
            <td style="width: 40%;"></td>
        </tr>
        <tr>
            <td style="width: 20%;">No. cheque</td>
            <td style="width: 40%;"><?php echo $sql_data2['no_cheque'] ;?></td>
            <td style="width: 40%;"></td>
        </tr>
        <tr>
            <td style="width: 20%;">Concepto</td>
            <td style="width: 40%;"><?php echo $sql_data2['concepto'] ;?></td>
            <td style="width: 40%; text-align: right;">No. Folio. <?php echo $sql_data2['programa'].$sql_data2['id'] ;?></td>
        </tr>
        <tr>
            <td style="width: 20%;">&nbsp;</td>
            <td style="width: 40%;"></td>
            
        </tr>
    </table>
        
        <table style="width: 100%; font-size:8px; border-collapse: collapse;" border="1px" > 
            <tr>
                <th style="text-align: center; width: 10%;">Cuenta</th>
                <th style="text-align: center; width: 40%;">Concepto</th>
                <th style="text-align: center; width: 10%;">Subtotal</th>
                <th style="text-align: center; width: 10%;">Otros Impuestos</th>
                <th style="text-align: center; width: 10%;">IVA</th>
                <th style="text-align: center; width: 10%;">Retencion IVA</th>
                <th style="text-align: center; width: 10%;">Total</th>
            </tr>
    <?php
    
    $cont=1;

$t1=array();
$t2=array();
$t3=array();
$t4=array();
$t5=array();
    while($data_user=mysqli_fetch_array($sql))
    {

        $t1[]=$data_user["monto"];
        $t2[]=$data_user["o_impuestos"];
        $t3[]=$data_user["iva"];
        $t4[]=$data_user["ret_iva"];
        $t5[]=$data_user["monto"]+$data_user["iva"];

        ?>
        <tr>
         <td style="text-align: center;"><?php echo $cont ;?></td>
         <td style=""><?php echo $data_user["catego"];?></td>
         <td style="text-align: right;"><?php echo number_format($data_user["monto"],2) ;?></td>
         <td style="text-align: right;"><?php echo number_format($data_user["o_impuestos"],2) ;?></td>
         <td style="text-align: right;"><?php echo number_format($data_user["iva"],2) ;?></td>
         <td style="text-align: right;"><?php echo number_format($data_user["ret_iva"],2) ;?></td>
         <td style="text-align: right;"><?php echo number_format($data_user["monto"]+$data_user["iva"],2);?></td>
        </tr>
        <?php
        $cont++;
    }

    $consulta="SELECT sum(des.amount) as no_dedu from  desglose as des  where des.id_cheque='$id' and des.deducible='0' ";
    $sql=mysqli_query($con,$consulta);
    $sql_data=mysqli_fetch_array($sql);
  
?>

        <tr style="background-color: #ABB1BA;">
            <td> </td>
            <td>NO DEDUCIBLE</td>
            <td style="text-align: right;"><?php echo number_format($sql_data['no_dedu'],2);?></td>
            <td style="text-align: right;">--- </td>
            <td style="text-align: right;">--- </td>
            <td style="text-align: right;">--- </td>
            <td style="text-align: right;"><?php echo number_format($sql_data['no_dedu'],2);?></td>
        </tr>

        <tr>
            <td> </td>
            <td>TOTAL</td>
            <td style="text-align: right;"><?php echo number_format(array_sum($t1),2);?></td>
            <td style="text-align: right;"><?php echo number_format(array_sum($t2),2);?></td>
            <td style="text-align: right;"><?php echo number_format(array_sum($t3),2);?></td>
            <td style="text-align: right;"><?php echo number_format(array_sum($t4),2);?></td>
            <td style="text-align: right;"><?php echo number_format(array_sum($t5),2);?></td>
        </tr>

        <tr style="background-color: #ABB1BA;">
            <td> </td>
            <td>TOTAL NO DEDUCIBLE (%46)</td>
            <td style="text-align: right;"><?php echo number_format(($sql_data['no_dedu'])*.46,2);?></td>
            <td style="text-align: right;">--- </td>
            <td style="text-align: right;">--- </td>
            <td style="text-align: right;">--- </td>
            <td style="text-align: right;"><?php echo number_format(($sql_data['no_dedu'])*.46,2);?></td>
        </tr>
</table>
</page>