<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; padding: 5px; }
table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
}
-->
</style>
<?php
            $configuration = mysqli_query($con, "select * from configuration");
        ?>
<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style=" font-size: 12pt; font-family: arial" >
        <page_footer>
            <table class="page_footer" style="font-size: 8PX;">
                <tr>
                    <td style="width: 50%; text-align: left">
                        P&aacute;gina [[page_cu]]/[[page_nb]]&nbsp;&nbsp; <?php echo date('Y-m-d/H:i:s');?>
                    </td>
                    <td style="width: 50%; text-align: right">
                        PROMOTECNICAS Y VENTAS, S.A. DE C.V.
                        
                    </td>
                </tr>
            </table>
        </page_footer>
        <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 80%; font-size: 11px;  ">
                Dirección: Tlacotalpan 112<br>
                Roma Sur, 06760 Ciudad de México, CDMX<br>
                Horario: 9:00 a 18:00<br>
                Teléfono: 01 55 74 8123
            </td>
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
    mysqli_query($con,"SET lc_time_names = 'es_ES'" );
    $query = "SELECT fecha_corte, no_apro, CONCAT( MONTHNAME( fecha_corte ), '-' , YEAR(fecha_corte) ) AS fecha FROM cortes where id='$id'";
    $result=mysqli_query($con,$query);
    
    while($row=mysqli_fetch_array($result)){
        $fechaCorte=$row['fecha_corte'];
        $fechaC=$row['fecha'];
        $no_apro=$row['no_apro'];
    };

    $query_desglose="
SELECT round(sum(des.amount),2) as monto,  round( sum(des.iva),2) as iva, round(sum(des.amount) + sum(des.iva)) as deducible, 
    round(sum(des.amount) + sum(des.iva)) as no_deducible,  round(sum(des.amount) + sum(des.iva))  as no_apro
FROM cortes AS cor
join desglose as des on des.facturacion=cor.id
join cheques as che on che.id=des.id_cheque 
join user as usu on usu.id=che.beneficiario
where cor.id='$id' and des.ok_cli='1'  ";
    $sql_des=mysqli_query($con,$query_desglose);
                $sql_=mysqli_fetch_array($sql_des);       
       $query_comp="
SELECT  round(sum(des.amount) + sum(des.iva),2) as deducible
FROM cortes AS cor
join desglose as des on des.facturacion=cor.id
join cheques as che on che.id=des.id_cheque 
join user as usu on usu.id=che.beneficiario
where cor.id='$id'  and des.deducible='1' ";
    $sql_comp=mysqli_query($con,$query_comp);
                $sql_b=mysqli_fetch_array($sql_comp);      
       $query_comp="
SELECT round(sum(des.amount) + sum(des.iva),2) as no_deducible
FROM cortes AS cor
join desglose as des on des.facturacion=cor.id
join cheques as che on che.id=des.id_cheque 
join user as usu on usu.id=che.beneficiario
where cor.id='$id' and des.deducible='0'  ";
    $sql_comp=mysqli_query($con,$query_comp);
                $sql_c=mysqli_fetch_array($sql_comp);                                  
   
    $consulta="SELECT * from cortes as cor where cor.id='$id'";
                $sql=mysqli_query($con,$consulta);
                $sql_data=mysqli_fetch_array($sql);

    ?>

    <hr>
    <table border="0" cellspacing="10px" style="width: 100%; padding: 0px; ">
        <tr>
            <td style="width: 50%; text-align: left;"><span style="font-size: 11px;">No. Factura <?php echo $sql_data['id'];?></span></td>
            <td style="width: 50%; text-align: right;"><span style="font-size: 11px;">Fecha <?php echo $sql_data['fecha'];?></span></td>
        </tr>
    </table>


   
    <br><br>
    
    <table border="0" cellspacing="10px" style="width: 100%; padding: 0px; font-size: 13px;">
           
                <tr>

                    <td style="width: 25%; ">Monto</td>
                    <td style="width: 25%; text-align: left;">$ <?php echo $sql_['monto'];?></td>
                    <td style="width: 25%; "></td>
                    <td style="width: 25%; "></td>
                </tr>
                <tr>

                    <td style="">IVA</td>
                    <td style="text-align: left;">$ <?php echo round(($sql_['iva']),2);?></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>

                    <td style="">No Autorizado</td>
                    <td style="text-align: left;">$ <?php echo $no_apro;?></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>

                    <td style="">Deducible</td>
                    <td style="text-align: left;">$ <?php echo round(($sql_b['deducible']),2);?></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>

                    <td style="">No Deducible</td>
                    <td style="text-align: left;">$ <?php echo round(($sql_c['no_deducible']),2);?></td>
                    <td style="text-align: right;">Total</td>
                    <td style="text-align: right;">$ <?php echo round(($sql_b['deducible']+$sql_c['no_deducible']),2);?></td>
                </tr>
                
    </table>
    <hr>

    <?php
    

$consulta="
SELECT des.id_cheque, des.id, usu.name, des.amount, des.iva, des.description, CONCAT( MONTHNAME( des.fecha_ok_cli ), '-' , YEAR(des.fecha_ok_cli) ) AS fecha
FROM cortes AS cor
join desglose as des on des.facturacion=cor.id
join cheques as che on che.id=des.id_cheque 
join user as usu on usu.id=che.beneficiario
where cor.id='$id' ";
mysqli_query($con,"SET lc_time_names = 'es_ES'" );
$sql=mysqli_query($con,$consulta);


    ?>
<table style="width: 100%; font-size: 12px;" cellspacing="0" >
    <?php
    while ($sql_data=mysqli_fetch_array($sql)) {
        ?>
        <tr style=" border-bottom: 1px solid #bbb;">
            <td style="border-bottom: 1px solid #bbb; width: 5%;"><?php echo $sql_data['id_cheque'];?></td>
			<td style="border-bottom: 1px solid #bbb; width: 5%;"><?php echo $sql_data['id'];?></td>
            <td style="border-bottom: 1px solid #bbb; width: 30%;"><?php echo $sql_data['name'];?></td>
            <td style="border-bottom: 1px solid #bbb; width: 10%;">$ <?php echo round($sql_data['amount'],2);?></td>
            <td style="border-bottom: 1px solid #bbb; width: 10%;">$ <?php echo round($sql_data['iva'],2);?></td>
            <td style="border-bottom: 1px solid #bbb; width: 25%;"><?php echo $sql_data['description'];?></td>
            <td style="border-bottom: 1px solid #bbb; width: 15%;"><?php echo $fechaC;?></td>
        </tr>
        <?php
    }
    ?>
    
</table>
        
    
</page>