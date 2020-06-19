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
            <td style="width: 25%; text-align: left;">$ <?php echo $sql_data['monto'];?></td>
            <td style="width: 25%; "></td>
            <td style="width: 25%; "></td>
        </tr>
        <tr>

            <td style="">IVA</td>
            <td style="text-align: left;">$ <?php echo round(($sql_data['iva']),2);?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>

            <td style="">No Autorizado</td>
            <td style="text-align: left;">$ <?php echo round($sql_data['no_apro'],2);?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>

            <td style="">Deducible</td>
            <td style="text-align: left;">$ <?php echo round(($sql_data['deducible']),2);?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>

            <td style="">No Deducible</td>
            <td style="text-align: left;">$ <?php echo round(($sql_data['no_deducible']),2);?></td>
            <td style="text-align: right;">Total</td>
            <td style="text-align: right;">$ <?php echo round(($sql_data['deducible']+$sql_data['no_deducible']),2);?></td>
        </tr>
                
    </table>

        
    
</page>